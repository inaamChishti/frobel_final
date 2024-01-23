@extends('layouts.auth')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/libs/datatables/datatables.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
<link href="{{ asset('assets/libs/datetimepicker/css/classic.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/libs/datetimepicker/css/classic.date.css') }}" rel="stylesheet" />
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

@endsection

@section('content')
<div class="container-fluid flex-grow-1 container-p-y">
  <div class="ui-bordered px-4 pt-4 mb-4" style="background-color:white;box-shadow: 1px 1px 4px 6px	#b0516a;">
    <h4 class="font-weight-bold">
        <span class="text-muted font-weight-light"></span><b>Logs</b>
    </h4>
    <div class="form-row">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Logs</li>
            </ol>
        </nav>
    </div>
</div>

    <!-- DataTable within card -->
    <div class="card" style="box-shadow: 1px 1px 4px 6px	#039dfe;">
      <h6 class="card-header float-right" style="font-weight: bold;font-size:18px;">
        System Logs
      </h6>



      <form method="GET" action="{{ route('admin.system.log.show') }}">
        <!-- Filters -->
        <div class="ui-bordered px-4 pt-4 mb-4" style="padding-bottom: 23px; ">

              <div class="container" >
                  <div class="row">
                      <div class="col-md-5 col-lg-5 col-xs-3">
                         <select name="users[]" class="selectpicker form-control" multiple data-live-search="true" required>
                             <option selected disabled>Select User</option>
                             <option value="all">All</option>
                              @foreach ($users as $user)
                                  <option value="{{ $user->id }}">{{ $user->username }}</option>
                              @endforeach
                         </select>
                      </div>
                      <div class="col-md-5 col-lg-5 col-xs-3">
                          <input type="text" id="date" name="date" class="form-control " value="{{ old('date') }}" placeholder="dd/mm/yyyy" required>
                          <script>
                            flatpickr("#date", {
                              dateFormat: "Y-m-d",
                              // Set the first day of the week to Monday (1 for Monday, 7 for Sunday)
                              locale: {
                                firstDayOfWeek: 1
                              }
                            });
                          </script>

      <script>
                            $(document).ready(function () {
                                $("#date").datepicker({
                                    dateFormat: 'dd/mm/yy',
                                    changeYear: true, // Allow changing the year
                                    yearRange: 'c-100:c+10', // Display a range of years centered around the current year
                                    showButtonPanel: true, // Show today and done buttons at the bottom
                                    closeText: 'Done', // Text for the close link
                                    currentText: 'Today', // Text for the current day link
                                    showAnim: 'slideDown', // Animation effect
                                    showOtherMonths: true, // Show dates from other months
                                    selectOtherMonths: true, // Allow selection of dates from other months
                                    showWeek: true, // Show the week number
                                });

                                // Set the current date as the default
                                const today = new Date();
                                $("#date").datepicker("setDate", today);
                            });
                        </script>

                      </div>

                      <div class="col-md-2 col-lg-2 col-xs-3">
                          <input type="submit"
                          style="background-image: linear-gradient(to right, #0082e0 , #02d5df); !important"
                          class="btn btn-primary" value="View">
                      </div>
                  </div>
              </div>
        </div>

      </form>

      @isset($allLogs)
      @if(count($allLogs) > 0)
      <h6 class="text-center"><b>View Previous Record</b></h2>
      <div class="card">
        <div class="card-datatable table-responsive">
          <table id="example" class="table table-striped table-bordered">
            <thead>
              <tr>
                <th>Model</th>
                <th>Description</th>
                <th>Event</th>
                <th>Username</th>
                <th>Created At</th>
              </tr>
            </thead>
            <tbody>


                  @foreach ($allLogs as $log)
                  <tr>
                      <td>{{ $log->log_name }}</td>
                      <td>{{ $log->description }}</td>
                      <td>{{ $log->event }}</td>
                      <td>
                          @php
                                $userName = '';
                                $user = \App\Models\User::find($log->causer_id);
                                if($user){
                                    $userName =  $user->name;
                                }
                                else
                                {
                                    $userName = 'No User';
                                }
                                echo $userName;
                          @endphp
                      </td>
                      <td>
                        @php
                            $timestamp = $log->created_at;

                            // Check if the timestamp is not empty
                            if (!empty($timestamp)) {
                                $formattedDate = \Carbon\Carbon::parse($timestamp)->format('d F Y');
                                echo $formattedDate;
                            }
                        @endphp
                    </td>


                  </tr>
                  @endforeach

            </tbody>
          </table>

        </div>
      </div>
      @else
      <h5 class="text-center text-danger mt-5">No log found corresponding to this user & date.</h5>
      @endif
      @endisset

    </div>

  </div>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
<script src="{{ asset('assets/libs/datatables/datatables.js') }}"></script>
<script src="{{ asset('assets/libs/datetimepicker/js/picker.js') }}"></script>
<script src="{{ asset('assets/libs/datetimepicker/js/picker.date.js') }}"></script>

<script>
    $(document).ready(function(){
         $('.datepicker').pickadate({
             selectMonths: true,
             selectYears: true,
         });

        $('#example').DataTable( {
            order: [[ 4, "asc" ]],
        });
    })


 </script>



@endsection
