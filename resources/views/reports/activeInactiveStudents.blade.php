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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Your existing script tags -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('assets/libs/datatables/datatables.js') }}"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>

    </head>
@section('content')
    <div class="container-fluid flex-grow-1 container -p-y">
        <div class="loader" style="display: none;"></div>
        <!-- Header Section -->
        <div class="ui-bordered px-4 pt-4 mb-4"
            style="background-color:white; box-shadow: 1px 1px 4px 6px	#b0516a;margin-top:20px">
            <h4 class="font-weight-bold">
                <span class="text-muted font-weight-light"></span><b>Active/Inactive Students List</b>
            </h4>
            <div class="form-row">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Active/Inactive Students List</li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- Main Content Section -->
        <div class="card" style="box-shadow: 1px 1px 4px 6px #039dfe;">
            <!-- Validation Error -->
            <span id="validationError" style="font-size: 16px" class="text-center text-danger error_messages"></span>

            <!-- Buttons to Get Active or Inactive Students -->
            <div class="btn-group mb-3">
                <button type="button" class="btn btn-primary" id="getActiveStudents">Get Active Students</button>
                <button type="button" class="btn btn-danger" id="getInactiveStudents">Get Inactive Students</button>
            </div>

            <!-- Table to display data -->
            <div class="card-datatable table-responsive">
                <table id="example" class="datatables-demo table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Record Type</th>
                            <th>Student ID</th>
                            <th>Student Name</th>
                            <th>Student Surname</th>
                            <th>Date of Birth</th>
                            <th>Gender</th>
                            <th>Year in School</th>
                            <th>Student Hours</th>
                            <th>Guardian ID</th>
                            <th>Kin ID</th>
                            <th>Family Id</th>

                        </tr>
                    </thead>
                    <tbody>
                        <!-- Table body content will be filled dynamically -->
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Record Type</th>
                            <th>Student ID</th>

                            <th>Student Name</th>
                            <th>Student Surname</th>
                            <th>Date of Birth</th>
                            <th>Gender</th>
                            <th>Year in School</th>
                            <th>Student Hours</th>
                            <th>Guardian ID</th>
                            <th>Kin ID</th>
                            <th>Family Id</th>

                        </tr>
                    </tfoot>
                </table>

            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- Include your existing script files here -->

    <!-- Additional Script for DataTables and Ajax -->
    <script src="{{ asset('assets/libs/datatables/datatables.js') }}"></script>
    <script>
        $(document).ready(function() {
            var dataTable = $('#example').DataTable({
                dom: 'Bfrtip',
                buttons: ['copy', 'excel', 'pdf', 'print']
            });

            // Ajax function to get data based on status
            function fetchData(status) {
                swal.fire({
            title: 'Please wait system is loading data...',
            allowOutsideClick: false,
            showConfirmButton: false,
            onBeforeOpen: () => {
                swal.showLoading();
            }
        });
                $.ajax({
                    url: '{{ url('/get-active-inactive') }}',
                    method: 'GET',
                    data: {
                        status: status
                    },
                    success: function(data) {
                        // Clear existing data
                        dataTable.clear();

                        // Add new data to the table
                        $.each(data.paymentRecords, function(index, value) {
                            dataTable.row.add([
                                index + 1,
                                value.recordType,
                                value.admissionid,
                                value.studentname,
                                value.studentsur,
                                value.studentdob,
                                value.studentgender,
                                value.studentyearinschool,
                                value.studenthours,
                                value.guardianid,
                                value.kinid,
                                value.admissionid,

                            ]).draw(false);
                        });
                        swal.close();
                    },
                    error: function(error) {
                        swal.close();
                        console.error('Error fetching data:', error);
                    }
                });
            }

            // Click event for "Get Active Students" button
            $('#getActiveStudents').on('click', function() {
                fetchData('active');
            });

            // Click event for "Get Inactive Students" button
            $('#getInactiveStudents').on('click', function() {
                fetchData('inactive');
            });
        });
    </script>

@endsection
