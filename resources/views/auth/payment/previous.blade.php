@extends('layouts.auth')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/libs/datatables/datatables.css') }}">
{{-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> --}}
{{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css"> --}}
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.0/css/buttons.dataTables.min.css">

<link href="{{ asset('assets/libs/datetimepicker/css/classic.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/libs/datetimepicker/css/classic.date.css') }}" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<style>
    .datepicker,
    .table-condensed {
      width: 300px;
    }
    #star {
      color: red;
    }
    input::placeholder {
    font: 18px sans-serif;
}
</style>
@endsection

@section('content')
 <!-- Content -->
 <div class="container-fluid flex-grow-1 container-p-y">

  <div class="ui-bordered px-4 pt-4 mb-4" style="background-color:white;box-shadow: 1px 1px 4px 6px	#b0516a;">
    <h4 class="font-weight-bold">
        <span class="text-muted font-weight-light"></span><b>Previous Payments</b>
    </h4>
    <div class="form-row">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Previous Payments</li>
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

    <form method="GET" action="{{ route('admin.payment.previous.show') }}">
      <!-- Filters -->
      <div class="ui-bordered px-4 pt-4 mb-4" style="padding-bottom: 23px; background-color: white;box-shadow: 1px 1px 4px 6px	#039dfe;">
        {{-- <div class="form-row"> --}}

            <div class="container">
                <div class="row">
                    <div class="col-md-4 col-xs-6 offset-2">
                        <input type="number" name="family_id" class="form-control" placeholder="Enter family Id">
                    </div>
                    <div class="col-md-4 col-xs-6 ">
                        <button class="btn btn-secondary"
                        style="background-image: linear-gradient(to right, #0082e0 , #02d5df); !important"
                        >Search</button>
                    </div>
                </div>
            </div>



        {{-- </div> --}}

      </div>
    </form>
    <!-- / Filters -->
    @isset($payments)
    {{-- @dd($payments) --}}
    @if(count($payments) > 0)
    <h6 class="text-center"><b>View Previous Record</b></h2>
    <div class="card">

      <div class="card-datatable table-responsive" style="box-shadow: 1px 1px 5px 6px	#f07910;">
        <table id="example" class="table table-striped table-bordered">
          <thead>
            <tr id="thisRow">
                <th>ID</th>
              <th>Family Id</th>
              {{-- <th>Start Date</th> --}}
              <th>Payment From</th>
              <th>Payment To</th>
              <th>Payment Date</th>
              <th>Package</th>
              {{-- <th>Payment</th> --}}
              <th>Paid</th>
              <th>Balance</th>
              <th>Payment Method</th>
              <th>Payment Details</th>
              <th>Collector</th>

            <th>Action</th>
            </tr>
          </thead>
          <tbody>

                @foreach ($payments as $payment)
                <tr id="{{$payment->paymentid}}">
                    <th>{{$payment->paymentid}}</th>
                    <td>{{ $payment->paymentfamilyid }}</td>
                    {{-- <td>
                      @php
                          $date = $payment->last_payment_date;
                          if($date != null) {
                            $time = strtotime($date);
                            $startDate = date('d-m-Y',$time);
                            echo $startDate;
                          }
                      @endphp
                    </td> --}}
                    <th>{{$payment->formatted_paymentfrom}}</th>
                    <th>{{$payment->formatted_paymentto}}</th>
                    <th>{{$payment->formatted_paymentdate}}</th>
                    <th>{{$payment->package}}</th>
                    <th>{{$payment->paid}}</th>
                    <th>{{ str_replace('-', '+', $payment->balance) }}</th>
                    <th>{{$payment->payment_method}}</th>
                    <th>{{$payment->payment_detail}}</th>
                    <th>{{$payment->collector}}</th>
                    <th>
                        {{-- <button class="btn btn-danger print-row-btn" onclick="printCurrentRowData()">Print</button> --}}

                        <button class="btn btn-danger print-row-btn printRecp-{{$payment->paymentid}}" >Print</button>

                        {{-- @if(\Auth::user()->roles->first()->name == 'Super Admin') --}}
                        <form id="delete-form" action="{{ url('admin/PrevDelete', $payment->paymentid) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger dell mt-1">Delete</button>
                        </form>

                        {{-- @endif --}}



                    </th>
                </tr>
                @endforeach

          </tbody>
        </table>
        <!-- Include this script in your HTML file -->
        <script>
            $(document).ready(function() {
                // Attach click event to the button
                $('.print-row-btn').on('click', function() {
                    // Extract paymentid from the class attribute
                    var paymentId = $(this).attr('class').match(/printRecp-(\d+)/)[1];

                    // Make an AJAX request to your Laravel backend
                    $.ajax({
                        url: '{{ url("getIndividualReceipt") }}/' + paymentId,
                        method: 'GET',
                        success: function(data) {
                            // Handle the response, you can alert the payment id


                            // Access pdfDataUri from the returned data
                            var pdfDataUri = data.pdfDataUri;

                            // Open a new window with the PDF
                            var newWindow = window.open();
                            newWindow.document.write('<iframe src="' + pdfDataUri + '" style="width:100%; height:100%;"></iframe>');
                        },
                        error: function(xhr, status, error) {
                            console.log(error);
                        }
                    });
                });
            });
        </script>

        <script>
            function printCurrentRowData() {
                // Get the button element that was clicked
                var button = event.target;

                // Get the closest row to the button
                var row = button.closest('tr');

                // Get the data from each cell in the row
                var paymentId = row.querySelector('th').textContent;
                var paymentFamilyId = row.querySelector('td:nth-child(2)').textContent;
                var paymentFrom = row.querySelector('th:nth-child(3)').textContent;
                var paymentTo = row.querySelector('th:nth-child(4)').textContent;
                var paymentDate = row.querySelector('th:nth-child(5)').textContent;
                var package = row.querySelector('th:nth-child(6)').textContent;
                var paid = row.querySelector('th:nth-child(7)').textContent;
                var balance = row.querySelector('th:nth-child(8)').textContent;
                var paymentMethod = row.querySelector('th:nth-child(9)').textContent;
                var paymentDetail = row.querySelector('th:nth-child(10)').textContent;
                var collector = row.querySelector('th:nth-child(11)').textContent;

                // Create a table element
                var table = document.createElement('table');
                table.style.borderCollapse = 'collapse'; // Collapse borders
                table.style.width = '100%'; // Set table width
                table.style.border = '1px solid black'; // Add border to the table

                // Function to create and style a cell
                function createCell(row, content, isHeader) {
                    var cell = isHeader ? document.createElement('th') : document.createElement('td');
                    cell.textContent = content;
                    cell.style.border = '1px solid black'; // Add border to the cell
                    cell.style.textAlign = 'center'; // Center-align the text
                    if (isHeader) {
                        cell.style.fontWeight = 'bold';
                    }
                    row.appendChild(cell);
                }

                // Create the first row with column labels
                var labelRow = document.createElement('tr');
                createCell(labelRow, 'Payment ID', true);
                createCell(labelRow, 'Payment Family ID', true);
                createCell(labelRow, 'Payment From', true);
                createCell(labelRow, 'Payment To', true);
                createCell(labelRow, 'Payment Date', true);
                createCell(labelRow, 'Package', true);
                createCell(labelRow, 'Paid', true);
                createCell(labelRow, 'Balance', true);
                createCell(labelRow, 'Payment Method', true);
                createCell(labelRow, 'Payment Detail', true);
                createCell(labelRow, 'Collector', true);
                table.appendChild(labelRow);

                // Create the second row with data values
                var valueRow = document.createElement('tr');
                createCell(valueRow, paymentId);
                createCell(valueRow, paymentFamilyId);
                createCell(valueRow, paymentFrom);
                createCell(valueRow, paymentTo);
                createCell(valueRow, paymentDate);
                createCell(valueRow, package);
                createCell(valueRow, paid);
                createCell(valueRow, balance);
                createCell(valueRow, paymentMethod);
                createCell(valueRow, paymentDetail);
                createCell(valueRow, collector);
                table.appendChild(valueRow);

                // Open a new window and append the table to it
                var printWindow = window.open('', '_blank');
                printWindow.document.body.appendChild(table);

                // Add a "Cancel" button to the print window
                var cancelButton = printWindow.document.createElement('button');
                cancelButton.textContent = '';
                cancelButton.onclick = function () {
                    printWindow.close();
                    // Close the current tab
                    window.close();
                };
                printWindow.document.body.appendChild(cancelButton);

                // Print the new window
                printWindow.print();
            }

            // Add an event listener for the "Cancel" button inside the PDF viewer
            document.addEventListener('DOMContentLoaded', function () {
                var pdfCancelButton = document.getElementById('pdfCancelButton');

                if (pdfCancelButton) {
                    pdfCancelButton.addEventListener('click', function () {
                        // Close the current tab when the "Cancel" button in the PDF viewer is clicked
                        window.close();
                    });
                }
            });
        </script>





        {{-- <a href="" class="float-right mt-2 btn btn-info">Export Payments</a> --}}
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
<script src="{{ asset('assets/libs/datetimepicker/js/picker.date.js') }}"></script><!-- DataTables CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.6/css/jquery.dataTables.min.css">

<!-- DataTables Buttons CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.1.3/css/buttons.dataTables.min.css">

<!-- DataTables JavaScript -->
<script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.11.6/js/jquery.dataTables.min.js"></script>

<!-- DataTables Buttons JavaScript -->
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.1.3/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.1.3/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.1.3/js/buttons.print.min.js"></script>

<!-- Moment.js -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

<!-- DataTables Moment.js Plugin -->
<script type="text/javascript" src="https://cdn.datatables.net/plug-ins/1.11.6/sorting/datetime-moment.js"></script>


<script>




   $(document).ready(function(){
        $('.datepicker').pickadate({
            selectMonths: true,
            selectYears: true,
        })
   })

    //   $.noConflict();
 $(document).ready(function() {
    $('#example').DataTable({
    dom: 'Bfrtip',
    buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
    columnDefs: [
        { type: 'date-eu', targets: 4 } // Assuming 'paymentdate' is the fifth column (index 4)
    ],
    order: [[4, 'desc']]
});

});
</script>
@endsection
