@extends('layouts.auth')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/libs/datatables/datatables.css') }}">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <link href="{{ asset('assets/libs/datetimepicker/css/classic.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/libs/datetimepicker/css/classic.date.css') }}" rel="stylesheet" />
        <!-- Add jQuery library -->
 <!-- Add jQuery library -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<!-- Add jQuery UI library -->
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>



    <style>
        .picker--opened .picker__holder {
        max-height: 25em;
        width: 191%;}
    </style>

    <style>
        .form-labels,
            {
            margin-bottom: calc(0.438rem - 2px);
            font-weight: bold;
            font-size: 1.0rem;
            padding-bottom: 0;
        }

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
body {
  margin: 0;
  padding: 0;
  font-family: Arial, sans-serif;
}

.custom-message {
  position: fixed;
  top: 0;
  right: 0; /* Set to '0' for top-right corner */
  background-color: #4CAF50; /* Green background color */
  color: white; /* White text color */
  padding: 8px; /* Adjust padding for a smaller width */
  text-align: center;
  display: none;
  width: auto; /* Set to 'auto' to allow the content to determine the width */
  box-sizing: border-box;
  z-index: 999; /* Set a higher z-index value */
  max-width: 300px; /* Set a maximum width for the tag */
}
.custom-message-error{
    position: fixed;
  top: 0;
  right: 0; /* Set to '0' for top-right corner */
  background-color: rgb(137, 20, 20); /* Green background color */
  color: white; /* White text color */
  padding: 8px; /* Adjust padding for a smaller width */
  text-align: center;
  display: none;
  width: auto; /* Set to 'auto' to allow the content to determine the width */
  box-sizing: border-box;
  z-index: 999; /* Set a higher z-index value */
  max-width: 300px; /* Set a maximum width for the tag */
}



    </style>
@endsection

@section('content')
    <!-- Content -->
    <div class="container-fluid flex-grow-1 container-p-y">
        <div class="custom-message" id="successMessage" >
            <p style="display: inline; margin: 0;">Attendance marked successfully!</p>
          </div>
          <div class="custom-message-error" id="errorMessage" >
            <p style="display: inline; margin: 0;">Something went wrong, please contact customer care!</p>
          </div>

        <div class="ui-bordered px-4 pt-4 mb-4" style="background-color:white;  box-shadow: 1px 1px 4px 6px	#b0516a;">
            <h4 class="font-weight-bold">
                <span class="text-muted font-weight-light"></span><b>Attendance</b>
            </h4>
            <div class="form-row">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Attendance</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div style="display:flex;justify-content:space-between;">
            <!-- Family ID Filter -->
            <div class="ui-bordered px-4 pt-4 mb-4"
                style="background-color:white; box-shadow: 1px 1px 4px 6px	#039dfe;
                margin-right:20px;
                flex-basis: 10%;
  flex-grow: 1;
  flex-shrink: 1;
               ">

                <div class="form-row">
                    <div class="col-md-12 offset-md-3  mb-4" style="margin-left: -10px ">
                        <label class="form-labels" style="font-weight: bold;font-size:18px;">Family Id:<span id="star" style="font-size:12px;margin-right:5px;">(required)</span></label>
                        <input type="number" style="margin-top:25px;"
                        placeholder="Enter Family Id"
                         id="family_id" id="tickets-list-created" class="form-control" required>
                        <span id="family_id_error" class="text-danger"></span>
                        <button type="button" name="btnShow" id="btnShow"
                            class="btn btn-primary mt-4  show_family_button" style="background-image: linear-gradient(to right, #0082e0 , #02d5df); !important">Show</button>
                    </div>
                </div>
            </div>
            <!-- / Filters -->
            <!-- Filters -->
            <div class="ui-bordered px-4 pt-4 mb-4"
                style="background-color:white;
            box-shadow: 1px 1px 4px 6px	#f07910;
            flex-basis: 60%;
  flex-grow: 1;
  flex-shrink: 1;">
                <div class="form-row">

                    <div class="col-md mb-4">
                        <label class="form-labels"
                            style="font-weight: bold;
                        font-size:16px;margin-top:5px;
">Student Name:
                          <span id="star" style="font-size:12px;margin-right:5px;margin-left:5px;">(required)</span></label>
                        <select id="student_id" class="custom-select student_dropdown" style="font: 17px sans-serif;">
                            <option selected disabled >Choose name<span id="star" style="font-size:12px;margin-left:5px;">(required)</span></option>
                        </select>
                    </div>
                    <input type="hidden" name="student_unique" id="stu_idd">

                    <div class="col-md mb-4">
                        <label class="form-labels" style="font-weight: bold; font-size: 18px;">Date:
                            <span id="star" style="font-size: 12px; margin-left: 5px;">(required)</span>
                        </label>

                        {{-- <input type="text" id="date" class="form-control datepicker" style="width: 130px !important; margin-top: 25px;"
                            placeholder="dd/mm/yyyy"> --}}
                            <input type="text" id="date"  class="form-control" style="width: 130px !important; margin-top: 25px;"
                            placeholder="dd/mm/yyyy"  readonly>
                    </div>


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


                     <div class="col-md mb-4">
                        <label class="form-labels" style="font-weight: bold;font-size:18px;">Subject:<span id="star" style="font-size:12px;margin-left:5px;">(required)</span></label>
                        <select id="subject" style="margin-top:25px;font: 17px sans-serif;" class="custom-select" required onchange="alertSelectedValue()">
                            <option >Choose Option</option>
                            @if (count($subjects) > 0)
                            @foreach ($subjects as $subject)
                                <option value="{{ $subject->name }}">{{ $subject->name }}</option>
                            @endforeach
                        @endif
                        </select>
                    </div>
                    <div class="col-md mb-4">
                        <label class="form-labels" style="font-weight: bold;font-size:18px;">Teacher:
                           <span id="star" style="font-size:12px;margin-left:5px;">(required)</span></label>
                           <select id="teacher" style="margin-top: 25px;" class="form-control">
                            <!-- Add a default option -->
                            <option selected disabled>Choose teacher</option>
                        </select>
                    </div>



                    <div class="col-md mb-4">
                        <label class="form-labels" style="font-weight: bold;font-size:18px;">Time:<span id="star" style="font-size:12px;margin-left:5px;">(required)</span></label>
                        <select id="time" style="margin-top:25px;font: 17px sans-serif;" class="custom-select">
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
                    </div>

                    {{-- <div class="col-md col-xl-2 mb-4">
          <label class="form-label d-none d-md-block">&nbsp;</label>
          <button type="button" id="btnSave" class="btn btn-secondary btn-block">Show:</button>
        </div> --}}
                </div>

                <div class="form-row">
                    <div class=" mr-auto">
                        <button type="button" id="btnSave" class="btn btn-primary mb-4" style="background-image: linear-gradient(to right, #0082e0 , #02d5df); !important">Show</button>
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
                            <th style="font-weight: bold;font-size:17px;">Family Id:</th>
                            <th style="font-weight: bold;font-size:17px;">Student Name:</th>
                            <th style="font-weight: bold;font-size:17px;">Year:</th>
                            <th style="font-weight: bold;font-size:17px;">BK + CH:<span id="star" style="font-size:12px;margin-left:5px;">(required)</span></th>
                            <th style="font-weight: bold;font-size:17px;">Session:<span id="star" style="font-size:12px;margin-left:5px;">(required)</span></th>
                            <th style="width: 10%;font-weight: bold;font-size:17px;">H/W:<span id="star">*</span>
                            </th>
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
    <script>
        function alertSelectedValue() {
            var selectedValue = document.getElementById('subject').value;

            // Send an Ajax request to the Laravel route
            var url = '{{ route("getTeacherName", ":name") }}';
            url = url.replace(':name', selectedValue);

            // You can replace this with a more advanced Ajax request using libraries like Axios or jQuery
            // This is a basic example using the native XMLHttpRequest
            var xhr = new XMLHttpRequest();
            xhr.open('GET', url, true);

            xhr.onload = function () {
                if (xhr.status >= 200 && xhr.status < 300) {
                    // Parse the JSON response
                    var response = JSON.parse(xhr.responseText);

                    // Clear the existing options in the dropdown
                    $('#teacher').empty();

                    // Add a default option
                    $('#teacher').append('<option selected disabled>Choose teacher</option>');

                    // Add teacher names to the dropdown
                    $.each(response, function (index, teacher) {
                        $('#teacher').append('<option value="' + teacher + '">' + teacher + '</option>');
                    });

                } else {
                    // Request failed
                    console.error(xhr.responseText);
                }
            };

            xhr.send();
        }
    </script>


    <script>
        $(document).ready(function() {
            $('.datepicker').pickadate({
                selectMonths: true,
                selectYears: true,
            })
        })
    </script>

    <script>
         function showSuccessMessage(message, duration) {
            const successMessage = document.getElementById('successMessage');
            successMessage.innerHTML = `<p>${message}</p>`;
            successMessage.style.display = 'block';

            // Hide the message after the specified duration
            setTimeout(() => {
            successMessage.style.display = 'none';
            }, duration);
        }
        function showErrorMessage(message, duration) {
            const successMessage = document.getElementById('errorMessage');
            successMessage.innerHTML = `<p>${message}</p>`;
            successMessage.style.display = 'block';

            // Hide the message after the specified duration
            setTimeout(() => {
            successMessage.style.display = 'none';
            }, duration);
        }



        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Append student name in select box
            $("#btnShow").click(function(e) {
                e.preventDefault();
                var family_id = $('#family_id').val();
                if (family_id == '') {
                    $('#family_id_error').html('Family Id is required.');
                } else {
                    $(".show_family_button").attr("disabled", true);
                    $('#family_id_error').html('');
                    $('#stu_idd').empty();
                    $('#student_id')
                        .empty()
                        .append('<option selected="selected" disabled>Choose name</option>');

                    $.ajax({
                        type: 'POST',
                        url: '{{ route('admin.search.family') }}',
                        data: {
                            family_id
                        },
                        success: function(data) {
                            $(".show_family_button").attr("disabled", false);

                            $.each(data, function(i, item) {

                                $('#stu_idd').val(item.admissionid);

                                $('#student_id').append($('<option>', {
                                    value: item.studentname,
                                    text: item.studentname
                                }));
                            });

                        },
                        error: function(error) {
                            $(".show_family_button").attr("disabled", false);
                            if (error.responseJSON.error) {

                                showErrorMessage(error.responseJSON.error, 2000);

                                $('#student_id')
                                    .empty()
                                    .append(
                                        '<option selected="selected" disabled>Choose name</option>'
                                    );
                            } else {


                                    showErrorMessage('Something went wrong, please contact customer care!', 2000);
                            }
                            // console.log(data.responseJSON);

                        }
                    });
                }
            });



            // Make letter uppercase
            function capitalizeFirstLetter(string) {
                return string.charAt(0).toUpperCase() + string.slice(1);
            }
            // Load student subject
            $(".student_dropdown").change(function() {

                if ($("#attendance_table").length) {
                    $("#attendance_table_row").remove();
                    $("#mark_attendance").remove();
                }

                $('#subject')
                    .empty()
                    .append('<option selected="selected" disabled>Choose Option</option>');

                var student_name = this.value;
                $.ajax({
                    type: 'GET',
                    url: '{{ route('admin.search.subject') }}',
                    data: {
                        student_name
                    },
                    success: function(data) {
                        $.each(data, function(i, item) {
                            $('#subject').append($('<option>', {
                                value: item.name,
                                text: capitalizeFirstLetter(item.name)
                            }));
                        });

                    },
                    error: function(error) {
                        if (error.responseJSON.error) {

                            showErrorMessage(error.responseJSON.error, 2000);

                            $('#subject')
                                .empty()
                                .append('<option selected="selected" disabled>Choose</option>');
                        } else {


                            showErrorMessage('Something went wrong, please contact customer care!', 2000);

                        }
                        // console.log(data.responseJSON);

                    }
                });
            })

            // Show Time Tab;e
            $("#btnSave").click(function(e) {

                if ($("#attendance_table").length) {
                    $("#attendance_table_row").remove();
                    $("#mark_attendance").remove();
                }

                e.preventDefault();
                var student_name = $('#student_id').val();
                var date = $('#date').val();
                var teacher = $('#teacher').val();
                var subject = $('#subject').val();
                var time = $('#time').val();
                var stu_idd = $('#stu_idd').val();

                if (date == '' || student_name == null || subject == null || teacher == null || time ==
                    null) {
                    showErrorMessage('Please fill the required fields!', 2000);
                } else {

                    $.ajax({
                        type: 'GET',
                        url: '{{ route('admin.attendance.search') }}',
                        data: {
                            date,
                            student_name,
                            subject,
                            time,
                            teacher,
                            stu_idd
                        },
                        success: function(data) {
                            if (data && data.message === "Attendance entry already exists") {

                                showErrorMessage("Attendance already marked!", 2000);

                            } else {

                            var family_id = $('#family_id').val();
                            $('#attendance_table tr:last').after(
                                '<tr id="attendance_table_row"><td><input type="number" disabled id="family_id" class="form-control" value="' +
                                family_id +
                                '" > </td> <td><input type="text" disabled id="student_name" class="form-control" value="' +
                                data.timetable.studentname +
                                '" > </td>  <td><input type="text" id="years_in_school" disabled class="form-control" placeholder="Enter years" value="' +
                                data.years_in_school +
                                '"> </td>  <td><input type="text" id="bk_ch" class="form-control" placeholder="Enter BK + CH ">  <td><input type="text" id="session" class="form-control" placeholder="Enter Session"> </td>  <td><input type="checkbox" id="hw" class="form-control"> </td> </tr>'
                            );

                            $("<div class='col-md-5 offset-md-4'><button id='mark_attendance' class='btn btn-block btn-primary'>Mark Attendance</button></div>")
                                .insertAfter("#attendance_table");
                                }

                        },
                        error: function(error) {
                            if (error.responseJSON.error) {

                                showErrorMessage( error.responseJSON.error, 2000);


                            } else {

                                    showErrorMessage( 'Something went wrong, please contact customer care!', 2000);



                            }
                        }
                    });



                }
            });


            $('body').on('click', '#mark_attendance', function() {
                var student_name = $('#student_name').val();
                var family_id = $('#family_id').val();
                var teacher = $('#teacher').val();
                var years_in_school = $('#years_in_school').val();
                var subject = $('#subject').val();
                var time = $('#time').val();
                var session = $('#session').val();
                var date = $('#date').val();
                var bk_ch = $('#bk_ch').val();
                var status = $('#hw').val();
                // console.log(status == '');

                if (date == null || student_name == null || subject == null || teacher == null || time ==
                    null || session == '' ||  bk_ch == '' || years_in_school == null) {
                    showErrorMessage("Please fill the required fields!", 2000);
                }
                // else if (!$('#hw').is(":checked")) {
                //     swal("Oops!", "Please fill H/W checkbox!", "error");
                // }
                else {
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('admin.attendance.store') }}',
                        data: {
                            date,
                            student_name,
                            family_id,
                            subject,
                            time,
                            teacher,
                            session,
                            bk_ch,
                            status,
                            years_in_school
                        },
                        success: function (data, textStatus, xhr) {
                        if (xhr.status === 203) {
                            showErrorMessage("Attendance already marked!", 2000);
                        } else {
                            showSuccessMessage("Attendance marked successfully!", 2000); // 2000 milliseconds (2 seconds)
                            // Clear form fields and remove elements as needed
                            $('#date').val('');
                            $('#time').val(0);
                            $('#subject').val(0);
                            $('#student_id').val(0);
                            $('#teacher').val('');
                            $('#attendance_table_row').remove();
                            $('#mark_attendance').remove();
                        }
                    },
                        error: function(error) {

                                showErrorMessage("Something went wrong, please contact customer care!", 2000);
                        }

                    });
                }
            });

            //Delete Time table
            $('body').on('click', '.deleteButton', function() {

                var timetable_id = $(this).data("id");

                if (confirm("Are You sure want to delete !")) {
                    $.ajax({
                        type: "DELETE",
                        url: "{{ url('admin/timetables/delete') }}" + '/' + timetable_id,
                        success: function(data) {
                            table.draw();
                        },
                        error: function(data) {

                            console.log('Error:', data);
                        }
                    });
                }
            });



        })
    </script>
@endsection
