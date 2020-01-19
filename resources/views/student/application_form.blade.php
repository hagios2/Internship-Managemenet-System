@extends('layouts.app')

@section('title', 'Internship App')

@section('content')

    <div class="container">

        if({{ $toggleapp->toggle }})
          
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">Internship Application form</li>
            </ol>
          </nav><br>


        <div class="" style="width:60%;">

            @include('includes.errors')

            <div>

                <div class="accordion" id="accordionExample">
                    <div class="card">
                      <div class="card-header" id="headingOne">
                        <h2 class="mb-0">
                          <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                Default Application
                          </button>
                        </h2>
                      </div>
                  
                      <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                        <div class="card-body">
                                    
                                        
                            <form method="POST" action="/internshipapply" enctype="multipart/form-data">

                                @csrf

                                <div class="form-group">

                                        <table class="table ">

                                            <thead>
                                                <tr>
                                                    <th></th> 
                                                    <th>Company</th>
                                                    <th>Region</th>
                                                    <th>Location</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                    
                                                @forelse ($companies as $company)

                                                <tr>

                                                    <td>
                                                        <div class="form-group form-check">
                                                            <input style="margin-right:rem;" type="radio" name="company_id" value="{{ $company->id }}" {{ old('company_id') == $company->id ? 'selected' : '' }} class="form-check-input" id="exampleCheck1">
                                                        </div>
                                                    </td>
                                                    
                                                    <td>
                                                        <div class="form-group ">
                                                    
                                                            <label class="form-check-label" for="exampleCheck1">{{ $company->company_name }}</label>
                                                    </div>
                                                    </td>

                                                    <td>

                                                        {{ $company->region->region }}

                                                    </td>

                                                    <td>

                                                        {{ $company->location }}

                                                    </td>

                                                @empty

                                                    <h3 class="title">Currently Not Available</h3>
                                                
                                                @endforelse
                                                    
                                                </tr>

                                            </tbody>

                                        </table>

                                    <div class="form-group">

                                        <label for="">Attach resume</label>
                                        <input class="form-control-file" type="file" name="resume" id="">

                                    </div>

                                </div> <br<br>

                                <button class="btn btn-primary" type=submit>Apply</button>
                            
                            </form>


                        </div>
                      </div>
                    </div>
                    <div class="card">
                      <div class="card-header" id="headingTwo">
                        <h2 class="mb-0">
                          <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            Collapsible Group Item #2
                          </button>
                        </h2>
                      </div>
                      <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                        <div class="card-body">

                               {{-- Application with Proposed compnay --}}

                                <div>

                                    <div class="alert alert-info text-center">

                                        <h5> <span class="glyphicon glyphicon-info-sign"></span>  <strong> You may only choose this option if you are certain about your application to the company </strong> </h5>

                                    </div>

                                    <form action="" method="post" enctype="multipart/form-data">

                                    <div class="form-group">

                                        <input class="form-control" name="proposed_company" placeholder="Proposed Company">

                                    </div><br>


                                    <div>
                                        
                                        <input class="form-control" name="proposed_company_location" placeholder="Enter location">
                                        
                                    </div><br>

                                    <div class="form-group">

                                        <select name="company_location" class="form-control">

                                            <option value="">Select City</option>


                                            @foreach ($locations as $location)

                                                <option value="{{ $location->id }}" {{ old('company_location') == $location->id ? 'selected' : '' }} >{{ $location->region}} </option>
                                            
                                            @endforeach

                                        </select>

                                    </div> 

                                    <div>

                                        <label for="">Attach resume</label>
                                        <input type="file" name="resume" id="">

                                    </div>

                                    <button class="btn btn-primary" type=submit>Apply</button>

                                </form>

                            </div>

                        </div>
                      </div>
                    </div>
                    <div class="card">
                      <div class="card-header" id="headingThree">
                        <h2 class="mb-0">
                          <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            Collapsible Group Item #3
                          </button>
                        </h2>
                      </div>
                      <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                        <div class="card-body">

                            <div>

                                <div class="alert alert-info text-center">
                    
                                    <h5><span class="glyphicon glyphicon-info-sign"></span><strong>Request an open letter</strong></h5>
                    
                                    <form action="" method="post">
                                        
                                        <div class="form-group">
                    
                                            <input class="form-control" name="student_name" placeholder="Enter name" type="text">
                        
                                        </div><br>
                    
                                           
                                        <div class="form-group">
                    
                                            <input type="tel" class="form-control" name="phone" placeholder="Enter phone number">
                        
                                        </div><br>
                    
                    
                                        <div class="form-group">
                    
                                            <select name="level" class="form-control">
                        
                                                <option value="" {{ old('level') == "100"}}>Select your city</option>
                        
                                                @foreach ($locations as $location)
                        
                                                    <option value="{{ $location->id }}" {{ old('company_location') == $location->id ? 'selected' : '' }} >{{ $location->region}} </option>
                                                
                                                @endforeach
                        
                                            </select>
                        
                                        </div> 
                    
                                        <button class="btn btn-primary" type=submit>Apply</button>
                    
                                    </form>
                    
                                </div>
                    
                    
                            </div>
                    
                        </div>
                    
                        
                        </div>
                      </div>
                    </div>
                  </div>
            </div>
@endSection
