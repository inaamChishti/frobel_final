@extends('layouts.auth')

@section('styles')
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <link href="{{ asset('assets/libs/datetimepicker/css/classic.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/libs/datetimepicker/css/classic.date.css') }}" rel="stylesheet" />

    <style>
        #star {
            color: red !important;
        }
        input::placeholder {
            font: 18px sans-serif;
        }
        #star {
            color: red !important;
        }
        input::placeholder {
            font: 18px sans-serif;
        }
        .header-content {
    display: flex;
    justify-content: space-between;
}

.logo-container {
    flex-basis: 10%;
    flex-shrink: 1;
    flex-grow: 1;
}

.title-container {
    display: flex;
    flex-direction: column;

    flex-basis: 80%;
    flex-shrink: 1;
    flex-grow: 1;
    margin-left: 130px;
    margin-right: 10px;
}
.modal-title{
    width:500px;
}
.subtitle {
    font-weight: bold;
    margin-top: 0;
}

.button-container {
    flex-basis: 5%;
    flex-shrink: 1;
    flex-grow: 1;
    text-align: right;
}
@media screen and (max-width: 768px) {
    .header-content {
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
    }

    .logo-container {
        flex-basis: 30%;
        margin-bottom: 10px;
    }

    .title-container {
        flex-basis: 70%;
        margin-left: 0;
        margin-right: 0;
    }
    .modal-title{
        width:100%;
    }

    .button-container {
        flex-basis: 100%;
        text-align: center;
    }
    .medical_treatment{
        display: flex;
        flex-direction: column;
    }
}

    </style>
@endsection

@section('content')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

    <div class="container-fluid flex-grow-1 container-p-y">
        <h1 class="font-weight-bold py-3 mb-4" style="text-align:center">
            <span class="text-muted font-weight-light"></span> Admission
        </h1>
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
                @if (Session::has('created-status'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Success!</strong> {{ Session::get('created-status') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <!-- Student Form -->
                <div class="row">
                    <div class="col-xl-12 mx-auto">
                        {{--
               <hr>
               --}}
                        <div class="card border-top border-0 border-4 border-info"
                            style=" box-shadow: 1px 1px 4px 6px		#b0516a;  margin-bottom: 20px;">
                            <div class="card-body">
                                <div class="border p-4 rounded">
                                    <div class="card-title d-flex align-items-center">
                                        <div><i class="bx bxs-user me-1 font-22 text-info"></i>
                                        </div>
                                        <h3 class="mb-0 text-info">Student Form</h3>
                                    </div>
                                    <hr>
                                    <form method="POST" class="form-horizontal"
                                        action="{{ route('admin.admission.store') }}">
                                        @csrf
                                        <div class="row mb-3">

                                            <div class="col-md-3 mb-3">
                                                <label for="" style="font-weight: bold; font-size:18px;">Family
                                                    ID</label>
                                                <input type="text" name="family_id" readonly="readonly"
                                                    class="form-control"
                                                    value="@isset($family_id) {{ $family_id }} @endisset">
                                            </div>

                                            <div class="col-md-3 mb-3">
                                                <label for="" style="font-weight: bold; font-size:18px;">Form
                                                    Filling Date <span id="star"
                                                    style="font-size:12px;"></span> </label>
                                                <input type="text" name="form_date" id="formm_date"
                                                    class="form-control datepicker" placeholder="dd-mm-yyyy"
                                                    value="{{ old('form_date') }}">
                                            </div>

                                            <div class="col-md-3 mb-3">
                                                <label for="" style="font-weight: bold; font-size:18px;">Joining
                                                    Date <span id="star"
                                                    style="font-size:12px;"></span> </label>
                                                <input type="text" name="joining_date" id="joining_date"
                                                    class="form-control datepicker" placeholder="dd-mm-yyyy"
                                                    value="{{ old('joining_date') }}">
                                            </div>
                                            <!-- below code is for select current date if form loaded-->
                                            <script>
                                                // Get current date
                                                var currentDate = new Date();

                                                // Format date as dd/mm/yyyy
                                                var formattedDate = currentDate.getDate() + '/' + (currentDate.getMonth() + 1) + '/' + currentDate.getFullYear();

                                                // Set form_date and joining_date fields to current date
                                                document.getElementById('formm_date').value = formattedDate;
                                                document.getElementById('joining_date').value = formattedDate;
                                            </script>




                                            <div class="col-md-3 mb-3">
                                                <label for="family status" style="font-weight: bold; font-size:18px;">Status
                                                    <span id="star"
                                                        style="font-size:12px;"></span></label>
                                                <select name="family_status" class="form-control">
                                                    <option selected disabled>Choose</option>
                                                    <option @if (old('family_status') == 'Active') selected @endif
                                                        value="Active">Active</option>
                                                    <option @if (old('family_status') == 'De-Active') selected @endif
                                                        value="De-Active">De-Active</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <button type="button" id="add-row" class="btn btn-primary" style="margin-bottom:20px;">Add Row</button>

                                            <table class="table table-bordered table-highlight">
                                                <thead>
                                                    <td style="font-weight: bold; font-size:18px;">First Name <span id="star"
                                                        style="font-size:12px;"></span>
                                                    </td>
                                                    <td style="font-weight: bold; font-size:18px;">Last Name <span id="star"
                                                        style="font-size:12px;"></span>
                                                    </td>
                                                    <td style="font-weight: bold; font-size:18px;">Date of Birth <span id="star"
                                                        style="font-size:12px;"></span></td>
                                                    <td style="font-weight: bold; font-size:18px;">Gender <span id="star"
                                                        style="font-size:12px;"></span></td>
                                                    <td style="font-weight: bold; font-size:18px;">Year</td>
                                                    <td style="font-weight: bold; font-size:18px;">Medical Condition</td>
                                                    <td style="font-weight: bold; font-size:18px;">student status</td>
                                                    <td style="font-weight: bold; font-size:18px;">Action</td>
                                                    {{-- <td style="font-weight: bold; font-size:18px;">Hours</td> --}}
                                                </thead>
                                                <tbody id="tbody" class="table1">
                                                    <tr id="template-row" style="" class="">
                                                        <td><input type="text" name="first_name[]" class="form-control first_name" id="first_name_0"
                                                            onkeypress="return /[a-zA-Z\s]/i.test(event.key)"  required   placeholder="first name">
                                                        </td>
                                                        <td><input type="text" name="surname[]" class="form-control surname" id="surname"
                                                            onkeypress="return /[a-zA-Z\s]/i.test(event.key)"    placeholder="surname">
                                                        </td>
                                                        <td><input type="text" name="dob[]"
                                                                class="form-control datepicker" placeholder="dd-mm-yyyy" >
                                                        </td>
                                                        <td>
                                                            <select name="gender[]" class="form-control" >
                                                                <option selected disabled>Choose</option>
                                                                <option value="male">Male</option>
                                                                <option value="female">Female</option>
                                                            </select>
                                                        </td>

                                                        <td>
                                                            <select name="years_in_school[]" class="form-control">
                                                                <option selected disabled>Choose</option>
                                                                <option value="1">1 Year</option>
                                                                <option value="2">2 Year</option>
                                                                <option value="3">3 Year</option>
                                                                <option value="4">4 Year</option>
                                                                <option value="5">5 Year</option>
                                                                <option value="6">6 Year</option>
                                                                <option value="7">7 Year</option>
                                                                <option value="8">8 Year</option>
                                                                <option value="9">9 Year</option>
                                                                <option value="10">10 Year</option>
                                                                <option value="11">11 Year</option>
                                                                <option value="12">12 Year</option>
                                                                <option value="13">13 Year</option>
                                                            </select>
                                                        </td>

                                                        <td>
                                                            <div class="form-check">
                                                                <input class="form-check-input" style="  margin-top: 12px;" type="checkbox" id="medEnable">


                                                        <button type="button" id="btn"
                                                        style="width: 160px; "
                                                        class="btn btn-primary add-condition" data-toggle="modal" data-target="#condition-modal">
                                                        Medical condition
                                                        </button>
                                                        <input type="text" style="display:none "  class="conSurname" name="conSurname[]" value="">
                                                        <input type="text" style="display:none "   class="conFirst_name" name="conFirst_name[]" value="">
                                                        <input type="text" style="display:none "  class="conDob" name="conDob[]" value="">
                                                        <input type="text" style="display:none "   class="conAddress" name="conAddress[]" value="">
                                                        <input type="text" style="display:none "  class="contelNo1" name="contelNo1[]" value="">
                                                        <input type="text" style="display:none "   class="contelAlter1" name="contelAlter1[]" value="">
                                                        <input type="text" style="display:none "  class="contelNo2" name="contelNo2[]" value="">
                                                        <input type="text" style="display:none "   class="contelAlter2" name="contelAlter2[]" value="">
                                                        <input type="text" style="display:none "   class="condrName" name="condrName[]" value="">
                                                        <input type="text" style="display:none "   class="conDrTel" name="conDrTel[]" value="">
                                                        <input type="text" style="display:none "   class="conDrAddress" name="conDrAddress[]" value="">
                                                        <input type="text" style="display:none "   class="yes" name="yes[]" value="">
                                                        <input type="text" style="display:none "   class="no" name="no[]" value="">
                                                        <input type="text" style="display:none "   class="conCurrentMedical" name="conCurrentMedical[]" value="">
                                                        <input type="text" style="display:none "   class="conAthome" name="conAthome[]" value="">
                                                        <input type="text" style="display:none "   class="conAthomeSchl" name="conAthomeSchl[]" value="">
                                                        <input type="text" style="display:none "   class="conStudentAdmin" name="conStudentAdmin[]" value="">
                                                        <input type="text" style="display:none "   class="conStaffAdmin" name="conStaffAdmin[]" value="">
                                                        <input type="text" style="display:none "   class="conStudentAdminSuper" name="conStudentAdminSuper[]" value="">
                                                        <input type="text" style="display:none "   class="conOtherRadio" name="conOtherRadio[]" value="">
                                                        <input type="text" style="display:none "   class="conOtherDetails" name="conOtherDetails[]" value="">
                                                        <input type="text" style="display:none "   class="conCommenAdmin" name="conCommenAdmin[]" value="">
                                                        <input type="text" style="display:none "   class="conDietry" name="conDietry[]" value="">
                                                        <input type="text" style="display:none "   class="conSign" name="conSign[]" value="">
                                                        <input type="text" style="display:none "   class="condate" name="date[]" value="">
                                                    </td>
                                                    <td>
                                                        <select name="student_status[]" class="form-control">
                                                            <option value="active" >ACTIVE</option>
                                                            <option value="inactive">INACTIVE</option>
                                                        </select>
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
                                                                                <input type="text"  onkeypress="return /[a-zA-Z\s]/i.test(event.key)" class="form-control" id="msurname" name="doctor_name[]" >
                                                                              </div>
                                                                              <div class="col-md-6 mb-3">
                                                                                <label for="first_name" class="form-label">Doctor Number:</label>
                                                                                <input type="number"  oonkeypress="return /\d/.test(event.key)" class="form-control" id="mfirst_name" name="doctor_number[]" >
                                                                              </div>

                                                                            </div>
                                                                            <div class="mb-3">
                                                                              <label for="address" class="form-label">Address:</label>
                                                                              <textarea class="form-control" id="maddress" name="maddress[]" rows="3" ></textarea>
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
                                                    <!-- Condition Modal -->


                                                </tbody>

                                            </table>
                                        </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="display: flex !important; justify-content: space-between;">
                    <!-- Gaurdian Form -->
                    <div class="row"
                        style="margin-right:20px;flex-basis: 50%;
                    flex-grow: 1;
                    flex-shrink: 1;">
                        <div class="col-xl-12 mx-auto">
                            <div class="card border-top border-0 border-4 border-info"
                                style=" box-shadow: 1px 1px 4px 6px	#039dfe;
                margin-bottom: 20px;padding-bottom:52px;
                ">
                                <div class="card-body">
                                    <div class="border p-4 rounded">
                                        <div class="card-title d-flex align-items-center">
                                            <div><i class="bx bxs-user me-1 font-22 text-info"></i>
                                            </div>
                                            <h3 class="mb-0 text-info" style="font-weight: bold; font-size:18px;">
                                                Parent/Guardian Details</h3>
                                        </div>
                                        <hr>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="name" style="font-weight: bold; font-size:18px;">Name
                                                    <span
                                                    id="star" style="font-size:12px;"></span></label>
                                                <input type="text" name="guardian_name" class="form-control"
                                                onkeypress="return /[a-zA-Z\s]/i.test(event.key)"  placeholder="name" value="{{ old('guardian_name') }}" />
                                            </div>

                                            <div class="col-md-6">
                                                <label for="surname"
                                                    style="font-weight: bold; font-size:18px;">E-mail
                                                    <span
                                                    id="star" style="font-size:12px;"></span></label>
                                                <input type="text" name="guardian_email" class="form-control"
                                                    placeholder="email" value="{{ old('guardian_email') }}" />
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="surname"
                                                    style="font-weight: bold; font-size:18px;">Address <span
                                                    id="star" style="font-size:12px;"></span></label>
                                                    <textarea name="guardian_address" class="form-control" placeholder="Address">{{ old('guardian_telephone') }}</textarea>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="mobile" style="font-weight: bold; font-size:18px;">Mobile</label>
                                                <input type="number" name="guardian_mobile" class="form-control"
                                                    placeholder="mobile no" value="{{ old('guardian_mobile') }}" />
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Kin Form -->
                    <div class="row" id="student_2" style="flex-basis: 50%; flex-grow: 1;flex-shrink: 1;">
                        <div class="col-xl-12 mx-auto">
                            <div
                                class="card border-top border-0 border-4 border-info"style=" box-shadow: 1px 1px 4px 6px	#f07910;margin-bottom: 20px;">
                                <div class="card-body">
                                    <div class="border p-4 rounded">
                                        <div class="card-title d-flex align-items-center">
                                            <div><i class="bx bxs-user me-1 font-22 text-info"></i>
                                            </div>
                                            <h3 class="mb-0 text-info" style="font-weight: bold; font-size:18px;">Next of
                                                Kin Details</h3>
                                        </div>
                                        <hr>
                                        <div class="row mb-3">
                                            <div class="col-md-6">

                                                <label for="kin_name"
                                                    style="font-weight: bold; font-size:18px;">Name</label>
                                                <input type="text" name="kin_name" class="form-control"
                                                onkeypress="return /[a-zA-Z\s]/i.test(event.key)" placeholder="name" value="{{ old('kin_name') }}" />
                                            </div>
                                            <div class="col-md-6">
                                                <label for="email"
                                                    style="font-weight: bold; font-size:18px;">Email</label>
                                                <input type="email" name="kin_email" class="form-control"
                                                    placeholder="Email" value="{{ old('kin_email') }}" />
                                            </div>

                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="kin_address"
                                                    style="font-weight: bold; font-size:18px;">Address</label>
                                                <input type="text" name="kin_address" class="form-control"
                                                    placeholder="Address" value="{{ old('kin_address') }}" />
                                            </div>
                                            <div class="col-md-6">
                                                <label for="kin_mobile"
                                                    style="font-weight: bold; font-size:18px;">Mobile</label>
                                                <input type="text" name="kin_mobile" class="form-control"
                                                onkeypress="return /\d/.test(event.key)"
                                                    placeholder="mobile no" value="{{ old('kin_mobile') }}" />
                                            </div>


                                        </div>
                                        <div class="row mb-3">
                                        </div>
                                        <div class="row mb-3">
                                        </div>
                                        <div class="row mb-3">
                                        </div>



                                        {{-- <div class="card-title d-flex align-items-center">
                                            <div><i class="bx bxs-user me-1 font-22 text-info"></i>
                                            </div>
                                            <h5 class="mb-0 text-info" style="font-weight: bold; font-size:18px;">Next of
                                                Kin Details/2</h5>
                                        </div>
                                        <hr>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="surname"
                                                    style="font-weight: bold; font-size:18px;">Name</label>
                                                <input type="text" name="kin_name2" class="form-control"
                                                onkeypress="return /[a-zA-Z\s]/i.test(event.key)"  placeholder="name" value="{{ old('kin_name2') }}" />
                                            </div>
                                            <div class="col-md-6">
                                                <label for="surname"
                                                    style="font-weight: bold; font-size:18px;">E-mail</label>
                                                <input type="text" name="kin_email2" class="form-control"
                                                    placeholder="email" value="{{ old('kin_email2') }}" />
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-12">
                                                <label for="surname"
                                                    style="font-weight: bold; font-size:18px;">Mobile</label>
                                                <input type="number" name="kin_mobile2" class="form-control"
                                                    placeholder="mobile no" value="{{ old('kin_mobile2') }}" />
                                            </div>
                                        </div> --}}



                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>

                <div style="display: flex !important; justify-content: space-between;">

                    {{-- <!-- Kin Form -->
                    <div class="row" id="student_2"
                        style="flex-basis: 50%; flex-grow: 1;flex-shrink: 1;margin-right:20px;">
                        <div class="col-xl-12 mx-auto">
                            <div
                                class="card border-top border-0 border-4 border-info"style=" box-shadow: 1px 1px 4px 6px	#D3D3D3;margin-bottom: 20px;">
                                <div class="card-body">
                                    <div class="border p-4 rounded">
                                        <div class="card-title d-flex align-items-center">
                                            <div><i class="bx bxs-user me-1 font-22 text-info"></i>
                                            </div>
                                            <h5 class="mb-0 text-info" style="font-weight: bold; font-size:18px;">Next of
                                                Kin Details/2</h5>
                                        </div>
                                        <hr>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="surname"
                                                    style="font-weight: bold; font-size:18px;">Name</label>
                                                <input type="text" name="kin_name2" class="form-control"
                                                onkeypress="return /[a-zA-Z\s]/i.test(event.key)"  placeholder="name" value="{{ old('kin_name2') }}" />
                                            </div>
                                            <div class="col-md-6">
                                                <label for="surname"
                                                    style="font-weight: bold; font-size:18px;">E-mail</label>
                                                <input type="text" name="kin_email2" class="form-control"
                                                    placeholder="email" value="{{ old('kin_email2') }}" />
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-12">
                                                <label for="surname"
                                                    style="font-weight: bold; font-size:18px;">Mobile</label>
                                                <input type="number" name="kin_mobile2" class="form-control"
                                                    placeholder="mobile no" value="{{ old('kin_mobile2') }}" />
                                            </div>
                                        </div>

                                        <br><br><br><br><br>
                                    </div>
                                </div>

                            </div>

                        </div>

                    </div> --}}
                    <!-- Other detail Form -->
                    <div class="row" id="student_2" style="flex-basis: 50%; flex-grow: 1;flex-shrink: 1;">
                        <div class="col-xl-12 mx-auto">
                            <div class="card border-top border-0 border-4 border-info"
                                style=" box-shadow: 1px 1px 4px 6px	#b96edd;  margin-bottom: 20px;">
                                <div class="card-body">
                                    <div class="border p-4 rounded">
                                        <div class="card-title d-flex align-items-center">
                                            <div><i class="bx bxs-user me-1 font-22 text-info"></i>
                                            </div>
                                            <h3 class="mb-0 text-info" style="font-weight: bold; font-size:18px;">See
                                                Other
                                                detail</h3>
                                        </div>
                                        <hr>

                                        {{-- <div class="row mb-3">
                            <div class="col-md-12">
                               <label for="medical_condition">Does any child have medical Conditions?</label>
                               <textarea name="medical_condition" class="form-control" cols="50" rows="5" placeholder="write something">{{ old('medical_condition') }}</textarea>
                            </div>
                         </div> --}}

                         <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="medical_condition" style="font-weight: bold; font-size:18px;">Does Any Child Have Medical Conditions?</label>
                                <textarea name="medical_condition" class="form-control" cols="50" rows="5" placeholder="comment here">{{ @$admission->medicalcondition }}</textarea>

                            </div>
                            <div class="col-md-12">
                                <label for="Fee Details"style="font-weight: bold; font-size:18px;">Fee Details
                                    <span id="star" style="font-size:12px;"></span></label>
                                <input type="text" name="fee_detail" class="form-control"
                                    placeholder="fee detail" required value="{{ @$admission->feedetail }}" />
                            </div>
                        </div>

                        <div class="row mb-3">


                            <div class="col-md-12">
                                <label for="surname" style="font-weight: bold; font-size:18px;">
                                    Initial Payment <span id="star"
                                        style="font-size:12px;"></span></label>
                                <select required name="payment_method" class="form-control" style=" font-size:17px;">
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

                            </div>
                        </div>
                                        <div id="tbd" >

                                            <div class="row shorter-row" style="max-width: calc(100% - 100px); margin-left:0.2px;">
                                                <div class="col-md-2.5 p-0">
                                                  <input type="text" name="first_names[]" class="form-control first_name" id="first_name_0" onkeypress="return /[a-zA-Z\s]/i.test(event.key)" placeholder="First Name" style="width: 95%;text-align: center;" readonly>
                                                </div>

                                                <div class="col-md-2.5 p-0" style="padding-left: 10px;">
                                                  <input type="number" name="hours[]" class="form-control cool" placeholder="Hours" style="width: 50%; text-align: center;">
                                                  <input type="hidden" id="hourz" name="hourz[]" class="form-control cool" placeholder="Hours" style="width: 50%; text-align: center;">

                                                </div>
                                              </div>


                                        </div>
                                        <button type="submit" name="submit"
                                                        class="btn btn-block btn-primary mt-3">Submit</button>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
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


            $('#tbody').on('click', '#btn', function() {

                var currentRow = $(this).closest('tr');
  var maddress = currentRow.find('.conAddress').val();
  if (maddress == '') {

    currentRow.find('#maddress').val('');
  }

//
var currentRow = $(this).closest('tr');
  var tel1 = currentRow.find('.contelNo1').val();
  if (tel1 == '') {

    currentRow.find('#mTelephone_Number').val('');
  }
//
var currentRow = $(this).closest('tr');
  var telalter1 = currentRow.find('.contelAlter1').val();
  if (telalter1 == '') {

    currentRow.find('#mAlternative_Tel_No').val('');
  }
//
var currentRow = $(this).closest('tr');
  var contelNo2 = currentRow.find('.contelNo2').val();
  if (contelNo2 == '') {

    currentRow.find('#mTelephone_Number2').val('');
  }
//
var currentRow = $(this).closest('tr');
  var contelAlter2 = currentRow.find('.contelAlter2').val();
  if (contelAlter2 == '') {

    currentRow.find('#mAlternative_Tel_No2').val('');
  }
//
var currentRow = $(this).closest('tr');
  var conDrTel = currentRow.find('.conDrTel').val();
  if (conDrTel == '') {

    currentRow.find('#mDoctors_Tel_No').val('');
  }

//
var currentRow = $(this).closest('tr');
  var conDrAddress = currentRow.find('.conDrAddress').val();
  if (conDrAddress == '') {

    currentRow.find('#mDoctors_Address').val('');
  }



               var  modal = $(this).closest('tr').find('.modal');

               var currentRow = $(this).closest('tr');




            //
            var mOtherRadio = $(this).closest('tr').find('.conOtherRadio').val();

               var currentRow = $(this).closest('tr');
                var mOtherRadio = currentRow.find('.conOtherRadio').val();

                if (mOtherRadio) {
                    modal.find('#mOtherRadio').prop('checked', true);

                }
                 else {
                    modal.find('#mOtherRadio').val('');

                    modal.find('#mOtherRadio').prop('checked', false);
                }
            //

            var Otherradio2 = modal.find('#mOtherRadio');
                var isCheck = Otherradio2.prop('checked');

                Otherradio2.on('click', function() {
                    if (isCheck) {
                        $(this).prop('checked', false);
                        $(this).val('');
                        isCheck = false;
                    } else {
                        $(this).prop('checked', true);
                        $(this).val('Others');
                        isCheck = true;
                    }
                });
            //

               var yesVal = $(this).closest('tr').find('.yes').val();

               var currentRow = $(this).closest('tr');
                var yesVal = currentRow.find('.yes').val();

                if (yesVal) {
                    modal.find('#mlifeThreateningYes').prop('checked', true);

                }
                 else {
                    modal.find('#mlifeThreateningYes').val('');

                    modal.find('#mlifeThreateningYes').prop('checked', false);
                }

                //
                var currentRow = $(this).closest('tr');

               var NoVal = $(this).closest('tr').find('.no').val();

               var currentRow = $(this).closest('tr');
                var NoVal = currentRow.find('.no').val();

                if (NoVal) {
                    modal.find('#mlifeThreateningNo').prop('checked', true);

                }
                 else {
                    modal.find('#mlifeThreateningNo').val('');

                    modal.find('#mlifeThreateningNo').prop('checked', false);
                }
                // at home
                var currentRow = $(this).closest('tr');

               var ConVal = $(this).closest('tr').find('.conAthome').val();

               var currentRow = $(this).closest('tr');
                var ConVal = currentRow.find('.conAthome').val();

                if (ConVal) {
                    modal.find('#mAt_Home').prop('checked', true);

                }
                 else {
                    modal.find('#mAt_Home').val('');

                    modal.find('#mAt_Home').prop('checked', false);
                }
                //at home and school
                var currentRow = $(this).closest('tr');

               var AthomeSchlVal = $(this).closest('tr').find('.conAthomeSchl').val();

               var currentRow = $(this).closest('tr');
                var AthomeSchlVal = currentRow.find('.conAthomeSchl').val();

                if (AthomeSchlVal) {
                    modal.find('#mAt_home_and_school').prop('checked', true);

                }
                 else {
                    modal.find('#mAt_home_and_school').val('');

                    modal.find('#mAt_home_and_school').prop('checked', false);
                }
                //student to admin

        var currentRow = $(this).closest('tr');

               var conStudentAdmin = $(this).closest('tr').find('.conStudentAdmin').val();

               var currentRow = $(this).closest('tr');
                var conStudentAdmin = currentRow.find('.conStudentAdmin').val();

                if (conStudentAdmin) {
                    modal.find('#Student_to_administer').prop('checked', true);

                }
                 else {
                    modal.find('#Student_to_administer').val('');
                    modal.find('#Student_to_administer').prop('checked', false);
                }
                //
                var conStaffAdmin = $(this).closest('tr').find('.conStaffAdmin').val();

               var currentRow = $(this).closest('tr');
                var conStaffAdmin = currentRow.find('.conStaffAdmin').val();

                if (conStaffAdmin) {
                    modal.find('#Staff_member_to_administer').prop('checked', true);

                }
                 else {
                    modal.find('#Staff_member_to_administer').val('');
                    modal.find('#Staff_member_to_administer').prop('checked', false);
                }
                //
                //

                var conStaffAdmin = $(this).closest('tr').find('.conStudentAdminSuper').val();

               var currentRow = $(this).closest('tr');
                var conStaffAdmin = currentRow.find('.conStudentAdminSuper').val();

                if (conStaffAdmin) {
                    modal.find('#student_admin_stafflast').prop('checked', true);

                }
                 else {
                    modal.find('#student_admin_stafflast').val('');

                    modal.find('#student_admin_stafflast').prop('checked', false);
                }


               var radioStudent = modal.find('#Student_to_administer'); // Radio button for student to administer
                var radioStaff = modal.find('#Staff_member_to_administer'); // Radio button for staff member to administer
                var radioStudentWithStaff = modal.find('#student_admin_stafflast'); // Radio button for student to administer with staff supervision

                var isCheckedStudent = radioStudent.prop('checked');
                var isCheckedStaff = radioStaff.prop('checked');
                var isCheckedStudentWithStaff = radioStudentWithStaff.prop('checked');

                radioStaff.on('click', function() {
                    if (isCheckedStaff) {
                        $(this).prop('checked', false);
                        $(this).val('');
                        isCheckedStaff = false;
                    } else {
                        $(this).prop('checked', true);
                        $(this).val('Staff member to administer');
                        isCheckedStaff = true;
                        // uncheck the other radio buttons and clear their values
                        radioStudent.prop('checked', false);
                        radioStudent.val('');
                        isCheckedStudent = false;
                        radioStudentWithStaff.prop('checked', false);
                        radioStudentWithStaff.val('');
                        isCheckedStudentWithStaff = false;
                    }
                });

                radioStudentWithStaff.on('click', function() {
                    if (isCheckedStudentWithStaff) {
                        $(this).prop('checked', false);
                        $(this).val('');
                        isCheckedStudentWithStaff = false;
                    } else {
                        $(this).prop('checked', true);
                        $(this).val('Student to administer with staff supervision');
                        isCheckedStudentWithStaff = true;
                        // uncheck the other radio buttons and clear their values
                        radioStudent.prop('checked', false);
                        radioStudent.val('');
                        isCheckedStudent = false;
                        radioStaff.prop('checked', false);
                        radioStaff.val('');
                        isCheckedStaff = false;
                    }
                });

                radioStudent.on('click', function() {
                    if (isCheckedStudent) {
                        $(this).prop('checked', false);
                        $(this).val('');
                        isCheckedStudent = false;
                    } else {
                        $(this).prop('checked', true);
                        $(this).val('Student to administer');
                        isCheckedStudent = true;
                        // uncheck the other radio buttons and clear their values
                        radioStaff.prop('checked', false);
                        radioStaff.val('');
                        isCheckedStaff = false;
                        radioStudentWithStaff.prop('checked', false);
                        radioStudentWithStaff.val('');
                        isCheckedStudentWithStaff = false;
                    }
                });

               //   yes and no

               var radioYes = modal.find('#mlifeThreateningYes');
                var radioNo = modal.find('#mlifeThreateningNo');

                var isCheckedYes = radioYes.prop('checked');
                var isCheckedNo = radioNo.prop('checked');

                radioNo.on('click', function() {
                    if (isCheckedNo) {
                        $(this).prop('checked', false);
                        $(this).val('');
                        isCheckedNo = false;
                    } else {
                        $(this).prop('checked', true);
                        $(this).val('no');
                        isCheckedNo = true;
                        // uncheck the other radio button and clear its value
                        radioYes.prop('checked', false);
                        radioYes.val('');
                        isCheckedYes = false;
                    }
                });

                radioYes.on('click', function() {
                    if (isCheckedYes) {
                        $(this).prop('checked', false);
                        $(this).val('');
                        isCheckedYes = false;
                    } else {
                        $(this).prop('checked', true);
                        $(this).val('yes');
                        isCheckedYes = true;
                        // uncheck the other radio button and clear its value
                        radioNo.prop('checked', false);
                        radioNo.val('');
                        isCheckedNo = false;
                    }
                });

                //home and not at home button
                var radio1 = modal.find('#mAt_Home');
                var radio2 = modal.find('#mAt_home_and_school');
                var isChecked1 = radio1.prop('checked');
                var isChecked2 = radio2.prop('checked');

                radio1.on('click', function() {
                    if (isChecked1) {
                        $(this).prop('checked', false);
                        $(this).val('');
                        isChecked1 = false;
                    } else {
                        $(this).prop('checked', true);
                        $(this).val('At Home');
                        isChecked1 = true;
                        // uncheck the other radio button and clear its value
                        radio2.prop('checked', false);
                        radio2.val('');
                        isChecked2 = false;
                    }
                });

                radio2.on('click', function() {
                    if (isChecked2) {
                        $(this).prop('checked', false);
                        $(this).val('');
                        isChecked2 = false;
                    } else {
                        $(this).prop('checked', true);
                        $(this).val('At home and school');
                        isChecked2 = true;
                        // uncheck the other radio button and clear its value
                        radio1.prop('checked', false);
                        radio1.val('');
                        isChecked1 = false;
                    }
                });


            });

        $("#tbody").on("click", ".save-condition", function(e) {
             // section for checkboxes
            //  yes button


            // end section
        var msurname = $(this).closest('tr').find('#msurname').val();
        var mfirst_name = $(this).closest('tr').find('#mfirst_name').val();
        var mdob = $(this).closest('tr').find('#mdob').val();
        var maddress = $(this).closest('tr').find('#maddress').val();
        var mTelephone_Number = $(this).closest('tr').find('#mTelephone_Number').val();
        var mAlternative_Tel_No = $(this).closest('tr').find('#mAlternative_Tel_No').val();
        var mTelephone_Number2 =  $(this).closest('tr').find('#mTelephone_Number2').val();
        var mAlternative_Tel_No2 = $(this).closest('tr').find('#mAlternative_Tel_No2').val();
        var mDoctors_Name = $(this).closest('tr').find('#mDoctors_Name').val();
        var mDoctors_Tel_No = $(this).closest('tr').find('#mDoctors_Tel_No').val();
        var mDoctors_Address = $(this).closest('tr').find('#mDoctors_Address').val();
        var mlifeThreateningYes = $(this).closest('tr').find('#mlifeThreateningYes').val();
        var mlifeThreateningNo = $(this).closest('tr').find('#mlifeThreateningNo').val();
        var mMedicaltreatmentzero = $(this).closest('tr').find('#mMedicaltreatmentzero').val();
        var mAt_Home = $(this).closest('tr').find('#mAt_Home').val();
        var mAt_home_and_school = $(this).closest('tr').find('#mAt_home_and_school').val();
        var Student_to_administer =  $(this).closest('tr').find('#Student_to_administer').val();
        var Staff_member_to_administer = $(this).closest('tr').find('#Staff_member_to_administer').val();
        var student_admin_stafflast = $(this).closest('tr').find('#student_admin_stafflast').val();
        var mOtherRadio = $(this).closest('tr').find('#mOtherRadio').val();
        var mOthers = $(this).closest('tr').find('#mOthers').val();
        var mAdComments = $(this).closest('tr').find('#mAdComments').val();
        var mdietary = $(this).closest('tr').find('#mdietary').val();
        var msign = $(this).closest('tr').find('#msign').val();
        var mdate = $(this).closest('tr').find('#mdate').val();

        // Get the current row element and its ID
        var currentRow = $(this).closest('tr');
        var currentRowId = currentRow.attr('class');

        currentRow.find('.conSurname').val(msurname);
        currentRow.find('.conFirst_name').val(mfirst_name);
        currentRow.find('.conAddress').val(maddress);
        currentRow.find('.contelNo1').val(mTelephone_Number);
        currentRow.find('.contelAlter1').val(mAlternative_Tel_No);
        currentRow.find('.contelNo2').val(mTelephone_Number2);
        currentRow.find('.contelAlter2').val(mAlternative_Tel_No2);
        currentRow.find('.conDob').val(mdob);
        currentRow.find('.condrName').val(mDoctors_Name);
        currentRow.find('.conDrTel').val(mDoctors_Tel_No);
        currentRow.find('.conDrAddress').val(mDoctors_Address);
        currentRow.find('.yes').val(mlifeThreateningYes);
        currentRow.find('.no').val(mlifeThreateningNo);
        currentRow.find('.conCurrentMedical').val(mMedicaltreatmentzero);
        currentRow.find('.conAthome').val(mAt_Home);
        currentRow.find('.conAthomeSchl').val(mAt_home_and_school);
        currentRow.find('.conStudentAdmin').val(Student_to_administer);
        currentRow.find('.conStaffAdmin').val(Staff_member_to_administer);
        currentRow.find('.conStudentAdminSuper').val(student_admin_stafflast);
        currentRow.find('.conOtherRadio').val(mOtherRadio);
        currentRow.find('.conOtherDetails').val(mOthers);
        currentRow.find('.conCommenAdmin').val(mAdComments);
        currentRow.find('.conDietry').val(mdietary);
        currentRow.find('.conSign').val(msign);
        currentRow.find('.condate').val(mdate);
        //remove
        var modal = $(this).closest('.modal');






        $(this).closest('.modal').modal('hide');
        });
            // Add row
            var counter = 0;
                $("#add-row").click(function() {
                var newRow = $("#template-row").clone();
                newRow.removeAttr("id");
                newRow.find('input[type="text"]').val(''); // clear text input fields
                newRow.find('select').prop('selectedIndex', 0); // reset select fields
                counter++; // increment counter
                newRow.attr('id', 'row' + counter); // set the incremented ID to the row
                newRow.addClass('new-class-' + counter); // add incremented class to row
                newRow.find('.con').addClass('con-class-' + counter); // add incremented class to .con
                newRow.find('.conComment').addClass('conComment-class-' + counter); // add incremented class to .conComment

                // Update the modal attributes
                newRow.find('.add-condition').attr('data-target', '#new-modal-' + counter);
                newRow.find('.modal').attr('id', 'new-modal-' + counter);
                newRow.find('.modal-title').attr('id', 'new-modal-label-' + counter);
                newRow.find('.close').attr('data-dismiss', 'modal-' + counter);
                newRow.find('.save-condition').attr('data-target', '#new-modal-' + counter);

                //// Add counter to the class and ID attributes of the first_name input element
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

            // Remove row

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



    $('button[name="submit"]').click(function() {

    // get all the values of the "hours[]" inputs
    var hoursValues = $('input[name="hours[]"]').map(function() {
        return $(this).val();
    }).get();

    // set the "hourz" input value to the "hours[]" array
    $('#hourz').val(JSON.stringify(hoursValues));

    });
    // validation
    $(document).ready(function() {
  // When the form is submitted
  $('form').submit(function(event) {
    // Get the first name input fields
    var firstNameFields = $('input[name="first_name[]"]');

    // Check if any of the fields are empty
    var hasError = false;
    var firstErrorField;

    // If there's an error, prevent the form from submitting and scroll to the first field with an error
    if (hasError) {
      event.preventDefault();
      $('html, body').animate({
        scrollTop: firstErrorField.offset().top
      }, 500);
    }
  });

  $(document).on('input', 'input[name="first_name[]"]', function() {
  // Check if the border color is red
  if ($(this).css('border-color') === 'rgb(255, 153, 153)') {
    // Remove the red border and pop-up message from the field
    $(this).attr('style', 'border: 1px solid #008000 !important');
    $(this).next('.popup-message').remove();
  } else {
    // Otherwise, add a green border to the field
    $(this).css('border', '');

    // Remove the pop-up message from the field
    $(this).next('.popup-message').remove();
  }
});

});

// next
$(document).ready(function() {
  // When the form is submitted
  $('form').submit(function(event) {
    // Get the surname input fields
    var surnameFields = $('input[name="surname[]"]');

    // Check if any of the fields are empty
    var hasError = false;
    var firstErrorField;
    surnameFields.each(function() {
      if ($(this).val().trim() === '') {
        // Add a red border to the field
        $(this).css('border', '1px solid #ff9999');

        // Check if a pop-up message already exists
        if (!$(this).next('.popup-message').length) {
          // Add a pop-up message to the field
          $(this).after('<div class="popup-message" style="color: #ff9999">Please enter surname</div>');
        }

        // Set hasError flag to true and remember the first field with an error
        hasError = true;
        if (!firstErrorField) {
          firstErrorField = $(this);
        }
      } else {
        // Add a green border to the field
        $(this).css('border', '1px solid #99ff99');

        // Remove the pop-up message from the field
        $(this).next('.popup-message').remove();
      }
    });

    // If there's an error, prevent the form from submitting and scroll to the first field with an error
    if (hasError) {
      event.preventDefault();
      $('html, body').animate({
        scrollTop: firstErrorField.offset().top
      }, 500);
    }
  });

  // When the user starts typing in a field

    $(document).on('input', 'input[name="surname[]"]', function() {
  // Check if the border color is red
  if ($(this).css('border-color') === 'rgb(255, 153, 153)') {
    // Remove the red border and pop-up message from the field
    $(this).attr('style', 'border: 1px solid #008000 !important');
    $(this).next('.popup-message').remove();
  } else {
    // Otherwise, add a green border to the field
    $(this).css('border', '');

    // Remove the pop-up message from the field
    $(this).next('.popup-message').remove();
  }
});
});
// dob
$(document).ready(function() {
  // When the form is submitted
  $('form').submit(function(event) {
    // Get the dob input fields
    var dobFields = $('input[name="dob[]"]');

    // Check if any of the fields are empty
    var hasError = false;
    var firstErrorField;
    dobFields.each(function() {
      if ($(this).val().trim() === '') {
        // Add a red border to the field
        $(this).css('border', '1px solid #ff9999');

        // Check if a pop-up message already exists
        if (!$(this).next('.popup-message').length) {
          // Add a pop-up message to the field
          $(this).after('<div class="popup-message" style="color: #ff9999">Please enter date of birth</div>');
        }

        // Set hasError flag to true and remember the first field with an error
        hasError = true;
        if (!firstErrorField) {
          firstErrorField = $(this);
        }
      } else {
        // Add a green border to the field
        $(this).css('border', '');

        // Remove the pop-up message from the field
        $(this).next('.popup-message').remove();
      }
    });

    // If there's an error, prevent the form from submitting and scroll to the first field with an error
    if (hasError) {
      event.preventDefault();
      $('html, body').animate({
        scrollTop: firstErrorField.offset().top
      }, 500);
    }
  });

  // When the user starts typing in a field

  $(document).on('change', 'input[name="dob[]"]', function() {
  // Check if the border color is red
  if ($(this).css('border-color') === 'rgb(255, 153, 153)') {
    // Remove the red border and pop-up message from the field
    $(this).attr('style', 'border: 1px solid #008000 !important');
    $(this).next('.popup-message').remove();
  } else {
    // Otherwise, add a green border to the field
    $(this).css('border', '');

    // Remove the pop-up message from the field
    $(this).next('.popup-message').remove();
  }
});
});

// gender
$(document).ready(function() {
  // When the form is submitted
  $('form').submit(function(event) {
    // Get the gender input fields
    var genderFields = $('select[name="gender[]"]');

    // Check if any of the fields are empty
    var hasError = false;
    var firstErrorField;

    genderFields.each(function() {
      if ($(this).val() === null) {
        // Add a red border to the field
        $(this).css('border', '1px solid #ff9999');

        // Check if a pop-up message already exists
        if (!$(this).next('.popup-message').length) {
          // Add a pop-up message to the field
          $(this).after('<div class="popup-message" style="color: #ff9999">Please select gender</div>');
        }

        // Set hasError flag to true and remember the first field with an error
        hasError = true;
        if (!firstErrorField) {
          firstErrorField = $(this);
        }
      } else {
        // Add a green border to the field
        $(this).css('border', '');

        // Remove the pop-up message from the field
        $(this).next('.popup-message').remove();
      }
    });

    // If there's an error, prevent the form from submitting and scroll to the first field with an error
    if (hasError) {
      event.preventDefault();
      $('html, body').animate({
        scrollTop: firstErrorField.offset().top
      }, 500);
    }
  });

  // When the user changes the select field

  $(document).on('change', 'select[name="gender[]"]', function() {
  // Check if the border color is red
  if ($(this).css('border-color') === 'rgb(255, 153, 153)') {
    // Remove the red border and pop-up message from the field
    $(this).attr('style', 'border: 1px solid #008000 !important');
    $(this).next('.popup-message').remove();
  } else {
    // Otherwise, add a green border to the field
    $(this).css('border', '');

    // Remove the pop-up message from the field
    $(this).next('.popup-message').remove();
  }
});
});
// status


  // When the user changes the select field
  $(document).on('change', 'select[name="family_status"]', function() {
    // Check if the border color is red
    if ($(this).css('border-color') === 'rgb(255, 153, 153)') {
      // Remove the red border and pop-up message from the field
      $(this).attr('style', 'border: 1px solid #008000 !important');
      $(this).next('.popup-message').remove();
    } else {
      // Otherwise, add a green border to the field
      $(this).css('border', '');

      // Remove the pop-up message from the field
      $(this).next('.popup-message').remove();
    }
  });
// guardian name

$(document).ready(function() {
  // When the form is submitted
  $('form').submit(function(event) {
    // Get the surname input fields
    var surnameFields = $('input[name="guardian_name"]');

    // Check if any of the fields are empty
    var hasError = false;
    var firstErrorField;
    surnameFields.each(function() {
      if ($(this).val().trim() === '') {
        // Add a red border to the field
        $(this).css('border', '1px solid #ff9999');

        // Check if a pop-up message already exists
        if (!$(this).next('.popup-message').length) {
          // Add a pop-up message to the field
          $(this).after('<div class="popup-message" style="color: #ff9999">Please enter surname</div>');
        }

        // Set hasError flag to true and remember the first field with an error
        hasError = true;
        if (!firstErrorField) {
          firstErrorField = $(this);
        }
      } else {
        // Add a green border to the field
        $(this).css('border', '1px solid #99ff99');

        // Remove the pop-up message from the field
        $(this).next('.popup-message').remove();
      }
    });

    // If there's an error, prevent the form from submitting and scroll to the first field with an error
    if (hasError) {
      event.preventDefault();
      $('html, body').animate({
        scrollTop: firstErrorField.offset().top
      }, 500);
    }
  });

  // When the user starts typing in a field

    $(document).on('input', 'input[name="guardian_name"]', function() {
  // Check if the border color is red
  if ($(this).css('border-color') === 'rgb(255, 153, 153)') {
    // Remove the red border and pop-up message from the field
    $(this).attr('style', 'border: 1px solid #008000 !important');
    $(this).next('.popup-message').remove();
  } else {
    // Otherwise, add a green border to the field
    $(this).css('border', '');

    // Remove the pop-up message from the field
    $(this).next('.popup-message').remove();
  }
});
});
// guardian email
$(document).ready(function() {
  // When the form is submitted
  $('form').submit(function(event) {
    // Get the surname input fields
    var surnameFields = $('input[name="guardian_email"]');

    // Check if any of the fields are empty
    var hasError = false;
    var firstErrorField;
    surnameFields.each(function() {
      if ($(this).val().trim() === '') {
        // Add a red border to the field
        $(this).css('border', '1px solid #ff9999');

        // Check if a pop-up message already exists
        if (!$(this).next('.popup-message').length) {
          // Add a pop-up message to the field
          $(this).after('<div class="popup-message" style="color: #ff9999">Please enter email</div>');
        }

        // Set hasError flag to true and remember the first field with an error
        hasError = true;
        if (!firstErrorField) {
          firstErrorField = $(this);
        }
      } else {
        // Add a green border to the field
        $(this).css('border', '1px solid #99ff99');

        // Remove the pop-up message from the field
        $(this).next('.popup-message').remove();
      }
    });

    // If there's an error, prevent the form from submitting and scroll to the first field with an error
    if (hasError) {
      event.preventDefault();
      $('html, body').animate({
        scrollTop: firstErrorField.offset().top
      }, 500);
    }
  });

  // When the user starts typing in a field

    $(document).on('input', 'input[name="guardian_email"]', function() {
  // Check if the border color is red
  if ($(this).css('border-color') === 'rgb(255, 153, 153)') {
    // Remove the red border and pop-up message from the field
    $(this).attr('style', 'border: 1px solid #008000 !important');
    $(this).next('.popup-message').remove();
  } else {
    // Otherwise, add a green border to the field
    $(this).css('border', '');

    // Remove the pop-up message from the field
    $(this).next('.popup-message').remove();
  }
});
});
// guardian zip
$(document).ready(function() {
  // When the form is submitted
  $('form').submit(function(event) {
    // Get the surname input fields
    var surnameFields = $('input[name="guardian_postalCode"]');

    // Check if any of the fields are empty
    var hasError = false;
    var firstErrorField;
    surnameFields.each(function() {
      if ($(this).val().trim() === '') {
        // Add a red border to the field
        $(this).css('border', '1px solid #ff9999');

        // Check if a pop-up message already exists
        if (!$(this).next('.popup-message').length) {
          // Add a pop-up message to the field
          $(this).after('<div class="popup-message" style="color: #ff9999">Please enter Zip/Postal Code</div>');
        }

        // Set hasError flag to true and remember the first field with an error
        hasError = true;
        if (!firstErrorField) {
          firstErrorField = $(this);
        }
      } else {
        // Add a green border to the field
        $(this).css('border', '1px solid #99ff99');

        // Remove the pop-up message from the field
        $(this).next('.popup-message').remove();
      }
    });

    // If there's an error, prevent the form from submitting and scroll to the first field with an error
    if (hasError) {
      event.preventDefault();
      $('html, body').animate({
        scrollTop: firstErrorField.offset().top
      }, 500);
    }
  });

  // When the user starts typing in a field

    $(document).on('input', 'input[name="guardian_postalCode"]', function() {
  // Check if the border color is red
  if ($(this).css('border-color') === 'rgb(255, 153, 153)') {
    // Remove the red border and pop-up message from the field
    $(this).attr('style', 'border: 1px solid #008000 !important');
    $(this).next('.popup-message').remove();
  } else {
    // Otherwise, add a green border to the field
    $(this).css('border', '');

    // Remove the pop-up message from the field
    $(this).next('.popup-message').remove();
  }
});
});
// other details
$(document).ready(function() {
  // When the form is submitted
  $('form').submit(function(event) {
    // Get the surname input fields
    var surnameFields = $('input[name="fee_detail"]');

    // Check if any of the fields are empty
    var hasError = false;
    var firstErrorField;
    surnameFields.each(function() {
      if ($(this).val().trim() === '') {
        // Add a red border to the field
        $(this).css('border', '1px solid #ff9999');

        // Check if a pop-up message already exists
        if (!$(this).next('.popup-message').length) {
          // Add a pop-up message to the field
          $(this).after('<div class="popup-message" style="color: #ff9999">Please enter Fee Details</div>');
        }

        // Set hasError flag to true and remember the first field with an error
        hasError = true;
        if (!firstErrorField) {
          firstErrorField = $(this);
        }
      } else {
        // Add a green border to the field
        $(this).css('border', '1px solid #99ff99');

        // Remove the pop-up message from the field
        $(this).next('.popup-message').remove();
      }
    });

    // If there's an error, prevent the form from submitting and scroll to the first field with an error
    if (hasError) {
      event.preventDefault();
      $('html, body').animate({
        scrollTop: firstErrorField.offset().top
      }, 500);
    }
  });

  // When the user starts typing in a field

    $(document).on('input', 'input[name="fee_detail"]', function() {
  // Check if the border color is red
  if ($(this).css('border-color') === 'rgb(255, 153, 153)') {
    // Remove the red border and pop-up message from the field
    $(this).attr('style', 'border: 1px solid #008000 !important');
    $(this).next('.popup-message').remove();
  } else {
    // Otherwise, add a green border to the field
    $(this).css('border', '');

    // Remove the pop-up message from the field
    $(this).next('.popup-message').remove();
  }
});
});
// Initial Deposited
$(document).ready(function() {
  // When the form is submitted
  $('form').submit(function(event) {
    // Get the family status select field
    var familyStatusField = $('select[name="payment_method"]');

    // Check if the field is empty
    if ($(familyStatusField).val() === null) {
      // Add a red border to the field
      $(familyStatusField).css('border', '1px solid #ff9999');

      // Check if a pop-up message already exists
      if (!$(familyStatusField).next('.popup-message').length) {
        // Add a pop-up message to the field
        $(familyStatusField).after('<div class="popup-message" style="color: #ff9999">Please select initial deposit</div>');
      }

      // Prevent the form from submitting
      event.preventDefault();
    } else {
      // Add a green border to the field
      $(familyStatusField).css('border', '');

      // Remove the pop-up message from the field
      $(familyStatusField).next('.popup-message').remove();
    }
  });

  // When the user changes the select field
  $(document).on('change', 'select[name="payment_method"]', function() {
    // Check if the border color is red
    if ($(this).css('border-color') === 'rgb(255, 153, 153)') {
      // Remove the red border and pop-up message from the field
      $(this).attr('style', 'border: 1px solid #008000 !important');
      $(this).next('.popup-message').remove();
    } else {
      // Otherwise, add a green border to the field
      $(this).css('border', '');

      // Remove the pop-up message from the field
      $(this).next('.popup-message').remove();
    }
  });
});
//
$(document).ready(function() {
  // When the form is submitted
  $('form').submit(function(event) {
    // Get the surname input fields
    var surnameFields = $('input[name="guardian_mobile"]');

    // Check if any of the fields are empty
    var hasError = false;
    var firstErrorField;
    surnameFields.each(function() {
      if ($(this).val().trim() === '') {
        // Add a red border to the field
        $(this).css('border', '1px solid #ff9999');

        // Check if a pop-up message already exists
        if (!$(this).next('.popup-message').length) {
          // Add a pop-up message to the field
          $(this).after('<div class="popup-message" style="color: #ff9999">Please enter mobile</div>');
        }

        // Set hasError flag to true and remember the first field with an error
        hasError = true;
        if (!firstErrorField) {
          firstErrorField = $(this);
        }
      } else {
        // Add a green border to the field
        $(this).css('border', '1px solid #99ff99');

        // Remove the pop-up message from the field
        $(this).next('.popup-message').remove();
      }
    });

    // If there's an error, prevent the form from submitting and scroll to the first field with an error
    if (hasError) {
      event.preventDefault();
      $('html, body').animate({
        scrollTop: firstErrorField.offset().top
      }, 500);
    }
  });

  // When the user starts typing in a field

    $(document).on('input', 'input[name="guardian_mobile"]', function() {
  // Check if the border color is red
  if ($(this).css('border-color') === 'rgb(255, 153, 153)') {
    // Remove the red border and pop-up message from the field
    $(this).attr('style', 'border: 1px solid #008000 !important');
    $(this).next('.popup-message').remove();
  } else {
    // Otherwise, add a green border to the field
    $(this).css('border', '');

    // Remove the pop-up message from the field
    $(this).next('.popup-message').remove();
  }
});
});
//
$(document).ready(function() {
  // When the form is submitted
  $('form').submit(function(event) {
    // Get the surname input fields
    var surnameFields = $('input[name="kin_name"]');

    // Check if any of the fields are empty
    var hasError = false;
    var firstErrorField;
    surnameFields.each(function() {
      if ($(this).val().trim() === '') {
        // Add a red border to the field
        $(this).css('border', '1px solid #ff9999');

        // Check if a pop-up message already exists
        if (!$(this).next('.popup-message').length) {
          // Add a pop-up message to the field
          $(this).after('<div class="popup-message" style="color: #ff9999">Please enter kin name</div>');
        }

        // Set hasError flag to true and remember the first field with an error
        hasError = true;
        if (!firstErrorField) {
          firstErrorField = $(this);
        }
      } else {
        // Add a green border to the field
        $(this).css('border', '1px solid #99ff99');

        // Remove the pop-up message from the field
        $(this).next('.popup-message').remove();
      }
    });

    // If there's an error, prevent the form from submitting and scroll to the first field with an error
    if (hasError) {
      event.preventDefault();
      $('html, body').animate({
        scrollTop: firstErrorField.offset().top
      }, 500);
    }
  });

  // When the user starts typing in a field

    $(document).on('input', 'input[name="kin_name"]', function() {
  // Check if the border color is red
  if ($(this).css('border-color') === 'rgb(255, 153, 153)') {
    // Remove the red border and pop-up message from the field
    $(this).attr('style', 'border: 1px solid #008000 !important');
    $(this).next('.popup-message').remove();
  } else {
    // Otherwise, add a green border to the field
    $(this).css('border', '');

    // Remove the pop-up message from the field
    $(this).next('.popup-message').remove();
  }
});
});
// guardian_address
$(document).ready(function() {
  // When the form is submitted
  $('form').submit(function(event) {
    // Get the surname input fields
    var surnameFields = $('input[name="guardian_address"]');

    // Check if any of the fields are empty
    var hasError = false;
    var firstErrorField;
    surnameFields.each(function() {
      if ($(this).val().trim() === '') {
        // Add a red border to the field
        $(this).css('border', '1px solid #ff9999');

        // Check if a pop-up message already exists
        if (!$(this).next('.popup-message').length) {
          // Add a pop-up message to the field
          $(this).after('<div class="popup-message" style="color: #ff9999">Please enter guardian address</div>');
        }

        // Set hasError flag to true and remember the first field with an error
        hasError = true;
        if (!firstErrorField) {
          firstErrorField = $(this);
        }
      } else {
        // Add a green border to the field
        $(this).css('border', '1px solid #99ff99');

        // Remove the pop-up message from the field
        $(this).next('.popup-message').remove();
      }
    });

    // If there's an error, prevent the form from submitting and scroll to the first field with an error
    if (hasError) {
      event.preventDefault();
      $('html, body').animate({
        scrollTop: firstErrorField.offset().top
      }, 500);
    }
  });

  // When the user starts typing in a field

    $(document).on('input', 'input[name="guardian_address"]', function() {
  // Check if the border color is red
  if ($(this).css('border-color') === 'rgb(255, 153, 153)') {
    // Remove the red border and pop-up message from the field
    $(this).attr('style', 'border: 1px solid #008000 !important');
    $(this).next('.popup-message').remove();
  } else {
    // Otherwise, add a green border to the field
    $(this).css('border', '');

    // Remove the pop-up message from the field
    $(this).next('.popup-message').remove();
  }
});
});
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
    <script></script>
@endsection
