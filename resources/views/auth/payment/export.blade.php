@extends('layouts.auth')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/libs/datatables/datatables.css') }}">
    {{-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> --}}
    {{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css"> --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.0/css/buttons.dataTables.min.css">

    <link href="{{ asset('assets/libs/datetimepicker/css/classic.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/libs/datetimepicker/css/classic.date.css') }}" rel="stylesheet" />

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
                <span class="text-muted font-weight-light"></span><b>Export Payments</b>
            </h4>
            <div class="form-row">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Export Payments</li>
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

        <form method="GET" action="{{ route('admin.payment.export.show') }}">
            <!-- Filters -->
            <div class="ui-bordered px-4 pt-4 mb-4" style="background-color:white;box-shadow: 1px 1px 4px 6px	#039dfe;">
                <div class="form-row">

                    <div class="col-md-4 mb-4">
                        <label class="form-label" style="font-size: 17px;">From <span id="star" style="font-size:12px;">(required)</span></label>
                        <input type="date" id="date" name="from_date" class="form-control"
                               value="{{ request()->from_date ? request()->from_date : date('Y-m-d') }}" placeholder="yyyy-mm-dd">
                      </div>






                      <div class="col-md-4 mb-4">
                        <label class="form-label" style="font-size: 17px;">To <span id="star" style="font-size:12px;">(required)</span></label>
                        <input type="date" id="date" name="to_date" class="form-control"
                               value="{{ request()->to_date ? request()->to_date : date('Y-m-d') }}" placeholder="yyyy-mm-dd">
                      </div>



                    <div class="col-md-4 mb-4">
                        <label class="form-label" style="font-size: 17px;">Payment Method <span id="star" style="font-size:12px;">(required)</span></label>
                        <select name="payment_method" class="custom-select" required>
                            <option selected disabled>Choose</option>
                            <option @if (request()->payment_method == 'Cash Payment') selected @endif value="Cash Payment">Cash Payment
                            </option>
                            <option @if (request()->payment_method == 'Card Payment') selected @endif value="Card Payment">Card Payment
                            </option>
                            <option @if (request()->payment_method == 'Bank Transfer') selected @endif value="Bank Transfer">Bank Transfer
                            </option>
                            <option @if (request()->payment_method == 'Adjustment') selected @endif value="Adjustment">Adjustment</option>
                        </select>
                    </div>


                    <div class="col-md-4 mb-4">
                        <button type="submit"
                        style="background-image: linear-gradient(to right, #0082e0 , #02d5df); !important"
                        class="btn btn-primary">View records</button>
                    </div>
                </div>

            </div>
        </form>
        <!-- / Filters -->
        @isset($payments)
            {{-- @dd($payments) --}}
            @if (count($payments) > 0)
            <h6 class="text-center total"><b>Student Fees Payments - Total (£) <span id="totalPaid"></span></b></h6>

                    <div class="card">
                        <div class="card-datatable table-responsive" style="box-shadow: 1px 1px 5px 6px	#f07910;">
                            <table id="example" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Family Id</th>
                                        <th>Start Date</th>
                                        <th>Payment</th>
                                        <th>Payment Method</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($payments as $payment)
                                        <tr>
                                            <td>{{ $payment->paymentfamilyid }}</td>
                                            {{-- <td>
                                                @php
                                                    $date = $payment->paymentdate;
                                                    if ($date != null) {
                                                        $startDate = date('d-m-Y', strtotime($date));
                                                        echo $startDate;
                                                    }
                                                @endphp
                                            </td> --}}
                                            <td>
                                                @php
                                                    $date = $payment->paymentdate;
                                                    if ($date != null) {
                                                        // Convert "YYYY-MM-DD" format to "12 December 2012"
                                                        $formattedDate = date('d F Y', strtotime($date));

                                                        // // Convert "MM/DD/YYYY" format to "12 December 2012"
                                                        // $formattedDate = date('d F Y', strtotime(str_replace('/', '-', $date)));

                                                        echo $formattedDate;
                                                    }
                                                @endphp
                                            </td>

                                            <td>{{ $payment->paid }}</td>
                                            <td>{{ $payment->payment_method }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>




                            {{-- <a href="" class="float-right mt-2 btn btn-info">Export Payments</a> --}}
                        </div>
                    </div>
            @endif
        @endisset

    </div>
    <!-- / Content -->
@endsection

@section('scripts')
    <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>

    <!--Data Table-->
    {{-- <script type="text/javascript"  src=" https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script> --}}
    <script src="{{ asset('assets/libs/datatables/datatables.js') }}"></script>
    <script type="text/javascript" src=" https://cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.min.js"></script>


    <!--Export table buttons-->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script type="text/javascript" src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.24/build/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.24/build/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.1/js/buttons.print.min.js"></script>




    <script src="{{ asset('assets/libs/datetimepicker/js/picker.js') }}"></script>
    <script src="{{ asset('assets/libs/datetimepicker/js/picker.date.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('.datepicker').pickadate({
                selectMonths: true,
                selectYears: true,
            })
        })
    </script>
   <script>
    $(document).ready(function() {
        var table = $('#example').DataTable({
            order: [[1, 'desc']]
        });

        // Calculate and display the sum for the current page
        function updateTotalPaid() {
            var rowData = table.rows({ page: 'current' }).data();

            // Log the rowData to the console
            console.log("rowData:", rowData);

            var totalPaid = rowData
                .pluck(2)
                .reduce(function (a, b) {
                    // Treat empty values or non-numeric values as 0
                    var parsedValue = parseFloat(b);
                    return a + (isNaN(parsedValue) ? 0 : parsedValue);
                }, 0);

            // Log the totalPaid to the console
            console.log("totalPaid:", totalPaid);

            $('#totalPaid').text(totalPaid.toFixed(2));
        }

        // Initial update
        updateTotalPaid();

        // Listen for page changes and update the sum
        table.on('draw', function () {
            updateTotalPaid();
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
