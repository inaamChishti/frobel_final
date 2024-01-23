@extends('layouts.auth')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/libs/datatables/datatables.css') }}">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <style>
        #star {
            color: red;
        }

        .table2 {
            border-collapse: collapse;
            width: 100%;
        }

        .table2,
        .table2 th,
        .table2 td {
            border: 1px solid black;
        }

        .th1,
        .td1 {
            padding: 10px;
            text-align: left;
            font-weight: bold;
        }

        .time-column {
            white-space: nowrap;
        }

        .table2 tr:hover {
            background-color: #f5f5f5;
        }

        .reset-button {
            padding: 10px;
            margin-top: 10px;
            background-color: #3498db;
            color: #fff;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }

        .reset-button:hover {
            background-color: #2980b9;
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

    <head>
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>
    <!-- Content -->
    <div class="container-fluid flex-grow-1 container-p-y">
        <div class="custom-message" id="successMessage" >
            <p style="display: inline; margin: 0;">time table succcessfully added</p>
          </div>
          <div class="custom-message-error" id="errorMessage" >
            <p style="display: inline; margin: 0;">Something went wrong, please contact customer care!</p>
          </div>

        <div class="ui-bordered px-4 pt-4 mb-4" style="background-color:white;  box-shadow: 1px 1px 4px 6px	#b0516a;">
            <h4 class="font-weight-bold">
                <span class="text-muted font-weight-light"></span><b>Manage Time Table</b>
            </h4>
            <div class="form-row">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Manage Time Table</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div style="display:flex;justify-content:space-between;">
            <!-- Family ID Filter -->
            <div class="ui-bordered px-4 pt-4 mb-4"style=" box-shadow: 1px 1px 4px 6px	#039dfe;
                                                     background-color: white;
                                                     margin-right:20px;
                                                     flex-basis: 20%;
                                                        flex-grow: 1;
                                                        flex-shrink: 1;
                                                     ">
                <div class="form-row">

                    {{-- <form id="family_form"> --}}
                    <div class="col-md-6 offset-md-3  mb-4" style="margin-left:0 !important">
                        <label class="form-label"style="font-weight: bold; font-size:18px;">Family Id <span id="star"
                                style="font-size:12px;">(required)</span></label>
                        <input type="number" placeholder="Enter Your Family ID" style="width:200px !important;"
                            id="family_id" id="tickets-list-created" class="form-control" required>
                        <span id="family_id_error" class="text-danger"></span>
                        <button type="button" name="btnShow" id="btnShow"
                            style="background-image: linear-gradient(to right, #0082e0 , #02d5df); !important"
                            class="btn btn-secondary btn-block mt-2 show_family_button">
                            Show</button>
                    </div>
                    {{-- </form> --}}
                </div>
            </div>
            <!-- / Filters -->


            <!-- Filters -->
            <div class="ui-bordered px-4 pt-4 mb-3" style="box-shadow: 1px 1px 4px 6px #f07910;
            background-color: white;
            flex-basis: 60%;
            flex-grow: 1;
            flex-shrink: 1;">
                <div class="form-row align-items-center" >
                    <div class="col-md mb-2">
                        <label class="form-label" style="font-weight: bold; font-size:18px;">Student Name <span
                                id="star" style="font-size:12px;">(required)</span></label>
                        <select id="student_id" class="custom-select student_dropdown">
                            <option selected disabled>Choose name</option>
                        </select>
                    </div>
                    <div class="col-md mb-2">
                        <label class="form-label"style="font-weight: bold; font-size:18px;">Day <span id="star"
                                style="font-size:12px;">(required)</span></label>
                        <select id="day" class="custom-select" required style="margin-top:25px;">
                            <option selected disabled>Choose day</option>
                            <option value="monday">Monday</option>
                            <option value="tuesday">Tuesday</option>
                            <option value="wednesday">Wednesday</option>
                            <option value="thursday">Thursday</option>
                            <option value="friday">Friday</option>
                            <option value="saturday ">Saturday </option>
                            <option value="sunday">Sunday</option>
                        </select>
                    </div>
                    <div class="col-md mb-2">
                        <label class="form-label"style="font-weight: bold; font-size:18px;">Subject <span id="star"
                                style="font-size:12px;">(required)</span></label>
                        <select id="subject" class="custom-select" required style="margin-top:25px;" onchange="alertSelectedValue()">
                            <option selected disabled>Choose subject</option>
                            @if (count($subjects) > 0)
                                @foreach ($subjects as $subject)
                                    <option value="{{ $subject->name }}">{{ $subject->name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col-md mb-2" style="zoom: 0.9;">
                        <label class="form-label" style="font-weight: bold; font-size: 14px;">Teacher Name <span id="star"
                                style="font-size: 12px;">(required)</span></label>
                        <select id="teacher_name" class="custom-select dropup teacher_name" required style="margin-top: 15px;">
                            <option selected disabled>Choose teacher</option>
                            <!-- Your options here -->
                        </select>
                    </div>


                    <div class="col-md mb-2">
                        <label class="form-label" style="font-weight: bold; font-size:18px;">Time <span id="star"
                                style="font-size:12px;">(required)</span></label>
                        <select id="time" class="custom-select" style="margin-top:25px;">
                            <option selected disabled>Choose time</option>
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
                </div>

                <div class="form-row" >
                    <div class="col-md text-center">
                        <button type="button" id="btnSave"
                            style="background-image: linear-gradient(to right, #0082e0 , #02d5df); !important""
                            class="btn btn-secondary col-md-6 mb-4">Add Record</button>
                    </div>
                </div>

            </div>
        </div>
        <div class="row mt-3 btnz" style="display: none;">
            <div class="col-md-2 text-center pl-2 pr-1">
                <button type="button" class="btn btn-warning" onclick="downloadPrint()">Download/Print</button>
            </div>
            <div class="col-md-2 text-center px-1">
                <button type="button" class="btn btn-warning" onclick="resetTimetable()">Reset Timetable</button>
            </div>
        </div>


        <table class="table2">
            <thead>
            </thead>
            <tbody id="scheduleTableBody"></tbody>
        </table>

    </div>
@endsection

@section('scripts')
<script>
function downloadPrint() {
    // Function to generate a random reference number
    function generateRandomRef() {
        return Math.floor(Math.random() * 1000000) + 1; // Change the range as needed
    }

    // Selecting table headers
    var tableHeaders = document.querySelectorAll('.table2 thead th');

    // Selecting table data
    var tableData = document.querySelectorAll('.table2 tbody tr');

    // Generating a random reference number
    var randomRef = generateRandomRef();

    // Creating an HTML table
    var htmlTable = "<table border='1'><thead><tr>";

    // Adding table headers to the HTML table, excluding the last header
    tableHeaders.forEach(function(header, index, headers) {
        if (index < headers.length - 1) {
            htmlTable += "<th>" + header.innerText + "</th>";
        }
    });

    htmlTable += "</tr></thead><tbody>";

    // Adding table data to the HTML table, excluding the last column
    tableData.forEach(function(row) {
        htmlTable += "<tr>";
        row.querySelectorAll('td').forEach(function(cell, index, cells) {
            // Exclude the last cell in each row
            if (index < cells.length - 1) {
                htmlTable += "<td>" + cell.innerText + "</td>";
            }
        });
        htmlTable += "</tr>";
    });

    htmlTable += "</tbody></table>";

    // Retrieve the value of the .student_dropdown element
    var fullName = document.querySelector('.student_dropdown').value;

    // Opening a new window and writing the HTML message with the logo to it
    var printWindow = window.open('', '_blank');
    var message =
        "<img src='" + "{{ asset('img/timeTableLogo.png') }}" + "' alt='Logo' style='max-width: 40%; max-height: 40%;zoom:0.6;'><br>" +
        "Reference Number: " + randomRef + "<br>" +
        "Student Name: " + fullName + "<br>" +
        "Below is your tuition timetable for the upcoming sessions:<br>" +
        htmlTable + "<br><br>" +
        "If you have any questions or concerns, feel free to reach out. Looking forward to a productive and successful learning experience!<br>" +
        "<div style='text-align: right;'>Kind Regards</div>"+
        "<div style='text-align: right;'>Timetable Team</div>";

    // Writing the message to the new window
    printWindow.document.write(message);
    printWindow.document.close();

    // Printing the new window
    printWindow.print();
    var cancelButton = printWindow.document.querySelector('.cancel-button');
    if (cancelButton) {
        cancelButton.addEventListener('click', function () {
            // Closing the new window/tab
            printWindow.close();
        });
    }

}


</script>

    <script src="{{ asset('assets/libs/datatables/datatables.js') }}"></script>

    {{-- <script>
    var table = $('#tickets-list').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.timetable.index') }}",
        columns: [
            {data: 'studentname'},
            {data: 'day'},
            {data: 'subject_teacher', name: 'subject_teacher'},
            {data: 'timeslot'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
</script> --}}

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

            $('#teacher_name').empty();

            // Add a default option
            $('#teacher_name').append('<option selected disabled>Choose teacher</option>');

            // Add teacher names to the dropdown
            $.each(response, function(index, teacher) {
                $('#teacher_name').append('<option value="' + teacher + '">' + teacher + '</option>');
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
                            console.log(data)

                            $.each(data, function(i, value) {
                                $('#student_id').append($('<option>', {
                                    value: value.studentname,
                                    text: value.studentname
                                }));
                            });

                        },
                        error: function(error) {
                            $(".show_family_button").attr("disabled", false);
                            $('#student_id')
                                .empty()
                                .append(
                                    '<option selected="selected" disabled>Choose name</option>'
                                );

                            if (error.responseJSON.error) {

                                showErrorMessage(error.responseJSON.error, 2000);
                            } else {


                                    showErrorMessage('Something went wrong, please contact customer care!', 2000);
                            }
                            // console.log(data.responseJSON);

                        }
                    });
                }

            });


            function handleSuccesss(family_id, student_name) {

                const data = {
                    _token: '{{ csrf_token() }}',
                    family_id: family_id,
                    student_name: student_name
                };

                fetch('/fetchIndividual', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify(data)
                    })
                    .then(response => response.json())
                    .then(responseData => {
                        console.log(responseData);
                        displayDataInTable(responseData);
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            }

            function redirectTimetable(id) {
            const resetUrl = '{{ url('resetTimetable', ['id' => '']) }}/' + id;

            $.ajax({
                url: resetUrl,
                type: 'GET',
                success: function(response) {
                    console.log(response);
                    // Check if family_id and student_name are available in the response
                    if (response.family_id && response.student_name) {

                        handleSuccesss(response.family_id, response.student_name);
                    }
                },
                error: function(error) {
                    console.error('Error:', error);
                }
            });
        }


            function displayDataInTable(data) {
                    const tableBody = $('#scheduleTableBody');

                    // Clear existing rows
                    tableBody.empty();

                    // Days of the week
                    const daysOfWeek = ['MONDAY', 'TUESDAY', 'WEDNESDAY', 'THURSDAY', 'FRIDAY', 'SATURDAY', 'SUNDAY'];

                    // Add dynamic rows for each day in the tbody
                    daysOfWeek.forEach(day => {
                        const row = $('<tr></tr>');
                        tableBody.append(row);

                        // Add cells for ID and Day
                        // const idCell = $('<td></td>');
                        // idCell.addClass('td1');
                        // idCell.text(''); // You may want to modify this based on your requirements
                        // row.append(idCell);

                        const dayCell = $('<td></td>');
                        dayCell.addClass('td1');
                        dayCell.text(day);
                        row.append(dayCell);

                        // Iterate through items for the current day
                        const dayData = data.filter(item => item.day.toUpperCase() === day);

                        if (dayData.length > 0) {

    dayData.forEach(item => {
    // Check if timeslot, subject, and teachers are not null or empty
    if (item.timeslot && item.subject && item.teachers) {
        // Find subjects, times, and teachers for the current day
        const subjects = item.subject.split(',');
        const timeslots = item.timeslot.split(',');
        const teachers = item.teachers.split(',');

        // Display subjects, teachers, and times in the same row
        for (let i = 0; i < subjects.length; i++) {
            const subjectCell = $('<td></td>');
            subjectCell.addClass('td1');

            // Check if teachers[i] is not null or empty before concatenating
            const teacherText = teachers[i] ? ` - ${teachers[i]}` : '';

            subjectCell.text(`${subjects[i]} - ${timeslots[i]} ${teacherText}`);
            row.append(subjectCell);
        }

        // Add reset button with the ID
        const resetButton = $('<button></button>');
        resetButton.addClass('reset-button');
        resetButton.text('Reset');
        resetButton.attr('fdprocessedid', item.ID);
        resetButton.on('click', () => redirectTimetable(item.ID));
        row.append($('<td></td>').append(resetButton));
    }
});


                        }
                    });
                }


            // Save Time Tab;e
            $("#btnSave").click(function(e) {
                e.preventDefault();
                var student_name = $('#student_id').val();

                var day = $('#day').val();
                var subject = $('#subject').val();
                var time = $('#time').val();
                var time = $('#time').val();
                var family_id = $('#family_id').val();
                var teacher_name = $('#teacher_name').val();

                if (day == null || student_name == null || subject == null || day == null || time == null ) {

                    showErrorMessage("Please fill the required fields!", 2000);
                } else {
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('admin.timetable.store') }}',
                        data: {
                            day,
                            student_name,
                            subject,
                            time,
                            family_id,
                            teacher_name
                        },
                        success: function(data) {
                            $(".btnz").show();
                            console.log('inam');
                            console.log(student_name);
                            handleSuccesss(family_id, student_name);

                            showSuccessMessage("Timetabel saved successfully!", 2000);
                            table.draw();

                            $('#day').val(0);
                            $('#time').val(0);
                            $('#subject').val(0);
                            $('#student_id').val(0);

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



            function resetTimetable() {
        // Get the student ID from #student_id and family ID from .family_id
        var studentId1 = $('#student_id').val();
        var studentId2 = $('#family_id').val();

        // Display the student IDs in an alert


        // Make the Ajax call
        $.ajax({
            url: "{{ url('resetWholeTimetable') }}",
            type: "GET",
            data: {
                studentId1: studentId1,
                studentId2: studentId2
            },
            dataType: "json",
            success: function (data) {
                if (data.success) {

                alert('Timetable reset successfully');
                handleSuccesss(studentId2, studentId1);

                }
            },
            error: function (error) {
                console.error(error);
            }
        });
    }
    </script>
@endsection
