@extends('layouts.auth')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/libs/datatables/datatables.css') }}">
@endsection

@section('content')
<div class="container-fluid flex-grow-1 container-p-y">

    <div class="media align-items-center py-3 mb-3">
    <img src="{{ asset('img/avatars/user-default.png') }}" alt="" class="d-block ui-w-100 rounded-circle">
      <div class="media-body ml-4">
      <h4 class="font-weight-bold mb-0">{{ @$student->name }} <span class="text-muted font-weight-normal">{{ $student->surname }}</span></h4>
      <div class="text-muted mb-2">ID: {{ @$student->studentid }}</div>
      <a href="{{ route('admin.admission.edit', @$student->studentid) }}" class="btn btn-primary btn-sm">Edit</a>&nbsp;
      <a href="{{ route('admin.admission.show', @$student->studentid) }}" class="btn btn-default btn-sm">Profile</a>&nbsp;
      <a href="{{ route('admin.admission.index') }}" class="btn btn-warning btn-sm">Back</a>&nbsp;
        {{-- <a href="javascript:void(0)" class="btn btn-default btn-sm icon-btn"><i class="ion ion-md-mail"></i></a> --}}
      </div>
    </div>



    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Family Details</h5>
          <table class="table user-view-table m-0">
            <tbody>
                <tr>
                    <td>Student Name:</td>
                    <td>{{ @$student->studentname }} {{ @$student->studentsur }}</td>
                  </tr>

              <tr>
                  <td>Family Id:</td>
                  <td>{{ @$admission->familyno }}</td>
                </tr>
              {{-- <tr>
                <td>Registered:</td>
                <td>{{ @$admission ? \Carbon\Carbon::parse(@$admission->created_at)->format('d-M-Y'): '' }}</td>
              </tr> --}}
              <tr>
                <td>Family Status:</td>
                <td> @if(@$admission->familystatus == 'Active') <span class="badge badge-outline-success"> Active </span>&nbsp @else <span class="badge badge-outline-danger"> De-Active @endif </td>
              </tr>
              <tr>
                <td>Joining Date:</td>
              <td>
                @if(!empty($admission->joiningdate && preg_match('/\d/', $student->joiningdate)))
                {{ \Carbon\Carbon::parse($admission->joiningdate)->format('d-F-Y') }}
            @endif
                {{-- {{ @$admission->joiningdate }} --}}
            </td>
              </tr>
              <tr>
                <td>Fee Detail:</td>
                <td>{{ @$admission->feedetail}}</td>
              </tr>
              {{-- <tr>
                <td>Paid:</td>

                <td>{{ @$paid ? @$paid: ''  }}</td>
              </tr> --}}
              {{-- <tr>
                <td>Payment Method:</td>
                <td>{{ @$payment_method ? @$payment_method: ''  }}</td>
              </tr> --}}
              {{-- <tr>

                <td>Medical Condition:</td>
                <td>{{ @$student->medical_condition == 1 ? 'Yes' : 'No'  }}</td>
              </tr> --}}
              <tr>
                <td>Comment:</td>
                <td>{{ @$admission->add_comment}}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>


    <!--  Guardian Details -->
      <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Guardian Details</h5>
          <table class="table user-view-table m-0">
            <tbody>
              <tr>
                  <td>Name:</td>
                  <td>{{ @$guardianData->guardianname }}</td>
                </tr>
              <tr>
                <td>Address:</td>
                <td>{{ @$guardianData->guardianaddress }}</td>
              </tr>
              <tr>
                <td>Mobile:</td>
              <td>{{ @$guardianData->guardianmob  }}</td>
              </tr>
              {{-- <tr>
                <td>Telephone:</td>
              <td>{{ @$student->guardian->telephone  }}</td>
              </tr> --}}
              {{-- <tr> --}}

                {{-- <td>City:</td>
              <td>{{ @$student->guardian->city }}</td>
              </tr>
              <tr>
                <td>Zip/Postal Code:</td>
              <td>{{ @$student->guardian->postal_code }}</td>
              </tr>
              <tr>
                <td>Address:</td>
              <td>{{ @$student->guardian->address }}</td>

              </tr>
              <tr>
                <td>Street Address:</td>
              <td>{{ @$student->guardian->street_address }}</td> --}}
              </tr>

            </tbody>
          </table>
        </div>
      </div>


    <!-- Kin Details -->
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Kin Details</h5>
          <table class="table user-view-table m-0">
            <tbody>
              <tr>
                  <td>Name:</td>
                  <td>{{ @$kinDetails->kinname }}</td>
                </tr>
              <tr>
                <td>Address:</td>
                <td>{{ @$kinDetails->kinaddress }}</td>
              </tr>
              <tr>
                <td>Mobile:</td>
              <td>{{ @$kinDetails->kinmob  }}</td>
              </tr>
              {{-- <tr>
                <td>Address:</td>
              <td>{{ @$student->kin->address == 'temporary null' ? '' : @$student->kin->address }}</td>
              </tr> --}}

            </tbody>
          </table>
        </div>
      </div>
      {{-- <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Kin Details/2</h5>
          <table class="table user-view-table m-0">
            <tbody>
              <tr>
                  <td>Name:</td>
                  <td>{{ @$student->kin->name2 }}</td>
                </tr>
              <tr>
                <td>E-mail:</td>
                <td>{{ @$student->kin->email2 }}</td>
              </tr>
              <tr>
                <td>Mobile:</td>
              <td>{{ @$student->kin->mobile2  }}</td>
              </tr>
              {{-- <tr>
                <td>Address:</td>
              <td>{{ @$student->kin->address2  == 'temporary null' ? '' : @$student->kin->address2}}</td>
              </tr> --}}

            {{-- </tbody>
          </table>
        </div>
      </div> --}}


    <div class="card">
        <div class="card-body">
          <h5 class="card-title">Total Students</h5>
          <hr class="border-light m-0">
          <div class="table-responsive">
            <table id="example" class="table card-table m-0">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Surname</th>
                        <th>Date of Birth</th>
                        <th>Gender</th>
                        <th>Years in School</th>
                        <th>Hours</th>
                      </tr>
                </thead>
                <tbody>
                    @foreach (@$total_students as $student)
                        <tr>
                            <td>{{ @$student->studentname }}</td>
                            <td>{{ @$student->studentsur }}</td>
                            <td>
                                @if(!empty($student->studentdob && preg_match('/\d/', $student->studentdob)))
                                    {{ \Carbon\Carbon::parse($student->studentdob)->format('d-F-Y') }}
                                @endif
                                {{-- {{@$student->studentdob }} --}}
                            </td>
                            <td>{{ @$student->studentgender }}</td>
                            <td>{{ @$student->studentyearinschool }}</td>
                            <td>{{ @$student->studenthours }}</td>
                         </tr>
                    @endforeach
              </tbody>
            </table>
        </div>
        </div>
    </div>

  </div>
@endsection

@section('scripts')
<script src="{{ asset('assets/libs/datatables/datatables.js') }}"></script>
<script>
    $('#example').DataTable();
</script>
@endsection
