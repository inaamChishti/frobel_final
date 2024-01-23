@extends('layouts.auth')

@section('styles')
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <link href="{{ asset('assets/libs/datetimepicker/css/classic.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/libs/datetimepicker/css/classic.date.css') }}" rel="stylesheet" />
    <style>
        #star {
            color: red
        }

        input::placeholder {
            font: 18px sans-serif;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid flex-grow-1 container-p-y">
        <h2 class="font-weight-bold py-3 mb-4">
            <span class="text-muted font-weight-light">Students /</span> Edit student
        </h2>
        <div class="row">
            <div class="col-xl-12 mx-auto">


                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Student Form -->
                <div class="row">
                    <div class="col-xl-12 mx-auto">
                        {{--
               <hr>
               --}}
                        <div
                            class="card border-top border-0 border-4 border-info"style="box-shadow: 1px 1px 4px 6px	#b0516a;margin-bottom:30px;">
                            <div class="card-body">
                                <div class="border p-4 rounded">
                                    <div class="card-title d-flex align-items-center">
                                        <div><i class="bx bxs-user me-1 font-22 text-info"></i>
                                        </div>
                                        <h5 class="mb-0 text-info">Student Form</h5>
                                    </div>
                                    <hr>

                                    <form method="POST" class="form-horizontal"
                                        action="{{ route('admin.admission.update') }}">
                                        @csrf
                                        <!-- Form hidden ids -->
                                        <input type="hidden" name="student_id" value="{{ @$student->studentid }}">
                                        <input type="hidden" name="guardian_id" value="{{ @$guardianData->Guardianid }}">
                                        <input type="hidden" name="kin_id" value="{{ @$kinDetails->kinid }}">
                                        <input type="hidden" name="admission_id" value="{{ @$admission->admissionid }}">
                                        <input type="hidden" name="payment_id" value="{{ @$payment->paymentid }}">

                                        <div class="row mb-3">

                                            <div class="col-md-3 mb-3">
                                                <label for="" style="font-weight: bold; font-size:18px;">Family
                                                    ID</label>

                                                <input type="text" name="family_id" readonly="readonly"
                                                    class="form-control" value="{{ @$admission->familyno }}">
                                            </div>

                                            <div class="col-md-3 mb-3">
                                                <label for="" style="font-weight: bold; font-size:18px;">Form
                                                    Filling Date <span id="star"
                                                        style="font-size:12px;">(required)</span> </label>
                                                <input type="text" name="form_date" class="form-control datepicker"
                                                    placeholder="dd-mm-yyyy"
                                                    value="{{ old('form_date', @$admission ? @$admission->formfilingdate : '') }}">
                                            </div>

                                            <div class="col-md-3 mb-3">
                                                <label for="" style="font-weight: bold; font-size:18px;">Joining
                                                    Date <span id="star"
                                                        style="font-size:12px;">(required)</span></label>
                                                <input type="text" name="joining_date" class="form-control datepicker"
                                                    placeholder="dd-mm-yyyy"
                                                    value="{{ @$admission->joiningdate ? @$admission->joiningdate : '' }}">
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label for="family status" style="font-weight: bold; font-size:18px;">Status
                                                    <span id="star" style="font-size:12px;">(required)</span></label>
                                                <select name="family_status" class="form-control">
                                                    <option selected disabled>Choose</option>

                                                    <option {{ @$admission->familystatus == 'Active' ? 'selected' : '' }}
                                                        value="Active">Active</option>
                                                    <option
                                                        {{ @$admission->familystatus == 'De-Active' ? 'selected' : '' }}
                                                        value="De-Active">De-Active</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <button type="button" id="add-row" class="btn btn-primary" style="margin-bottom:20px;">Add Row</button>

                                            <table class="table table-bordered table-highlight">
                                                <thead>
                                                    <td style="font-weight: bold; font-size:18px;">First Name <span
                                                            id="star" style="font-size:12px;">(required)</span></td>
                                                    <td style="font-weight: bold; font-size:18px;">Surname <span
                                                            id="star" style="font-size:12px;">(required)</span></td>
                                                    <td style="font-weight: bold; font-size:18px;">Date of Birth <span
                                                            id="star" style="font-size:12px;">(required)</span></td>
                                                    <td style="font-weight: bold; font-size:18px;">Gender <span
                                                            id="star" style="font-size:12px;">(required)</span></td>
                                                            <td style="font-weight: bold; font-size:18px;">Hours</td>
                                                    <td style="font-weight: bold; font-size:18px;">Years</td>
                                                    <td style="font-weight: bold; font-size:18px;">student status</td>
                                                    <td style="font-weight: bold; font-size:18px;">Medical Condition</td>
                                                    <td style="font-weight: bold; font-size:18px;">Action</td>

                                                </thead>
                                                <tbody id="tbody" class="table1">
                                                    <!-- First Student -->
                                                    <tr id="template-row" style="" class="">
                                                        <input type="hidden" name="old_name_first" value="{{ @$student->studentname }}" >
                                                        <input type="hidden" name="old_name_2nd"  value="{{ @$student->studentsur }}" >

                                                        <td><input type="text"
                                                                onkeypress="return /[a-z]/i.test(event.key)"
                                                                name="first_name_1[]" class="form-control"
                                                                value="{{ @$student->studentname }}" placeholder="first name"></td>
                                                        <td><input type="text"
                                                                onkeypress="return /[a-z]/i.test(event.key)"
                                                                name="surname_1[]" class="form-control" placeholder="surname"
                                                                value="{{ @$student->studentsur }}"></td>
                                                        <td><input type="text" name="dob_1[]"
                                                                class="form-control datepicker" placeholder="dd-mm-yyyy"
                                                                value="{{ str_replace('-', '/', date('d-m-Y', strtotime(@$student->studentdob))) }}">
                                                        </td>
                                                        <td>

                                                            <select name="gender_1[]"
                                                                class="form-control"style=" font-size:17px;">
                                                                <option selected disabled>Choose</option>
                                                                <option @if (@$student->studentgender === 'male' || @$student->studentgender === 'Male') selected @endif
                                                                    value="male">Male</option>
                                                                <option @if (@$student->studentgender === 'female' || @$student->studentgender === 'Female') selected @endif
                                                                    value="female">Female</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input type="text" name="hours[]"
                                                                class="form-control" placeholder="" onkeypress="return /\d/.test(event.key)"
                                                                value="{{@$student->studenthours}}">
                                                        </td>
                                                        <td>
                                                            <select name="years_in_school_1[]" class="form-control"
                                                                style=" font-size:17px;">
                                                                <option  disabled>Choose</option>
                                                                <option selected @if (@$student->studentyearinschool == 0) selected @endif
                                                                    value="0">0 Year</option>
                                                                <option  @if (@$student->studentyearinschool == 1) selected @endif
                                                                    value="1">1 Year</option>
                                                                <option @if (@$student->studentyearinschool == 2) selected @endif
                                                                    value="2">2 Year</option>
                                                                <option @if (@$student->studentyearinschool == 3) selected @endif
                                                                    value="3">3 Year</option>
                                                                <option @if (@$student->studentyearinschool == 4) selected @endif
                                                                    value="4">4 Year</option>
                                                                <option @if (@$student->studentyearinschool == 5) selected @endif
                                                                    value="5">5 Year</option>
                                                                <option @if (@$student->studentyearinschool == 6) selected @endif
                                                                    value="6">6 Year</option>
                                                                <option @if (@$student->studentyearinschool == 7) selected @endif
                                                                    value="7">7 Year</option>
                                                                <option @if (@$student->studentyearinschool == 8) selected @endif
                                                                    value="8">8 Year</option>
                                                                <option @if (@$student->studentyearinschool == 9) selected @endif
                                                                    value="9">9 Year</option>
                                                                <option @if (@$student->studentyearinschool == 10) selected @endif
                                                                    value="10">10 Year</option>
                                                                <option @if (@$student->studentyearinschool == 11) selected @endif
                                                                    value="11">11 Year</option>
                                                                <option @if (@$student->studentyearinschool == 12) selected @endif
                                                                    value="12">12 Year</option>
                                                                <option @if (@$student->studentyearinschool == 13) selected @endif
                                                                    value="13">13 Year</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <select name="student_status[]" class="form-control">
                                                                <option value="active" {{ @$student->student_status == 'active' ? 'selected' : '' }}>Active</option>
                                                                <option value="inactive" {{ @$student->student_status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                                            </select>
                                                        </td>

                                                        <td id="unq"   >
                                                            <div class="form-check" style=" display: none;">
                                                                <input class="form-check-input" style="  margin-top: 12px;" type="checkbox" id="medEnable">


                                                        <button type="button" id="btn"
                                                        style="width: 160px; "
                                                        class="btn btn-primary add-condition" data-toggle="modal" data-target="#condition-modal">
                                                        Medical condition
                                                        </button>
                                                        <input type="text" style="display:none "  class="conSurname" name="conSurname[]" value="">
                                                        <input type="text" style="display:none "   class="conFirst_name" name="conFirst_name[]" value="">
                                                        <input type="text" style="display:none "  class="conDob" name="conDob[]" value="">

                                                    </td>
                                                    <td><button type="button" style=" display: none;"
                                                        class="btn btn-danger remove-row">Remove</button>
                                                    </td>

                                                    <td style=" border: none;">
                                                        <div class="modal fade" id="condition-modal" tabindex="-1" role="dialog" aria-labelledby="condition-modal-label"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog" role="document" style="max-width:70%;box-shadow: 1px 1px 4px 6px #b0516a; ">
                                                            <div class="modal-content" >
                                                                <div class="modal-header">
                                                                    <div class="header-content">
                                                                        <div class="logo-container">
                                                                            <img src="{{ asset('img/logo-frobel.jpg') }}" width="200px" height="70px;" alt="Frobel Logo">
                                                                        </div>
                                                                        <div class="title-container">
                                                                            <h2 class="modal-title" id="condition-modal-label">Medical Information Form</h2>
                                                                            <h5 class="subtitle">For students with medical conditions at school</h5>
                                                                        </div>
                                                                        <div class="button-container">
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            <div class="modal-body" style=" height: 300px;
                                                                overflow-y: scroll;">


                                                                <div style="text-align: center;">
                                                                    <h3>Frobel Education</h3>
                                                                    <h5>Medical Details Form</h5>
                                                                </div>
                                                                <hr>

                                                                <div class="container">
                                                                    <h4 class="text-info">Medical Condition</h4>
                                                                    <hr>
                                                                    <div class="row">
                                                                      <div class="col-md-6 mb-3">
                                                                        <label for="surname" class="form-label">Doctor Name:</label>
                                                                        <input type="text"  onkeypress="return /[a-zA-Z\s]/i.test(event.key)" class="form-control" id="msurname" name="doctor_name_arr[]" >
                                                                      </div>
                                                                      <div class="col-md-6 mb-3">
                                                                        <label for="first_name" class="form-label">Doctor Number:</label>
                                                                        <input type="number"  oonkeypress="return /\d/.test(event.key)" class="form-control" id="mfirst_name" name="doctor_number_arr[]" >
                                                                      </div>

                                                                    </div>
                                                                    <div class="mb-3">
                                                                      <label for="address" class="form-label">Address:</label>
                                                                      <textarea class="form-control" id="maddress" name="maddresss_arr[]" rows="3" ></textarea>
                                                                    </div>
                                                                </div>
                                                                <hr>
                                                                   </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                    <button type="button" class="btn btn-primary save-condition">Save</button>
                                                                </div>

                                                            </div>

                                                        </div>

                                                        </div>
                                                        </div>
                                                        </div>

                                                    </td>


                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>




                <div style="display: flex;justify-content:space-between">
                    <!-- Gaurdian Form -->
                    <div class="row"
                        style="margin-right:20px;flex-basis: 50%;
         flex-grow: 1;
         flex-shrink: 1;">
                        <div class="col-xl-12 mx-auto">
                            {{--
               <hr>
               --}}
                            <div class="card border-top border-0 border-4 border-info"
                                style="box-shadow: 1px 1px 4px 6px	#039dfe;margin-bottom:30px;padding-bottom:52px;">
                                <div class="card-body">
                                    <div class="border p-4 rounded">
                                        <div class="card-title d-flex align-items-center">
                                            <div><i class="bx bxs-user me-1 font-22 text-info"></i>
                                            </div>
                                            <h5 class="mb-0 text-info">Parent/Guardian Details</h5>
                                        </div>
                                        <hr>
                                        <div class="row mb-3">

                                            <div class="col-md-6">
                                                <label for="name"style="font-weight: bold; font-size:18px;">Name <span
                                                        id="star" style="font-size:12px;">(required)</span></label>
                                                <input type="text" name="guardian_name" class="form-control"
                                                    placeholder="name"
                                                    onkeypress="return /[a-z]/i.test(event.key)"
                                                    value="{{ @$guardianData->guardianname }}" />
                                            </div>

                                            <div class="col-md-6">
                                                <label
                                                    for="surname"style="font-weight: bold; font-size:18px;">Email<span
                                                        id="star" style="font-size:12px;">(required)</span></label>
                                                <input type="text" name="guardian_email" class="form-control"
                                                    placeholder="email" value="{{ @$guardianData->guardiantel }}" required />
                                            </div>

                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="mobile"style="font-weight: bold; font-size:18px;">Address
                                                    <span id="star" style="font-size:12px;">(required)</span></label>
                                                    <textarea name="guardian_address" class="form-control" placeholder="Address" rows="3">{{ @$guardianData->guardianaddress }}</textarea>

                                            </div>
                                            <div class="col-md-6">
                                                <label
                                                    for="telephome"style="font-weight: bold; font-size:18px;">Mobile</label>
                                                <input type="text" name="guardian_mobile" class="form-control" onkeypress="return /\d/.test(event.key)"
                                                    placeholder="Mobile no" value="{{ @$guardianData->guardianmob }}" />
                                            </div>
                                        </div>


                                        {{-- <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="city"style="font-weight: bold; font-size:18px;">City
                                                    <span id="star"></span></label>
                                                <input type="text" name="guardian_city" class="form-control"
                                                    onkeypress="return /[a-z]/i.test(event.key)" placeholder="mobile no"
                                                    value="{{ @$student->guardian->city }}" />
                                            </div>
                                            <div class="col-md-6">
                                                <label for="postal_code"
                                                    style="font-weight: bold; font-size:18px;">Zip/Postal Code <span
                                                        id="star" style="font-size:12px;">(required)</span></label>
                                                <input type="text" name="guardian_postalCode" class="form-control"
                                                    placeholder="phone no"
                                                    value="{{ @$student->guardian->postal_code }}" />
                                            </div>
                                        </div> --}}

                                        {{-- <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label
                                                    for="guardian_address"style="font-weight: bold; font-size:18px;">Address
                                                    Line 1<span id="star"></span></label>
                                                <input name="guardian_address" class="form-control" cols="50"
                                                    rows="5" placeholder="Enter address"
                                                    value="{{ @$student->guardian->address }}" />
                                            </div>

                                            <div class="col-md-6">
                                                <label
                                                    for="guardian_Streetaddress"style="font-weight: bold; font-size:18px;">Address
                                                    Line 2 <span id="star"></span></label>
                                                <input name="guardian_Streetaddress" class="form-control" cols="50"
                                                    rows="5"
                                                    placeholder="Enter address"value="{{ @$student->guardian->street_address }}" />
                                            </div>

                                        </div> --}}

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- Kin Form -->
                    <div class="row" style="flex-basis: 50%;
         flex-grow: 1;
         flex-shrink: 1;"
                        id="student_2">
                        <div class="col-xl-12 mx-auto">
                            {{--
               <hr>
               --}}
                            <div
                                class="card border-top border-0 border-4 border-info"style="box-shadow: 1px 1px 4px 6px	#f07910;margin-bottom:30px;">
                                <div class="card-body">
                                    <div class="border p-4 rounded">
                                        <div class="card-title d-flex align-items-center">
                                            <div><i class="bx bxs-user me-1 font-22 text-info"></i>
                                            </div>
                                            <h5 class="mb-0 text-info">Next of Kin Details</h5>
                                        </div>
                                        <hr>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="surname"
                                                    style="font-weight: bold; font-size:18px;">Name</label>
                                                <input type="text" onkeypress="return /[a-z]/i.test(event.key)"
                                                    name="kin_name" class="form-control" placeholder="name"
                                                    onkeypress="return /[a-z]/i.test(event.key)"
                                                    value="{{ @$kinDetails->kinname }}" />
                                            </div>

                                            <div class="col-md-6">
                                                <label for="surname"
                                                    style="font-weight: bold; font-size:18px;">Email</label>
                                                <input type="text" onkeypress="return /[a-z]/i.test(event.key)"
                                                    name="kin_email" class="form-control" placeholder="Email"
                                                    value="{{  @$kinDetails->kintel }}" />
                                            </div>

                                        </div>



                                        <hr>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="surname"
                                                    style="font-weight: bold; font-size:18px;">Address</label>
                                                <input type="text" name="kin_address" class="form-control"
                                                    placeholder="Address" value="{{ @$kinDetails->kinaddress }}" />
                                            </div>
                                            <div class="col-md-6">
                                                <label for="surname"
                                                    style="font-weight: bold; font-size:18px;">Mobile</label>
                                                <input type="text" name="kin_mobile" class="form-control"    onkeypress="return /\d/.test(event.key)"
                                                    placeholder="Mobile" value="{{ @$kinDetails->kinmob }}" />
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-12">

                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-12">

                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-12">

                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-12">

                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-12">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>


                </div>



                  <!-- mEDICAL Form -->
                  <div class="row" id="student_2" style="flex-basis: 50%;
                  flex-grow: 1;
                  flex-shrink: 1;
                  min-height:700px;
                  ">
                    <div class="col-xl-12 mx-auto">

                        <div class="card border-top border-0 border-4 border-info"
                                style="box-shadow: 1px 1px 4px 6px	#b0516a;margin-bottom:30px;">


                            <div class="modal-body" style=" min-height: 300px; border: 0.5px solid #D3D3D3;
                            margin:25px;padding:20px;
                            border-radius:5px;">



                                 <div class="container">
                                    <h4 class="text-info">Medical Condition</h4>
                                    <hr>
                                    <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="surname"  class="form-label"style="font-weight: bold; font-size:18px;">Doctor Name:</label>
                                        <input type="text"  onkeypress="return /[a-zA-Z\s]/i.test(event.key)" class="form-control" id="msurname" value="{{@$medicalCondition->drName}}" name="msurname" >
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="first_name" class="form-label"style="font-weight: bold; font-size:18px;">Doctor Number:</label>
                                        <input type="text" class="form-control"  onkeypress="return /[0-9!@#$%^&*()_+{}\[\]:;<>,.?~\\-]/.test(event.key)"  id="mfirst_name"  value="{{@$medicalCondition->drNumber}}" name="mfirst_name" >
                                    </div>

                                    </div>
                                    <div class="mb-3">
                                    <label for="address" class="form-label"style="font-weight: bold; font-size:18px;">Address:</label>
                                    <textarea class="form-control" id="maddress"  name="maddress" rows="3" >{{@$medicalCondition->medicalDetails}}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div></div>

                    <!-- Other detail Form -->
                <div class="row" id="student_2" style="flex-basis: 50%;
                flex-grow: 1;
                flex-shrink: 1;">
                    <div class="col-xl-12 mx-auto"  style="">

                        <div class="card border-top border-0 border-4 border-info"
                        style="box-shadow: 1px 1px 4px 6px #b96edd; margin-bottom: 30px; width: 98%; margin-left: 1%;">
                            <div class="card-body" >
                                <div class="border p-5 rounded">
                                    <div class="card-title d-flex align-items-center">
                                        <div><i class="bx bxs-user me-1 font-22 text-info"></i>
                                        </div>
                                        <h5 class="mb-0 text-info">See Other detail</h5>
                                    </div>
                                    <hr>
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label for="medical_condition" style="font-weight: bold; font-size:18px;">Does Any Child Have Medical Conditions?</label>
                                            <textarea name="medical_condition" class="form-control" cols="50" rows="5" placeholder="comment here">{{ @$admission->medicalcondition }}</textarea>

                                        </div>
                                        <div class="col-md-12">
                                            <label for="Fee Details"style="font-weight: bold; font-size:18px;">Fee Details
                                                <span id="star" style="font-size:12px;">(required)</span></label>
                                            <input type="text" name="fee_detail" class="form-control"
                                                placeholder="fee detail" value="{{ @$admission->feedetail }}" required/>
                                        </div>
                                    </div>

                                    <div class="row mb-3">


                                        <div class="col-md-12">
                                            <label for="surname" style="font-weight: bold; font-size:18px;">
                                                Initial Payment <span id="star"
                                                    style="font-size:12px;">(required)</span></label>
                                            <select name="payment_method" class="form-control" style=" font-size:17px;">
                                                <option selected disabled>Choose an option</option>
                                                {{-- <option
                                                {{ @$initial_payment == 'YES' ? 'selected' : '' }}
                                                 value="YES">Yes</option>
                                                <option
                                                {{ @$initial_payment == 'NO' ? 'selected' : '' }}
                                                value="NO">No</option> --}}
                                                <option {{ @$admission->payment_method == 'Cash Payment' ? 'selected' : '' }}
                                                    value="Cash Payment">Cash Payment</option>
                                                <option {{ @$admission->payment_method == 'Card Payment' ? 'selected' : '' }}
                                                    value="Card Payment">Card Payment</option>
                                                <option {{ @$admission->payment_method == 'Bank Transfer' ? 'selected' : '' }}
                                                    value="Bank Transfer">Bank Transfer</option>
                                        </div>
                                    </div>
                                    <div class="row mb-3 mt-4">
                                        <div class="col-md-12" >
                                            <label for="add_comment" style="font-weight: bold; font-size:18px;">Comment</label>
                                            <textarea style="margin-top: 20px;" name="add_comment" class="form-control" cols="50" rows="5" placeholder="comment here">{{ @$admission->add_comment }}</textarea>
                                            <button type="submit" name="submit"
                                                class="btn btn-block btn-primary mt-3">Submit</button>
                                        </div>
                                    </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>






@endsection

@section('scripts')
    <script src="{{ asset('assets/libs/datetimepicker/js/picker.js') }}"></script>
    <script src="{{ asset('assets/libs/datetimepicker/js/picker.date.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('.datepicker').pickadate({
                selectMonths: true,
                selectYears: true,
                format: 'd/m/yyyy'
            })
        })
    </script>
  >
    {{--  --}}
    {{--  --}}

    <script>


        $(document).ready(function() {

        $("#tbody").on("click", ".save-condition", function(e) {

        var msurname = $(this).closest('tr').find('#msurname').val();
        var mfirst_name = $(this).closest('tr').find('#mfirst_name').val();
        var mdob = $(this).closest('tr').find('#mdob').val();
        var maddress = $(this).closest('tr').find('#maddress').val();
        // Get the current row element and its ID
        var currentRow = $(this).closest('tr');
        var currentRowId = currentRow.attr('class');

        currentRow.find('.conSurname').val(msurname);
        currentRow.find('.conFirst_name').val(mfirst_name);
        currentRow.find('.conAddress').val(maddress);

        //remove
        var modal = $(this).closest('.modal');






        $(this).closest('.modal').modal('hide');
        });
            // Add row
            var counter = 0;
            $("#add-row").click(function() {
    var newRow = $("#template-row").clone();
    newRow.removeAttr("id");

    // Set the "display" style to an empty string to make the form-check div visible
    newRow.find('.form-check').css('display', '');

    newRow.find('input[type="text"]').val('');
    newRow.find('select').prop('selectedIndex', 0);

    counter++;
    newRow.attr('id', 'row' + counter);
    newRow.addClass('new-class-' + counter);
    newRow.find('.con').addClass('con-class-' + counter);
    newRow.find('.conComment').addClass('conComment-class-' + counter);

    // Update the modal attributes
    newRow.find('.add-condition').attr('data-target', '#new-modal-' + counter);
    newRow.find('.modal').attr('id', 'new-modal-' + counter);
    newRow.find('.modal-title').attr('id', 'new-modal-label-' + counter);
    newRow.find('.close').attr('data-dismiss', 'modal-' + counter);
    newRow.find('.save-condition').attr('data-target', '#new-modal-' + counter);

    var firstNameInput = newRow.find('input[name="first_name[]"]');
    firstNameInput.attr('id', 'first_name_' + counter);
    firstNameInput.css('border', '');
    firstNameInput.next('.popup-message').remove();
    firstNameInput.addClass('first_name');
    var surname = newRow.find('input[name="surname[]"]');
    surname.css('border', '');
    surname.next('.popup-message').remove();
    var dob = newRow.find('input[name="dob[]"]');
    dob.css('border', '');
    dob.next('.popup-message').remove();

    var gender = newRow.find('select[name="gender[]"]');
    gender.css('border', '');
    gender.next('.popup-message').remove();

    var remove = newRow.find('.remove-row');
    remove.css('display', 'block');

    newRow.show();

    $("#tbody").append(newRow);

    // Initialize datepicker
    $('.datepicker').pickadate({
        selectMonths: true,
        selectYears: true,
        format: 'd/m/yyyy'
    });
});

            $(document).on("click", ".remove-row", function() {
                var inputId = $(this).closest('tr').find('.first_name').attr('id');
                $("[id='" + inputId + "']").remove();
                if(inputId == 'first_name_0') {
                $(".cool").closest("div").find('.form-control[name="hours[]"]').remove();
                }
                else
                {
                $("." + inputId).closest("td").find('.form-control[name="hours[]"]').remove();
                }
               // alert(inputId);

                $(this).closest("tr").remove();
            });

            // Initialize datepicker for existing rows
            $('.datepicker').pickadate({
                selectMonths: true,
                selectYears: true,
                format: 'd/m/yyyy'
            });

            //
            var counter = 0;
            $('#add-row').click(function() {
  // create the new row with the desired input elements

  var newRow = $('<tr>').append(
    $('<td>').append(
        $('<input>').attr({
    type: 'text',
    name: 'first_names[]',
    class: 'form-control first_name', // add incremented class to input element
    id: 'first_name_' + counter, // set incremented ID to input element
    placeholder: 'First Name',
    readonly: "readonly",
    onkeypress: 'return /[a-zA-Z\s]/i.test(event.key)',
    style: 'width: 95%; text-align: center; margin-top:10px'
  })
    ),
    $('<td>').append(
      $('<input>').attr({
        type: 'number',
        name: 'hours[]',
        class: 'form-control first_name_'+ counter,
        placeholder: 'hours',
        style: 'width: 50%; text-align: center;',

      })
    )
  );

  // add the new row to the #tbd div
  $('#tbd').append(newRow);

});




        });

    $("#tbody").on("keyup", ".first_name, .surname", function(e) {
    var $currentRow = $(this).closest('tr');
    var firstName = $currentRow.find('.first_name').val();
    var surname = $currentRow.find('.surname').val();
    var clickedID = $currentRow.find('.first_name').attr('id');
    var fullName = firstName + (surname ? ' ' + surname : '');

    console.log(fullName);
    console.log(clickedID);
    $("[id='" + clickedID + "']:last").val(fullName);
});









// guardian_address

// medical button disable
$(document).ready(function() {
  // Disable the button initially for all rows
  $('tr').each(function() {
    $(this).find('#btn').prop('disabled', true);
  });

  // Listen for changes in the checkbox for all rows
  $(document).on('change', 'input[type="checkbox"]', function() {
    var isChecked = $(this).is(':checked');
    $(this).closest('tr').find('#btn').prop('disabled', !isChecked);
  });
});
    </script>
@endsection
