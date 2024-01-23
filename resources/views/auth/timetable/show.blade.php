@extends('layouts.auth')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/libs/datatables/datatables.css') }}">
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<style>
  #star {
    color: red;
  }
  input::placeholder {
    font: 17px sans-serif;
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

        .timetable-table {
    margin: auto;
    width: 70%;
    border-collapse: collapse;
}

.timetable-table th, .timetable-table td {
    border: 1px solid #B0C4DE;
    padding: 8px;
    text-align: left;
}

</style>
@endsection

@section('content')
 <!-- Content -->
 <div class="container-fluid flex-grow-1 container-p-y">
  <div class="ui-bordered px-4 pt-4 mb-4" style="background-color:white; box-shadow: 1px 1px 4px 6px	#b0516a;">
    <h4 class="font-weight-bold">
        <span class="text-muted font-weight-light"></span><b>View Time Table</b>
    </h4>
    <div class="form-row">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">View Time Table</li>
            </ol>
        </nav>
    </div>
</div>

<div style="display:flex; justify-content:space-between;">
     <!-- Family ID Filter -->
      <div class="ui-bordered px-4 pt-4 mb-4"  style="background-color:white;
       box-shadow: 1px 1px 4px 6px	#039dfe;
       margin-right:20px;
       flex-basis: 30%;
        flex-grow: 1;
        flex-shrink: 1;">
        <div class="form-row">
          <div class="col-md-12  mb-4">
            <label class="form-label"style="font-weight: bold;font-size:18px;">Family Id <span id="star" style="font-size:12px;">(required)</span></label>
            <input type="number" id="family_id" id="tickets-list-created" placeholder="Enter Your Family ID" class="form-control" required>
            <span id="family_id_error" class="text-danger"></span>
          </div>
          <button type="button" name="btnShow"
          id="btnShow"
          style="background-image: linear-gradient(to right, #0082e0 , #02d5df); !important""
          class="btn btn-primary mb-4
           show_family_button">Show</button>
        </div>
      </div>
      <!-- / Filters -->

      <div class="ui-bordered px-4 pt-4 mb-4"  style="background-color:white;
       box-shadow: 1px 1px 4px 6px	#f07910;
       flex-basis: 60%;
        flex-grow: 1;
        flex-shrink: 1;">
        <div class="form-row">

          <div class="col-md-3 mb-3">
            <label class="form-label" style="font-weight: bold;font-size:18px;">Student Name</label>
            <select id="student_id" name="student_name" class="custom-select student_name_filter">
              <option selected disabled>Choose name</option>
            </select>
          </div>

            <div class="col-md col-xl-2 mb-4">
                <button type="button" class="btn btn-warning"
                id="clearButton"
                style="width: 100px;
                background-image: linear-gradient(to right,
    #ffa40d , #ffc503); !important;margin-top: 30px;"
                >
                    <i class="fas fa-eraser"></i> &nbsp; Clear</button>
              </div>
        </div>
        {{--  --}}
        <div class="form-row">
            <div class="col-md-3 mb-3">
              <label class="form-label" style="font-weight: bold; font-size: 18px;">Teacher Name</label>
              <input type="text" id="teacher_name" name="teacher_name" class="form-control" placeholder="Enter teacher's name">
            </div>
            <div class="col-md-3 mb-3">
              <label class="form-label" style="font-weight: bold; font-size: 18px;">Day</label>
              <select id="day_select" name="day" class="custom-select">
                <option selected disabled>Choose day</option>
                <option value="MONDAY">Monday</option>
                <option value="TUESDAY">Tuesday</option>
                <option value="WEDNESDAY">Wednesday</option>
                <option value="THURSDAY">Thursday</option>
                <option value="FRIDAY">Friday</option>
                <option value="SATURDAY">Saturday</option>
                <option value="SUNDAY">Sunday</option>
              </select>
            </div>
            <div class="col-md-3 mb-3">
              <button onclick="sendData()" type="button" class="btn btn-primary" style="margin-top: 35px; height:33px;font-size:12px;">Search by Teacher</button>
            </div>
          </div>

          <div class="form-row">
            <div class="col-md-3 mb-3">
              <label class="form-label" style="font-weight: bold; font-size: 18px;">Subject Name</label>
              <input type="text" id="subject_name" oninput="this.value = this.value.toUpperCase();" name="subject_name" class="form-control" placeholder="Enter subject">
            </div>
            <div class="col-md-3 mb-3">
              <label class="form-label" style="font-weight: bold; font-size: 18px;">Day</label>
              <select id="day_select2" name="day" class="custom-select">
                <option selected disabled>Choose day</option>
                <option value="MONDAY">Monday</option>
                <option value="TUESDAY">Tuesday</option>
                <option value="WEDNESDAY">Wednesday</option>
                <option value="THURSDAY">Thursday</option>
                <option value="FRIDAY">Friday</option>
                <option value="SATURDAY">Saturday</option>
                <option value="SUNDAY">Sunday</option>
              </select>
            </div>
            <div class="col-md-3 mb-3">
              <button onclick="sendDataTwo()" type="button" class="btn btn-primary" style="margin-top: 35px; height:33px;font-size:12px;">Search by Subject</button>
            </div>
          </div>

     </div>
    </div>

    {{-- <div class="card" style=" box-shadow: 1px 1px 4px 6px	#b96edd;">
      <div class="card-datatable table-responsive">
        <table id="tickets-list" class="table table-striped table-bordered">
          <thead>
            <tr>
              <th style="font-weight: bold;font-size:18px;">Family Id</th>
              <th style="font-weight: bold;font-size:18px;">Student Name</th>
              <th style="font-weight: bold;font-size:18px;">Day</th>
              <th style="font-weight: bold;font-size:18px;">Subject</th>
              <th style="font-weight: bold;font-size:18px;">Time</th>
            </tr>
          </thead>
        </table>
      </div>
    </div> --}}
   <div class="search_by_teacher">

   </div>
    <table class="table2">
        <thead>
        </thead>
        <tbody id="scheduleTableBody"></tbody>
    </table>

  </div>
  <!-- / Content -->
@endsection

@section('scripts')
<script src="{{ asset('assets/libs/datatables/datatables.js') }}"></script>
<script>
    function sendData() {
        var teacherName = $('#teacher_name').val();
        var selectedDay = $('#day_select').val();
        var searchTeacher = $("#teacher_name").val();
        $.ajax({
            type: 'POST',
            url: '{{ url('getTeacherSchedule') }}',
            data: { teacherName: teacherName, selectedDay: selectedDay },
            success: function(response) {
                var timetableData = response;
                console.log(response);
                $(".search_by_teacher").empty();
                $('#scheduleTableBody').empty();
                var table = $("<table>").addClass("timetable-table");
                table.append("<tr><th>Day</th><th>Timeslot</th><th>Subject</th><th>Teacher</th></tr>");
                var uniqueRows = new Set();
                timetableData.forEach(entry => {
                    var timeslots = entry.timeslot.split(',');
                    var subjects = entry.subject.split(',');
                    var teachers = entry.teachers.split(',');
                    teachers.forEach((teacher, teacherIndex) => {
                        if (teacher.includes(searchTeacher)) {
                            var key = entry.day + timeslots[teacherIndex] + subjects[teacherIndex] + teacher;
                            if (!uniqueRows.has(key)) {
                                uniqueRows.add(key);
                                table.append(
                                    `<tr>
                                        <td>${entry.day}</td>
                                        <td>${timeslots[teacherIndex]}</td>
                                        <td>${subjects[teacherIndex]}</td>
                                        <td>${teacher}</td>
                                    </tr>`
                                );
                            }
                        }
                    });
                });
                $(".search_by_teacher").append(table);
            },
            error: function(error) {
                console.error('Error:', error);
            }
        });
    }
</script>
<script>
    function sendDataTwo() {
        var subjectName = $('#subject_name').val();
        var selectedDay = $('#day_select2').val();

        $.ajax({
            type: 'POST',
            url: '{{ url('getSubjectSchedule') }}',
            data: { subjectName: subjectName, selectedDay: selectedDay },
            success: function(response) {
    var timetableData = Object.values(response);
    console.log(response);

    // Check the type of timetableData
    console.log(typeof timetableData);

    $(".search_by_teacher").empty();
    $('#scheduleTableBody').empty();
    var table = $("<table>").addClass("timetable-table");
    table.append("<tr><th>Day</th><th>Timeslot</th><th>Subject</th><th>Teacher</th></tr>");
    var uniqueEntries = new Set();

    // Check if timetableData is an array before using forEach
    if (Array.isArray(timetableData)) {
        timetableData.forEach(entry => {
            var key = entry.day + entry.timeslot + entry.subject + entry.teacher;
            uniqueEntries.add(key);

            table.append(
                `<tr>
                    <td>${entry.day}</td>
                    <td>${entry.timeslot}</td>
                    <td>${entry.subject}</td>
                    <td>${entry.teacher}</td>
                </tr>`
            );
        });
    } else {
        console.error('timetableData is not an array:', timetableData);
    }

    $(".search_by_teacher").append(table);
},




            error: function(error) {
                console.error('Error:', error);
            }
        });
    }
</script>
<script>
    var table = $('#tickets-list').DataTable({
        processing: true,
            serverSide: true,
            ajax: "{{ route('admin.timetable.index') }}",
            columns: [
                {data: 'admissionid'},
                {data: 'studentname'},
                {data: 'day'},
                {data: 'subject'},
                {data: 'timeslot'},
            ]
    });
</script>

<script>
    $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

       $('#clearButton').click(function() {
            $('#student_id')
            .empty()
            .append('<option selected="selected" disabled>Choose name</option>');
            table.search('')
            .draw();
       });
        // Append student name in select box

         // Append student name in select box
         $("#btnShow").click(function(e){
            table.draw();
            e.preventDefault();
                var family_id = $('#family_id').val();

                table
                    .columns(0)
                    .search( family_id )
                    .draw();

                if(family_id == ''){
                    $('#family_id_error').html('Family Id is required.');
                }
                else
                {
                    $(".show_family_button").attr("disabled", true);
                    $('#family_id_error').html('');
                    $('#student_id').html("");
                    $('#student_id')
                        .empty()
                        .append('<option selected="selected" disabled>Choose name</option>');

                    $.ajax({
                        type:'POST',
                        url:'{{ route('admin.search.family') }}',
                        data:{family_id},
                        success:function(data){

                            $(".show_family_button").attr("disabled", false);
                            $.each(data, function (i, item) {
                                $('#student_id').append($('<option>', {
                                    value: item.studentname,
                                    text : item.studentname
                                }));
                            });

                        },
                        error: function(error){

                            $(".show_family_button").attr("disabled", false);
                            $('#student_id')
                                .empty()
                                .append('<option selected="selected" disabled>Choose name</option>');

                            if(error.responseJSON.error){
                                swal("Oops!", error.responseJSON.error, "error");
                            }
                            else
                            {
                                swal("Oops!", "Something went wrong, please contact customer care!", "error");
                            }
                            // console.log(data.responseJSON);

                        }
                    });
                }

	    });


    // Name filter here
    $(".student_name_filter").on('change', function() {
    var selectedFamilyId = $('#family_id').val();
    var selectedStudentId = $('#student_id').val();

    // Call the handleSuccesss function with the selected IDs
    handleSuccesss(selectedFamilyId, selectedStudentId);
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


function displayDataInTable(data) {
    const tableBody = $('#scheduleTableBody');

    $('.search_by_teacher').empty();

    // Clear existing rows
    tableBody.empty();

    // Days of the week
    const daysOfWeek = ['MONDAY', 'TUESDAY', 'WEDNESDAY', 'THURSDAY', 'FRIDAY', 'SATURDAY', 'SUNDAY'];

    // Add dynamic rows for each day in the tbody
    daysOfWeek.forEach(day => {
        const row = $('<tr></tr>');
        tableBody.append(row);

        // Add cells for ID and Day
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


    }
});
        }
    });
}





    })
</script>
@endsection
