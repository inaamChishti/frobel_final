@extends('layouts.auth')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/libs/datatables/datatables.css') }}">
{{-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> --}}
{{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css"> --}}
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.0/css/buttons.dataTables.min.css">

<link href="{{ asset('assets/libs/datetimepicker/css/classic.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/libs/datetimepicker/css/classic.date.css') }}" rel="stylesheet" />

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

  <div class="ui-bordered px-4 pt-4 mb-4" style="background-color:white;">
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

    <form method="GET" action="{{ route('admin.payment.view') }}">
      <!-- Filters -->
      <div class="ui-bordered px-4 pt-4 mb-4">
        <div class="form-row">

          <div class="col-md mb-4">
            <label class="form-label">From <span id="star">*</span></label>
            <input type="text" name="from_date" class="form-control datepicker" value="{{ request()->from_date ? request()->from_date: ''}}" placeholder="dd/mm/yyyy">
          </div>

          <div class="col-md mb-4">
              <label class="form-label">To <span id="star">*</span></label>
              <input type="text" name="to_date" class="form-control datepicker" value="{{ request()->to_date ? request()->to_date: ''}}" placeholder="dd/mm/yyyy">
            </div>

          <div class="col-md mb-4">
              <label class="form-label">Payment Method <span id="star">*</span></label>
              <select name="payment_method" class="custom-select" required>
                  <option selected disabled>Choose</option>
                  <option @if( request()->payment_method == 'Cash Payment') selected @endif value="Cash Payment">Cash Payment</option>
                  <option @if( request()->payment_method == 'Card Payment') selected @endif value="Card Payment">Card Payment</option>
                  <option @if( request()->payment_method == 'Bank Transfer') selected @endif value="Bank Transfer">Bank Transfer</option>
                  <option @if( request()->payment_method == 'Bank/Online') selected @endif value="Bank/Online">Bank/Online</option>
                  <option @if( request()->payment_method == 'Adjustment') selected @endif value="Adjustment">Adjustment</option>
              </select>
          </div>


          <div class="col-md col-xl-2 mb-4">
            <label class="form-label d-none d-md-block">&nbsp;</label>
            <button type="submit" class="btn btn-secondary btn-block">View records</button>
          </div>
        </div>

      </div>
    </form>
    <!-- / Filters -->
    @isset($payments)
    {{-- @dd($payments) --}}
    @if(count($payments) > 0)
    <h6 class="text-center"><b>Student Fees Payments</b></h2>
    <div class="card">
      <div class="card-datatable table-responsive">
        <table id="example" class="table table-striped table-bordered">
          <thead>
            <tr>
              <th>Family Id</th>
              <th>Start Date</th>
              <th>Payment</th>
            </tr>
          </thead>
          <tbody>

                @foreach ($payments as $payment)
                <tr>
                    <td>{{ $payment->family_id }}</td>
                    <td>
                      @php
                          $date = $payment->last_payment_date;
                          $time = strtotime($date);
                          $startDate = date('d-m-Y',$time);
                          echo $startDate;
                      @endphp
                    </td>
                    <td>{{ $payment->paid }}</td>
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
    //   $.noConflict();
 $(document).ready(function() {

    $('#example').DataTable( {
        dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],

});
});
</script>
@endsection
