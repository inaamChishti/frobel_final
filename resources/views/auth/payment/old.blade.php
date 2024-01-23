@extends('layouts.auth')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/libs/datatables/datatables.css') }}">
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<link href="{{ asset('assets/libs/datetimepicker/css/classic.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/libs/datetimepicker/css/classic.date.css') }}" rel="stylesheet" />

<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.0/css/buttons.dataTables.min.css">

<style>
    .datepicker,
.table-condensed {
  width: 300px;
}
</style>
@endsection

@section('content')
 <!-- Content -->
 <div class="container-fluid flex-grow-1 container-p-y">

  <div class="ui-bordered px-4 pt-4 mb-4" style="background-color:white;box-shadow: 1px 1px 4px 6px	#b0516a;">
    <h4 class="font-weight-bold">
        <span class="text-muted font-weight-light"></span><b>Track Payments</b>
    </h4>
    <div class="form-row">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Track Payments</li>
            </ol>
        </nav>
    </div>
</div>


    <div class="card" style="box-shadow: 1px 1px 4px 6px	#039dfe; margin-bottom:30px;">
      <div class="card-datatable table-responsive">
        <table id="example" class="table table-striped table-bordered">
          <thead>
              <th width='70px' style="font-size:16px;font-weight:bold;">Family ID</th>
              <th style="font-size:16px;font-weight:bold;">From</th>
              <th style="font-size:16px;font-weight:bold;">To</th>
              <th style="font-size:16px;font-weight:bold;">Last Payment Date</th>
              <th style="font-size:16px;font-weight:bold;">Package</th>
              <th style="font-size:16px;font-weight:bold;">Paid</th>
              <th style="font-size:16px;font-weight:bold;">Balance</th>
              <th style="font-size:16px;font-weight:bold;">Collector</th>
              <th style="font-size:16px;font-weight:bold;">Payment Method</th>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
    </div>

    <a href="{{ route('admin.payment.old.export') }}"
     style="float: right;background-image: linear-gradient(to right, #0082e0 , #02d5df); !important""
    class="btn btn-info mt-2">
        Export Payment</a>
  </div>

  <!-- / Content -->
@endsection

@section('scripts')
<script src="{{ asset('assets/libs/datatables/datatables.js') }}"></script>

 <!--Export table buttons-->
 <script type="text/javascript"  src=" https://cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.min.js"></script>
 <script type="text/javascript"  src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
 <script type="text/javascript" src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.24/build/pdfmake.min.js" ></script>
 <script type="text/javascript"  src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.24/build/vfs_fonts.js"></script>
 <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.html5.min.js"></script>
 <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.1/js/buttons.print.min.js"></script>

<script>
    $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table = $('#example').DataTable({

            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.payment.old') }}",
            columns: [
                {data: 'paymentfamilyid'},
                {data: 'paymentfrom'},
                {data: 'paymentto'},
                {data: 'paymentdate'},
                {data: 'package'},
                {data: 'paid'},
                {
                data: 'balance',
                render: function(data) {
                    if (data && data.charAt(0) === '-') {
                        return data.replace('-', '+');
                    }
                    return data;
                }
            },
                {data: 'collector'},
                {data: 'payment_method'},
            ],

        });

    })
</script>
@endsection
