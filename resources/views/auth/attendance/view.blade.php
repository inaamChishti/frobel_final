@extends('layouts.auth')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/libs/datatables/datatables.css') }}">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <link href="{{ asset('assets/libs/datetimepicker/css/classic.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/libs/datetimepicker/css/classic.date.css') }}" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.0/css/buttons.dataTables.min.css">

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/datetime/1.2.0/css/dataTables.dateTime.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.2/moment.min.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <style>
        .datepicker,
        .table-condensed {
            width: 300px;
        }

        input::placeholder {
            font: 17px sans-serif;
        }
    </style>
@endsection
@section('content')
    <!-- Content -->

    <div class="container-fluid flex-grow-1 container-p-y">

        <div class="ui-bordered px-4 pt-4 mb-4" style="background-color:white;box-shadow: 1px 1px 4px 6px	#b0516a;">
            <h4 class="font-weight-bold">
                <span class="text-muted font-weight-light"></span><b>View Attendance</b>
            </h4>
            <div class="form-row">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">View Attendance</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div style="display:flex; justify-content: space-between;">

            <!-- Family ID Filter -->
            <div class="ui-bordered px-4 pt-4 mb-4"
                style="background-color:white; box-shadow: 1px 1px 4px 6px	#039dfe;
                margin-right:20px;flex-basis: 10%;
                flex-grow: 1;
                flex-shrink: 1;">
                <div class="form-row">

                    <div class="col-md-12 offset-md- mb-4">
                        <label class="form-labels" style="font-weight: bold;font-size:18px;">Family Id:
                            <span id="star" style="font-size:12px;color:red;">(required)</span> </label>
                        <div class="d-flex">
                            <input type="number" id="family_id" placeholder="Enter Family Id" class="form-control me-3"
                                required>
                        </div>
                        <button type="button" name="btnShow" id="btnShow" class="btn btn-primary mt-4"
                            style="background-image: linear-gradient(to right, #0082e0 , #02d5df); !important"">Show</button>
                    </div>
                    {{-- <div class="col-md-6 offset-md-  mb-4">
                <label class="form-label">Family Id: <span id="star">*</span></label>
                <input type="number" id="family_id" id="tickets-list-created" class="form-control" required>
                <span id="family_id_error" class="text-danger"></span>
                <button type="button" name="btnShow" id="btnShow" class="btn btn-secondary btn-block mt-2">Show</button>
              </div> --}}

                </div>
            </div>
            <!-- / Filters -->


            <!-- Filters -->
            <div class="ui-bordered px-4 pt-4 mb-4"
                style="background-color: white;box-shadow: 1px 1px 4px 6px	#f07910; flex-basis: 50%;
        flex-grow: 1;
        flex-shrink: 1;">
                <div class="form-row">

                    <div class="col-md-4 mb-4">
                        <label class="form-label" style="font-weight: bold;font-size:18px;">Student Name:</label>
                        <select id="student_id" name="student_name" style="font: 17px sans-serif;"
                            class="custom-select student_name_filter">
                            <option selected disabled>Choose name</option>
                        </select>
                    </div>

                    <div class="col-md-4 mb-4">

                        <label class="form-label" style="font-weight: bold;font-size:18px;">From:</label>
                        {{-- <input type="date" name="from_date" id="from_date" class="form-control"> --}}
                        <input type="text" id="from_date" name="from_date" class="form-control " style=""
                            placeholder="dd/mm/yyyy">
                    </div>

                    <div class="col-md-4 mb-4">
                        <label class="form-label" style="font-weight: bold;font-size:18px;">To:</label>
                        {{-- <input type="date" name="to_date" id="to_date" class="form-control"> --}}
                        <input type="text" id="to_date" name="to_date" class="form-control " style=""
                            placeholder="dd/mm/yyyy">


                    </div>
                    <div class="col-md-4 mb-4">
                        <label class="form-label" style="font-weight: bold;font-size:18px;">Subject:</label>
                        <select id="subject_list" name="subject" style="font: 17px sans-serif;"
                            class="custom-select">
                            <option selected disabled>Select subject</option>
                            @foreach($subjects as $subject)
                            <option value="{{$subject->name}}">{{$subject->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4 mb-4">
                        <label class="form-label" style="font-weight: bold;font-size:18px;">Time Slot:</label>
                        <select id="time_slot" name="time_slot" style="font: 17px sans-serif;"
                            class="custom-select">


                                <option selected disabled >Choose time</option>
                                <option value="09:00 - 11:00am">09:00 - 11:00am</option>
                                <option value="11:00 - 01:00pm">11:00 - 01:00pm</option>
                                <option value="11:20 - 01:20pm">11:20 - 01:20pm</option>
                                <option value="11:30 - 01:30pm">11:30 - 01:30pm</option>
                                <option value="01:30 - 03:30pm">01:30 - 03:30pm</option>
                                <option value="02:00 - 04:00pm">02:00 - 04:00pm</option>
                                <option value="03:45 - 05:45pm">03:45 - 05:45pm</option>
                                <option value="04:15 - 06:15pm">04:15 - 06:15pm</option>
                                <option value="04:30 - 06:30pm">04:30 - 06:30pm</option>
                                <option value="06:45 - 08:45pm">06:45 - 08:45pm</option>
                            </select>
                        </select>
                    </div>
                    {{-- below code is for select current date when form load --}}


                    <div class="col-md-3 col-xl-2 mb-4" style="margin-top: 33px;">
                        <button type="button" class="btn btn-warning"
                            style="background-image: linear-gradient(to right,
#ffa40d ,#ffc801); !important"
                            id="clearButton"> <i class="fas fa-eraser"></i>
                            &nbsp; Clear</button>
                    </div>

                </div>
            </div>
        </div>

        <!-- / Filters -->

        <div class="card" style="box-shadow: 1px 1px 4px 6px	#b96edd;">
            <div class="card-datatable table-responsive">
                <table id="attendance_table" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th style="font-weight: bold;font-size:18px;">Family Id:</th>
                            <th style="font-weight: bold;font-size:18px;">Date:</th>
                            <th style="font-weight: bold;font-size:18px;">Student Name:</th>
                            <th style="font-weight: bold; font-size: 18px;">year:</th>
                            <th style="font-weight: bold;font-size:18px;">Teacher</th>
                            <th style="font-weight: bold;font-size:18px;">Subject</th>
                            <th style="font-weight: bold;font-size:18px;">Time Slot</th>
                            <th style="font-weight: bold;font-size:18px;">BK + CH</th>
                            <th style="font-weight: bold;font-size:18px;">Session</th>
                        </tr>
                    </thead>

                </table>
            </div>
        </div>

    </div>
    <!-- / Content -->
@endsection

@section('scripts')
    <script src="{{ asset('assets/libs/datetimepicker/js/picker.js') }}"></script>
    <script src="{{ asset('assets/libs/datetimepicker/js/picker.date.js') }}"></script>

    <script src="{{ asset('assets/libs/datatables/datatables.js') }}"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/datetime/1.2.0/js/dataTables.dateTime.js"></script>

    <!--Export table buttons-->
    <script type="text/javascript" src=" https://cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script type="text/javascript" src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.24/build/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.24/build/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.1/js/buttons.print.min.js"></script>
    <script src="{{ asset('assets/libs/datatables/datatables.js') }}"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>


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
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });



            var selectElement = document.getElementById("student_id");
            var fromDateElement = document.getElementById("from_date");
            var toDateElement = document.getElementById("to_date");
            var time_slotElement = document.getElementById("time_slot");
            var subject_listElement = document.getElementById("subject_list");

            // Function to handle changes in the elements
            function handleElementChange() {
            var selectedValue = selectElement.value;
            var fromDate = fromDateElement.value;
            var toDate = toDateElement.value;
            var timeSlot = time_slotElement.value; // Fetch the value of time slot
            var subject = subject_listElement.value; // Fetch the value of subject

            // Update the DataTable based on the selected values
            table.clear().draw();
            table.ajax.url("{{ route('admin.attendance.viewz') }}?selectedValue=" + selectedValue +
                "&fromDate=" + fromDate + "&toDate=" + toDate + "&timeSlot=" + timeSlot + "&subject=" + subject).load();

            // Perform other actions specific to the change event
            console.log("Selected Student ID: " + selectedValue);
            console.log("Selected From Date: " + fromDate);
            console.log("Selected To Date: " + toDate);
            console.log("Selected Time Slot: " + timeSlot);
            console.log("Selected Subject: " + subject);
        }


            // Add event listener for student_id select element
            selectElement.addEventListener("change", handleElementChange);

            // Add event listener for from_date input element
            fromDateElement.addEventListener("change", handleElementChange);

            // Add event listener for to_date input element
            toDateElement.addEventListener("change", handleElementChange);

            time_slotElement.addEventListener("change", handleElementChange);

            subject_listElement.addEventListener("change", handleElementChange);



            var table = $('#attendance_table').DataTable({

                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.attendance.view') }}",
                    type: "GET"
                },
                columns: [{
                        data: 'family_id'
                    },
                    {
                        data: 'date',
                        render: function (data, type, full, meta) {
                            return moment(data).format('DD-MMMM-YYYY');
                        },
                        orderable: true // Enable sorting for the date column
                    },
                    {
                        data: 'student_name'
                    },
                    {
                        data: 'year'
                    }, // Use the correct alias 'year' instead of 'student_year_in_school'
                    {
                        data: 'teacher_name'
                    },
                    {
                        data: 'subject'
                    },
                    {
                        data: 'time_slot'
                    },
                    {
                        data: 'bk_ch'
                    },
                    {
                        data: 'session_1'
                    },
                ],
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ],

            });






            // Filter student name value
            $(".student_name_filter").on('change', function() {

                table
                    .columns(2)
                    .search($(this).val())
                    .draw();
            });

            $('#clearButton').click(function() {
                $('#family_id').val('');
                $('#from_date').val('');
                $('#to_date').val('');
                $('#student_id').empty();
                $('#student_id').append('<option disabled selected>Choose name</option');

            });

            // Append student name in select box
            $("#btnShow").click(function(e) {
                e.preventDefault();
                var family_id = $('#family_id').val();
                if (family_id == '') {
                    $('#family_id_error').html('Family Id is required.');
                } else {
                    table
                        .columns(0)
                        .search(family_id)
                        .draw();

                    $('#student_id').empty();
                    $('#student_id').append('<option disabled selected>Choose name</option');
                    $('#family_id_error').html('');

                    $.ajax({
                        type: 'POST',
                        url: '{{ route('admin.search.family') }}',
                        data: {
                            family_id
                        },
                        success: function(data) {

                            $.each(data, function(i, item) {
                                console.log('abc');
                                console.log(item.admissionid);
                                $('#student_id').append($('<option>', {
                                    value: item.studentname,
                                    text: item.studentname
                                }));
                            });
                            // $('#student_id').on('change', function() {
                            //     var selectedStudentId = $(this).val();
                            //     alert('Selected student ID: ' + selectedStudentId);
                            // });

                        },
                        error: function(error) {
                            if (error.responseJSON.error) {
                                swal("Oops!", error.responseJSON.error, "error");
                            } else {
                                swal("Oops!",
                                    "Something went wrong, please contact customer care!",
                                    "error");
                            }
                            // console.log(data.responseJSON);

                        }
                    });
                }

            });


            $(document).ready(function() {

                $('#to_date, #from_date').on('change', function() {

                    var from_date = $('#from_date').val();
                    var to_date = $('#to_date').val();

                    if (from_date && to_date) {
                        table.ajax.reload();
                    }

                    return false;

                });

            });

            table.on('preXhr.dt', function(e, settings, data) {

                var from_date = $('#from_date').val();
                var to_date = $('#to_date').val()

                data.from_date = from_date;
                data.to_date = to_date;

            });

        });
    </script>
    <script>
        flatpickr("#to_date", {
            dateFormat: "Y-m-d",
            // Set the first day of the week to Monday (1 for Monday, 7 for Sunday)
            locale: {
                firstDayOfWeek: 1
            }
        });
    </script>

    <script>
        $(document).ready(function() {
            $("#to_date").datepicker({
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

    <script>
        flatpickr("#from_date", {
            dateFormat: "Y-m-d",
            // Set the first day of the week to Monday (1 for Monday, 7 for Sunday)
            locale: {
                firstDayOfWeek: 1
            }
        });
    </script>

    <script>
        $(document).ready(function() {
            $("#from_date").datepicker({
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
