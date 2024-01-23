


@extends('layouts.auth')
@section('styles')
<link rel="stylesheet" href="{{ asset('assets/libs/datatables/datatables.css') }}">
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<link rel="stylesheet" href="{{ asset('assets/libs/datatables/datatables.css') }}">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('assets/libs/datatables/datatables.js') }}"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.5/xlsx.full.min.js"></script>


</head>
@section('content')
<div class="container-fluid flex-grow-1 container  -p-y">
    <!-- Your existing HTML code -->

    <div class="ui-bordered px-4 pt-4 mb-4" style="background-color:white; box-shadow: 1px 1px 4px 6px	#b0516a;margin-top:20px">
        <h4 class="font-weight-bold">
            <span class="text-muted font-weight-light"></span><b>Defaulter list</b>
        </h4>
        <div class="form-row">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Defaulter list</li>
                </ol>
            </nav>
        </div>
    </div>
    <button class="btn btn-success" onclick="exportAll()" style="margin-bottom: 20px;">Export All</button>

    <div class="card" style=" box-shadow: 1px 1px 4px 6px #039dfe;">
        <!-- Validation Error -->
        <span id="validationError" style="font-size: 16px" class="text-center text-danger error_messages"></span>
        <div class="card-datatable table-responsive">
            <table id="example" class="datatables-demo table table-striped table-bordered">
                <thead>
                    <tr>
                        <th style="font-weight: bold; font-size:18px;">#</th>
                        <th style="font-weight: bold; font-size:18px;">Payment Family ID</th>
                        <th style="font-weight: bold; font-size:18px;">Last Payment Date</th>
                        <th style="font-weight: bold; font-size:18px;">Payment Expiry Date</th>
                        <th style="font-weight: bold; font-size:18px;">Balance</th>
                        <th style="font-weight: bold; font-size:18px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($paymentRecords as $key => $record)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $record->paymentfamilyid }}</td>
                            <td>{{ $record->last_payment_date }}</td>
                            <td>{{ $record->payment_expiry_date }}</td>
                            <td>{{ $record->balance }}</td>
                            <td>
                                <button class="btn btn-danger" onclick="exportRecord(this, {{ json_encode($record) }})">Export</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th style="font-weight: bold;font-size:18px;">#</th>
                        <th style="font-weight: bold;font-size:18px;">Payment Family ID</th>
                        <th style="font-weight: bold;font-size:18px;">Last Payment Date</th>
                        <th style="font-weight: bold;font-size:18px;">Payment Expiry Date</th>
                        <th style="font-weight: bold;font-size:18px;">Balance</th>
                        <th style="font-weight: bold;font-size:18px;">Actions</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="{{ asset('assets/libs/datatables/datatables.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#example').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'excel', 'pdf', 'print'
            ]
        });
    });
</script>

<script>
    function exportRecord(button, record) {
        // Get the table row containing the clicked button
        const row = button.closest('tr');

        // Get the table header values (excluding the last heading)
        const headerValues = Array.from(row.parentNode.previousElementSibling.querySelectorAll('th'))
            .map(header => header.textContent);
        headerValues.pop(); // Remove the last element

        // Get the current row values (excluding the last column)
        const rowValues = Array.from(row.children).map(cell => cell.textContent);
        rowValues.pop(); // Remove the last element

        // Combine header and row values
        const allValues = [headerValues, rowValues];

        // Alert and export as XLSX


        // Create a worksheet and export as XLSX
        const worksheet = XLSX.utils.aoa_to_sheet(allValues);
        const workbook = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(workbook, worksheet, 'Sheet 1');
        XLSX.writeFile(workbook, 'exported_data.xlsx');
    }
</script>

<script>
    function exportAll() {
        // Get all table rows
        const rows = Array.from(document.querySelectorAll('#example tbody tr'));

        // Get the table header values
        const headerValues = Array.from(document.querySelectorAll('#example thead th'))
            .map(header => header.textContent);

        // Prepare an array to store all data
        const allData = [headerValues];

        // Loop through each row and extract data
        rows.forEach(row => {
            const rowValues = Array.from(row.children).map(cell => cell.textContent);

            // Check if the column is "Actions" and exclude it
            const columnIndexToRemove = headerValues.indexOf('Actions');
            if (columnIndexToRemove !== -1) {
                rowValues.splice(columnIndexToRemove, 1);
            }

            allData.push(rowValues);
        });

        // Alert and export as XLSX

        // Create a worksheet and export as XLSX
        const worksheet = XLSX.utils.aoa_to_sheet(allData);
        const workbook = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(workbook, worksheet, 'Sheet 1');
        XLSX.writeFile(workbook, 'exported_data_all.xlsx');
    }
</script>

@endsection
