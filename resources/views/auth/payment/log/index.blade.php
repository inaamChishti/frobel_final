@extends('layouts.auth')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/libs/datatables/datatables.css') }}">
{{-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> --}}
{{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css"> --}}
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.0/css/buttons.dataTables.min.css">

<link href="{{ asset('assets/libs/datetimepicker/css/classic.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/libs/datetimepicker/css/classic.date.css') }}" rel="stylesheet" />

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />


<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<style>
    .datepicker,
    .table-condensed {
      width: 300px;
    }
    #star {
      color: red;
    }
</style>
@endsection

@section('content')
 <!-- Content -->
 <div class="container-fluid flex-grow-1 container-p-y">

    <div class="ui-bordered px-4 pt-4 mb-4" style="background-color:white;box-shadow: 1px 1px 4px 6px	#b0516a;">
        <h4 class="font-weight-bold">
            <span class="text-muted font-weight-light"></span><b> Payments Logs</b>
        </h4>
        <div class="form-row">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page"> Payments Logs</li>
                </ol>
            </nav>
        </div>
    </div>

    @if ($errors->any())
    <div class="alert alert-danger alert-dismissible">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        @foreach ($errors->all() as $error)
         <li>{{ $error }}</li>
        @endforeach
    </div>
    @endif

    <form method="GET" action="{{ route('admin.payment.log.show') }}">
      <!-- Filters -->
      <div class="ui-bordered px-4 pt-4 mb-4 bg-white" style="padding-bottom: 23px;box-shadow: 1px 1px 4px 6px	#039dfe;">

            <div class="container" >
                <div class="row">
                    <div class="col-md-5 col-lg-5 col-xs-3">
                       <select name="users[]" class="selectpicker form-control" multiple data-live-search="true" required>
                           <option selected disabled>Select User</option>
                           <option value="all">All</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->username }}">{{ $user->username }}</option>
                            @endforeach
                       </select>
                    </div>
                    <div class="col-md-5 col-lg-5 col-xs-3">
                        <input type="text" id="date" name="date" class="form-control " value="{{ old('date') }}" placeholder="dd/mm/yyyy" required>
                    </div>
                    <script>
                        const today = new Date();
                           const options = { day: 'numeric', month: 'long', year: 'numeric' };
                           const formattedDate = today.toLocaleDateString('en-US', options).replace(/(\w+) (\d+), (\d+)/, "$2 $1, $3");
                           // Set the formatted date as the input value
                           document.getElementById("date").value = formattedDate;
                         </script>
                    <div class="col-md-2 col-lg-2 col-xs-3">
                        <input type="submit"
                        style="background-image: linear-gradient(to right, #0082e0 , #02d5df); !important"
                        class="btn btn-primary" value="View">
                    </div>
                </div>
            </div>
      </div>
    </form>
    <!-- / Filters -->
    @isset($allPayments)
    @if(count($allPayments) > 0)
    <h6 class="text-center"><b>View Previous Record</b></h2>
    <div class="card">
      <div class="card-datatable table-responsive">
        <table id="example" class="table table-striped table-bordered">
          <thead>
            <tr>
              <th>Family Id</th>
              <th>Total Payment</th>
              <th>Paid</th>
              <th>Bank/Online Payment</th>
              <th>Cash Payment</th>
              <th>Card Payment</th>
              <th>Adjustment</th>
              <th>Collector</th>
              <th>Payment Date</th>
            </tr>
          </thead>
          <tbody>

                @foreach ($allPayments as $payment)
                <tr>
                    <td>{{ $payment->paymentfamilyid ? $payment->paymentfamilyid: '' }}</td>
                    <td>{{ $payment->package }}</td>
                    <td>{{ $payment->paid }}</td>
                    <td>
                        @php

                                echo $payment->bank_transfer;

                        @endphp
                    </td>
                    <td>
                        @php

                                echo $payment->cash_payment;

                        @endphp
                    </td>
                    <td>
                        @php

                                echo $payment->card_payment;

                        @endphp
                    </td>
                    <td>
                        @php

                                echo $payment->adjustment;

                        @endphp
                    </td>
                    <td>{{ $payment->collector }}</td>
                    <td>
                        @php
                            $date = $payment['paymentdate'];

                            // Check if the date is not empty
                            if (!empty($date)) {
                                // Assuming $date is in a format like "Y-m-d"
                                $formattedDate = \Carbon\Carbon::parse($date)->format('d F Y');
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
    <h5 class="text-center text-danger mt-5">No record found corresponding to this family id.</h5>
    @endif
    @endisset

  </div>
  <!-- / Content -->
@endsection

@section('scripts')

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>

  <!--Data Table-->
  {{-- <script type="text/javascript"  src=" https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script> --}}
  <script src="{{ asset('assets/libs/datatables/datatables.js') }}"></script>
  <script type="text/javascript"  src=" https://cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.min.js"></script>


   <!--Export table buttons-->
   <script type="text/javascript"  src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
   <script type="text/javascript" src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.24/build/pdfmake.min.js" ></script>
   <script type="text/javascript"  src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.24/build/vfs_fonts.js"></script>
   <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.html5.min.js"></script>
   <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.1/js/buttons.print.min.js"></script>




<script src="{{ asset('assets/libs/datetimepicker/js/picker.js') }}"></script>
<script src="{{ asset('assets/libs/datetimepicker/js/picker.date.js') }}"></script>

<script>
   $(document).ready(function(){
        $('.datepicker').pickadate({
            selectMonths: true,
            selectYears: true,
        })
   })
</script>
<script>

 $(document).ready(function() {

    $('#example').DataTable( {
        order: [[ 7, "asc" ]],
    });
});
</script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
  document.addEventListener("DOMContentLoaded", function () {
    flatpickr("#date", {
      dateFormat: "d/m/Y",
      // Set the first day of the week to Monday (1 for Monday, 7 for Sunday)
      locale: {
        firstDayOfWeek: 1
      },
      defaultDate: "today" // Auto-select the current date when the page loads
    });
  });
</script>

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
@endsection
