@extends('layouts.theme')

@section('style')
<link href="{{ asset('assets/plugins/datetimepicker/css/classic.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/datetimepicker/css/classic.time.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/datetimepicker/css/classic.date.css') }}" rel="stylesheet" />
<link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.min.css')}}">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
@endsection

@section('content')

<div class="row">
    <div class="col-xl-11 mx-auto">
        <h6 class="mb-0 text-uppercase">Admissions</h6>
        <hr>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(Session::has('created-status'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> {{ Session::get('created-status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
            @endif


        <div class="card border-top border-0 border-4 border-info">
            <div class="card-body">
                <div class="border p-4 rounded">
                    <div class="card-title d-flex align-items-center">
                        <div><i class="bx bxs-user me-1 font-22 text-info"></i>
                        </div>
                        <h5 class="mb-0 text-info">Add Student Form</h5>
                    </div>
                    <hr>

            <form method="POST" class="form-horizontal" action="{{ route('admin.admission.store') }}">
                @csrf
                    <div class="row mb-3">
                        <div class="col-md-6 mb-3">
                            <label for="">Joining Date</label>
                        <input type="text" name="joining_date" class="form-control datepicker" value="{{ old('joining_date') }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="family status">Status</label>
                            <select name="family_status" class="form-control">
                                <option selected disabled>Choose</option>
                                <option @if( old('family_status') == 1 ) selected @endif value="1">Active</option>
                                <option @if( old('family_status') == 0 ) selected @endif value="0">De-Active</option>
                        </select>
                        </div>

                    </div>

                    <!-- Students data in the table -->
                    <div class="table-responsive">
                            <table class="table table-bordered table-highlight">
                                <thead>
                                    <td style="width: 20%">First Name</td>
                                    <td style="width: 20%">Surname</td>
                                    <td style="width: 20%">Date of Birth</td>
                                    <td style="width: 13%">Gender</td>
                                    <td style="width: 13%">Years</td>
                                    <td style="width: 13%">Hours</td>
                                </thead>
                                <tbody>

                                    <!-- First Student -->
                                    <tr>
                                    <td><input type="text" name="first_name_1" class="form-control" value="{{ old('first_name_1') }}"></td>

                                        <td><input type="text" name="surname_1" class="form-control" value="{{ old('surname_1') }}"></td>

                                        <td><input type="date" name="dob_1" class="form-control datepicker" value="{{ old('dob_1') }}"></td>


                                        <td>
                                            <select name="gender_1" class="form-control">
                                                    <option selected disabled>Choose</option>
                                                    <option @if( old('gender_1') == "male" ) selected @endif value="male">Male</option>
                                                    <option @if( old('gender_1') == "female" ) selected @endif value="female">Female</option>
                                            </select>
                                        </td>

                                        <td>
                                            <select name="years_in_school_1" class="form-control">
                                                    <option selected disabled>Choose</option>
                                                    <option @if( old('years_in_school_1') == 1 ) selected @endif value="1">1 Year</option>
                                                    <option @if( old('years_in_school_1') == 2 ) selected @endif value="2">2 Year</option>
                                                    <option @if( old('years_in_school_1') == 3 ) selected @endif value="3">3 Year</option>
                                                    <option @if( old('years_in_school_1') == 4 ) selected @endif value="4">4 Year</option>
                                                    <option @if( old('years_in_school_1') == 5 ) selected @endif value="5">5 Year</option>
                                                    <option @if( old('years_in_school_1') == 6 ) selected @endif value="6">6 Year</option>
                                            </select>
                                        </td>

                                        <td><input type="number" name="hours_1" class="form-control" value="{{ old('hours_1') }}"></td>
                                    </tr>

                                    <!-- Second student -->
                                    <tr>
                                        <td><input type="text" name="first_name_2" class="form-control" value="{{ old('first_name_2') }}"></td>

                                        <td><input type="text" name="surname_2" class="form-control" value="{{ old('surname_2') }}"></td>

                                        <td><input type="text" name="dob_2" class="form-control datepicker" value="{{ old('dob_2') }}"></td>
                                        <td>
                                            <select name="gender_2" class="form-control">
                                                    <option selected disabled>Choose</option>
                                                    <option @if( old('gender_2') == "male" ) selected @endif value="male">Male</option>
                                                    <option @if( old('gender_2') == "female" ) selected @endif value="female">Female</option>
                                            </select>
                                        </td>

                                        <td>
                                            <select name="years_in_school_2" class="form-control">
                                                    <option selected disabled>Choose</option>
                                                    <option @if( old('years_in_school_2') == 1 ) selected @endif value="1">1 Year</option>
                                                    <option @if( old('years_in_school_2') == 2 ) selected @endif value="2">2 Year</option>
                                                    <option @if( old('years_in_school_2') == 3 ) selected @endif value="3">3 Year</option>
                                                    <option @if( old('years_in_school_2') == 4 ) selected @endif value="4">4 Year</option>
                                                    <option @if( old('years_in_school_2') == 5 ) selected @endif value="5">5 Year</option>
                                                    <option @if( old('years_in_school_2') == 6 ) selected @endif value="6">6 Year</option>
                                            </select>
                                        </td>

                                        <td><input type="number" name="hours_2" class="form-control" value="{{ old('hours_2') }}"></td>

                                    </tr>

                                    <!-- Third student -->
                                    <tr>
                                        <td><input type="text" name="first_name_3" class="form-control" value="{{ old('first_name_3') }}"></td>

                                        <td><input type="text" name="surname_3" class="form-control" value="{{ old('surname_3') }}"></td>

                                        <td><input type="text" name="dob_3" class="form-control datepicker" value="{{ old('dob_3') }}"></td>
                                        <td>
                                            <select name="gender_3" class="form-control">
                                                    <option selected disabled>Choose</option>
                                                    <option @if( old('gender_3') == "male" ) selected @endif value="male">Male</option>
                                                    <option @if( old('gender_3') == "female" ) selected @endif value="female">Female</option>
                                            </select>
                                        </td>
                                        <td>
                                            <select name="years_in_school_3" class="form-control">
                                                    <option selected disabled>Choose</option>
                                                    <option @if( old('years_in_school_3') == 1 ) selected @endif value="1">1 Year</option>
                                                    <option @if( old('years_in_school_3') == 2 ) selected @endif value="2">2 Year</option>
                                                    <option @if( old('years_in_school_3') == 3 ) selected @endif value="3">3 Year</option>
                                                    <option @if( old('years_in_school_3') == 4 ) selected @endif value="4">4 Year</option>
                                                    <option @if( old('years_in_school_3') == 5 ) selected @endif value="5">5 Year</option>
                                                    <option @if( old('years_in_school_3') == 6 ) selected @endif value="6">6 Year</option>
                                            </select>
                                        </td>

                                        <td><input type="number" name="hours_3" class="form-control" value="{{ old('hours_3') }}"></td>
                                    </tr>


                                     <!-- Fourth student -->
                                     <tr>
                                        <td><input type="text" name="first_name_4" class="form-control" value="{{ old('first_name_4') }}"></td>

                                        <td><input type="text" name="surname_4" class="form-control" value="{{ old('surname_4') }}"></td>

                                        <td><input type="text" name="dob_4" class="form-control datepicker" value="{{ old('dob_4') }}"></td>
                                        <td>
                                            <select name="gender_4" class="form-control">
                                                    <option selected disabled>Choose</option>
                                                    <option @if( old('gender_4') == "male" ) selected @endif value="male">Male</option>
                                                    <option @if( old('gender_4') == "female" ) selected @endif value="female">Female</option>
                                            </select>
                                        </td>
                                        <td>
                                            <select name="years_in_school_4" class="form-control">
                                                    <option selected disabled>Choose</option>
                                                    <option @if( old('years_in_school_4') == 1 ) selected @endif value="1">1 Year</option>
                                                    <option @if( old('years_in_school_4') == 2 ) selected @endif value="2">2 Year</option>
                                                    <option @if( old('years_in_school_4') == 3 ) selected @endif value="3">3 Year</option>
                                                    <option @if( old('years_in_school_4') == 4 ) selected @endif value="4">4 Year</option>
                                                    <option @if( old('years_in_school_4') == 5 ) selected @endif value="5">5 Year</option>
                                                    <option @if( old('years_in_school_4') == 6 ) selected @endif value="6">6 Year</option>
                                            </select>
                                        </td>

                                        <td><input type="number" name="hours_4" class="form-control" value="{{ old('hours_4') }}"></td>
                                    </tr>


                                      <!-- Fivth student -->
                                      <tr>
                                        <td><input type="text" name="first_name_5" class="form-control" value="{{ old('first_name_5') }}"></td>

                                        <td><input type="text" name="surname_5" class="form-control" value="{{ old('surname_5') }}"></td>

                                        <td><input type="text" name="dob_5" class="form-control datepicker" value="{{ old('dob_5') }}"></td>
                                        <td>
                                            <select name="gender_5" class="form-control">
                                                    <option selected disabled>Choose</option>
                                                    <option @if( old('gender_5') == "male" ) selected @endif value="male">Male</option>
                                                    <option @if( old('gender_5') == "female" ) selected @endif value="female">Female</option>
                                            </select>
                                        </td>
                                        <td>
                                            <select name="years_in_school_5" class="form-control">
                                                    <option selected disabled>Choose</option>
                                                    <option @if( old('years_in_school_5') == 1 ) selected @endif value="1">1 Year</option>
                                                    <option @if( old('years_in_school_5') == 2 ) selected @endif value="2">2 Year</option>
                                                    <option @if( old('years_in_school_5') == 3 ) selected @endif value="3">3 Year</option>
                                                    <option @if( old('years_in_school_5') == 4 ) selected @endif value="4">4 Year</option>
                                                    <option @if( old('years_in_school_5') == 5 ) selected @endif value="5">5 Year</option>
                                                    <option @if( old('years_in_school_5') == 6 ) selected @endif value="6">6 Year</option>
                                            </select>
                                        </td>

                                        <td><input type="number" name="hours_5" class="form-control" value="{{ old('hours_5') }}"></td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>

                </div>
            </div>
        </div>
    </div>
</div>


<!-- Gaurdian Form -->
<div class="row">
    <div class="col-xl-11 mx-auto">
        {{-- <hr> --}}
        <div class="card border-top border-0 border-4 border-info">
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
                             <label for="name">Name</label>
                             <input type="text" name="guardian_name" class="form-control" value="{{ old('guardian_name') }}" />
                        </div>
                        <div class="col-md-6">
                             <label for="surname">Surname</label>
                             <input type="text" name="guardian_surname" class="form-control" value="{{ old('guardian_surname') }}" />
                        </div>
                     </div>

                     <div class="row mb-3">
                        <div class="col-md-6">
                             <label for="surname">E-mail</label>
                             <input type="text" name="guardian_email" class="form-control" value="{{ old('guardian_email') }}" />
                        </div>
                        <div class="col-md-6">
                             <label for="surname">Mobile</label>
                             <input type="number" name="guardian_mobile" class="form-control" value="{{ old('guardian_mobile') }}" />
                        </div>
                     </div>

                     <div class="row mb-3">
                        <div class="col-md-12">
                             <label for="guardian_address">Address</label>
                        <textarea name="guardian_address" class="form-control" cols="50" rows="5">{{ old('guardian_address') }}</textarea>
                        </div>
                     </div>

                </div>
            </div>
        </div>
    </div>

</div>


<!-- Kin Form -->
<div class="row" id="student_2">
    <div class="col-xl-11 mx-auto">
        {{-- <hr> --}}
        <div class="card border-top border-0 border-4 border-info">
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
                             <label for="surname">Name</label>
                             <input type="text" name="kin_name" class="form-control" value="{{ old('kin_name') }}" />
                        </div>
                        <div class="col-md-6">
                             <label for="surname">E-mail</label>
                             <input type="text" name="kin_email" class="form-control" value="{{ old('kin_email') }}" />
                        </div>
                     </div>

                     <div class="row mb-3">
                        <div class="col-md-6">
                             <label for="surname">Telephone</label>
                             <input type="text" name="kin_telephone" class="form-control" value="{{ old('kin_telephone') }}" />
                        </div>
                        <div class="col-md-6">
                             <label for="surname">Mobile</label>
                             <input type="number" name="kin_mobile" class="form-control" value="{{ old('kin_mobile') }}" />
                        </div>
                     </div>

                     <div class="row mb-3">
                        <div class="col-md-12">
                             <label for="guardian_address">Address</label>
                             <textarea name="kin_address" class="form-control" cols="50" rows="5">{{ old('kin_address') }}</textarea>
                        </div>
                     </div>

                </div>
            </div>
        </div>
    </div>

</div>


<!-- Other detail Form -->
<div class="row" id="student_2">
    <div class="col-xl-11 mx-auto">
        {{-- <hr> --}}
        <div class="card border-top border-0 border-4 border-info">
            <div class="card-body">
                <div class="border p-4 rounded">
                    <div class="card-title d-flex align-items-center">
                        <div><i class="bx bxs-user me-1 font-22 text-info"></i>
                        </div>
                        <h5 class="mb-0 text-info">Does Any Child Have Medical Conditions?</h5>
                    </div>
                    <hr>

                    <div class="row mb-3">
                        <div class="col-md-6">
                             <label for="Fee Details">Fee Details</label>
                             <input type="text" name="fee_detail" class="form-control" value="{{ old('fee_detail') }}" />
                        </div>
                        <div class="col-md-6">
                             <label for="surname">Payment Method</label>
                             <select name="payment_method" class="form-control">
                                 <option selected disabled>Choose an option</option>
                                 <option value="cash-payment">Cash Payment</option>
                                 <option value="card-payment">Card Payment</option>
                                 <option value="bank-transfter">Bank Transfer</option>
                             </select>
                        </div>
                     </div>

                     <div class="row mb-3">
                        <div class="col-md-12">
                             <label for="medical_condition">Does Any Child Have Medical Conditions?</label>
                             <textarea name="medical_condition" class="form-control" cols="50" rows="5">{{ old('medical_condition') }}</textarea>
                        </div>
                     </div>

                     <div class="row mb-3">
                        <div class="col-md-12">
                             <label for="comment">Comment</label>
                             <textarea name="comment" class="form-control" cols="50" rows="5">{{ old('comment') }}</textarea>
                        </div>
                     </div>

                     <div class="row mb-3">
                        <div class="d-grid">
                             <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                        </div>
                     </div>

                </div>
            </div>
        </div>
    </div>

</div>

@endsection


@section('script')
<script src="{{ asset('assets/plugins/datetimepicker/js/legacy.js') }}"></script>
<script src="{{ asset('assets/plugins/datetimepicker/js/picker.js') }}"></script>
<script src="{{ asset('assets/plugins/datetimepicker/js/picker.time.js') }}"></script>
<script src="{{ asset('assets/plugins/datetimepicker/js/picker.date.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap-material-datetimepicker/js/moment.min.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.min.js') }}"></script>

<script>
    $('.datepicker').pickadate({
        selectMonths: true,
        selectYears: true
    }),
    $('.timepicker').pickatime()
</script>
<script>
    $(function () {
        $('#date-time').bootstrapMaterialDatePicker({
            format: 'YYYY-MM-DD HH:mm'
        });
        $('#date').bootstrapMaterialDatePicker({
            time: false
        });
        $('#time').bootstrapMaterialDatePicker({
            date: false,
            format: 'HH:mm'
        });
    });
</script>

<script>
</script>

@endsection
