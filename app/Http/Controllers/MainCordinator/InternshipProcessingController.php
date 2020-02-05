<?php

namespace App\Http\Controllers\MainCordinator;

use App\User;
use App\Company;
use App\Notification;
use App\InternshipApplication;
use App\OtherApplicationApproved;
use App\Jobs\SendIntroductoryLetter;
use App\ApprovedApplication;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProposedApplicationResource;
use App\Http\Resources\RequestOpenLetterResource;

class InternshipProcessingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:main_cordinator');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('main_cordinator.student_application');
    }

    public function proposed_application()
    {
        $application = InternshipApplication::where('preferred_company', true)->get();

        return ProposedApplicationResource::collection($application);

    }

    public function request_open_letter()
    {
        $application = InternshipApplication::where('open_letter', true)->get();

        return RequestOpenLetterResource::collection($application);

    }

    public function other_application()
    {
        return view('main_cordinator.other_application');
    }


    public function getStudent()
    {
        return User::where('name', 'like', request()->search, '%')->get('id', 'name');


        return request()->search;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function default_application()
    {
        return redirect('/main-cordinator/company')->with('info', ' Click on a company to view student who applied for that company');
    }

    public function sendIntroductoryLetter(ApprovedApplication $application, Request $request)
    {

        if(!$application->approved)
        {
            return back()->with('info', 'Please ensure application to this company has been approved');
        }

        $request->validate([

            'letter' => 'required|file|mimes:pdf|max:1999',

        ]);

        $fileName = $request->file('letter')->getClientOriginalName();

        request()->file('letter')->storeAs('public/Letters/'.$application->id, $fileName);

        $application->approved_letter = 'storage/Letters/'.$application->id.'/'.$fileName;

        $application->save();

        $token = 'fkrG_0OWD-A:APA91bHUcbg08Mu7yZ6yw8kDuVTr4YI9L82_H6yZAbvc5iwSoJHBkX_gSyYNa2vgDBqOZ8rxFuUy0gFY8O6lWjL9csxLYly9PeYqr8AUw17lpFIwxkR3VYN1CJXDz4u7NLZnW31lUrgp';
        
        Notification::toSingleDevice($token, 'Trial title', 'trial body', null, null);

        //SendIntroductoryLetter::dispatch($application);

        return back()->withSuccess('Introductory letter Sent'); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function deny_application(InternshipApplication $application)
    {
        $application->delete();

        return back()->withSuccess($application->student->name . ' removed from applicants list');
    }

    public function approve_application(Company $company)
    {

        if($company->application->count() > 0)
        {
        
            if($company->approved_application)
            {
                return back()->with('info', 'Application has already aubeen approved');
            }   

            ApprovedApplication::create([

                'company_id' => $company->id,

                'approved' => true
            ]);
        
        }else{

            return back()->with('error', 'Failed! '.$company->company_name .' has no application(s)');
        }

        return back()->withSuccess('Application Approved. You may Send introductory letter now');
    }


    public function previewFile(ApprovedApplication $application)
    {

        return response()->file($application->approved_letter);
    }

    public function removeFile(ApprovedApplication $application)
    {
        Storage::disk('public')->deleteDirectory('Letters/'.$application->id. '/');

        $application->approved_letter = null;

        $application->save();

       return back()->withSuccess('Attachment removed.');

    }

    public function approveAll()
    {
        $applications = InternshipApplication::where(['preferred_company', true])->get();

        $count = 0;

        foreach($applcations as $application)
        {
            if(!$application->proposedApplication){
                
                $this->proposalApproval($application);

                $count++;
            }
        }

        return back()->withSuccess('{$count} Application(s) approved');

    }


    public function approveProposedApplication(InternshipApplication $application)
    {
        if($application->approvedProposedApplicaton)
        {
            return back()->with('info', 'Application has already been approved');
        }
         
        $this->proposalApproval($application);

        return back()->withSuccess('Application approved');
    }

    public function revertProposedApplication(OtherApplicationApproved $application)
    {
        if(!$application){

            return back()->with('error', 'Request Application not found!');
        }

        $application->delete();

        return back()->withSuccess('Reverted Approval');
    }

    public function proposalApproval(InternshipApplication $application)
    {
        OtherApplicationApproved::create([

            'application_id' => $application->id,
            
            'approved' => true,
        ]) ;

    }

}