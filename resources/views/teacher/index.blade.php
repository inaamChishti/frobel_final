@extends('layouts.auth')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/libs/datatables/datatables.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">

    <style>
        /* Custom styling for DataTable */
        #teacherTable_wrapper {
            padding: 20px;
        }

        #teacherTable th, #teacherTable td {
            text-align: center;
        }

        #teacherTable tbody tr:hover {
            background-color: #f5f5f5;
            cursor: pointer;
        }

        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }

        .btn-danger:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }
        #teacherTable_wrapper {
    padding: 106px;
}
    </style>
@endsection

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">

                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade" tabindex="-1" role="dialog" id="editModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Teacher Information</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Display the ID and Teacher Name in the modal -->
                    <label for="newTeacherName">Old Name:</label>
                    <input type="text" id="teacherName"  class="form-control" readonly>

                    <!-- Form for editing -->
                    <form id="editForm" action="{{ url('/admin/teacher/roster/update') }}" method="post">
                        @csrf
                    <input type="hidden" id="teacherId" name="teacherId">
                    <div class="form-group">
                        <label class="col-form-label">Joining Date<span style="color:red;"> *</span></label>
                        <input autocomplete="no" class="form-control" name="joining_date" value="" required type="date" >
                    </div>
                        <div class="form-group">
                            <label for="newTeacherName">New Teacher Name:</label>
                            <input type="text" name="teacherName" class="form-control" id="newTeacherName" required>
                        </div>

                        <button type="button" class="btn btn-primary" onclick="submitEditForm()">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <section class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card card-primary">
                        <div class="card-header" style="background-color: #26b4ff91">
                            <h3 class="card-title" style="color: white;font-weight: bold;">Manage Staff Timetable</h3>
                        </div>
                        <div class="card-body">
                            @if (\Session::has('error'))
                            <div class="alert alert-danger">
                                <ul>
                                    <li>{!! \Session::get('error') !!}</li>
                                </ul>
                            </div>
                            @endif
                            @if (\Session::has('success'))
                            <div class="alert alert-success">
                                <ul>
                                    <li>{!! \Session::get('success') !!}</li>
                                </ul>
                            </div>
                            @endif

                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach

                            <form method="post" action="{{route('admin.teacher.roster.store')}}" id="quickForm" novalidate="novalidate">
                                @csrf
                                <div class="form-group">
                                    <label class="col-form-label">Teacher Name<span style="color:red;"> *</span></label>
                                    <input autocomplete="no" class="form-control" name="name" value="{{ old('name') }}" required type="text" placeholder="Enter Name">
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Joining Date<span style="color:red;"> *</span></label>
                                    <input autocomplete="no" class="form-control" name="joining_date" value="{{ old('joining_date') }}" required type="date" >
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Select Subject<span style="color:red;"> *</span></label>
                                    <select class="form-control" name="subject" required>
                                        <option value="">Select Subject</option>
                                        @foreach($subjects as $subject)
                                            <option value="{{ $subject->name }}">{{ $subject->name }}</option>
                                        @endforeach
                                    </select>
                                </div>



                                <div class="form-group">
                                    <button type="submit" class="btn btn-outline-primary btn-lg btn-block">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <table id="teacherTable" class="table table-striped table-bordered" style="width: 50%; margin-top: 20px;">
        <thead>
            <tr>
                <th style="background-color: #3498db; color: #fff;">Teacher Name</th>
                <th style="background-color: #3498db; color: #fff;">Subject</th>
                <th style="background-color: #3498db; color: #fff;">Joining Date</th>
                <th style="background-color: #3498db; color: #fff;">Action</th>
            </tr>
        </thead>
        <tbody>
            @if($rosters)
                @foreach($rosters as $roster)
                    <tr>
                        <td>
                            {{ $roster->teacher_name }}
                        </td>
                        <td>
                            {{ $roster->subject }}
                        </td>
                        <td>
                            {{ $roster->joining_date }}
                        </td>
                        <td>
                            <a href="#" onclick="editRoster('{{ $roster->teacher_name }}', '{{ $roster->id }}')" data-toggle="modal" data-target="#editModal">
                                <button type="button" class="btn btn-primary">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                            </a>

                            <a href="{{ url('/admin/teacher/roster/delete/' . $roster->id) }}" onclick="return confirm('Are you sure you want to delete this roster entry?')">
                                <button type="button" class="btn btn-danger">
                                    <i class="fas fa-trash-alt"></i> Delete
                                </button>
                            </a>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>


    </table>

</div>
<script>
   function editRoster(teacherName, id) {
    // Set the teacher name and id in the modal inputs
    document.getElementById('teacherName').value = teacherName;
    document.getElementById('teacherId').value = id;

    // Show the modal
    $('#editModal').modal('show');
}

    function submitEditForm() {
        document.getElementById('editForm').submit();
    }
</script>
@endsection

@section('scripts')
    <script src="{{ asset('assets/libs/datatables/datatables.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        $(document).ready(function () {
            // Initialize DataTable
            var teacherTable = $('#teacherTable').DataTable({
                "order": [], // Disable initial sorting
            });

            // Handle form submission
            $('#addTeacherForm').submit(function (e) {
                e.preventDefault();

                // Validation
                var teacherName = $('#teacherName').val();
                var subject = $('#subject').val();

                if (!teacherName || !subject) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Please fill in all fields!',
                    });
                    return;
                }

                // Add data to DataTable
                teacherTable.row.add([
                    teacherName,
                    subject,
                    '<button class="btn btn-danger" onclick="deleteRow(this)">Delete</button>'
                ]).draw(false);

                // Clear form fields
                $('#teacherName').val('');
                $('#subject').val();

                // Success notification
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Teacher added successfully!',
                });
            });
        });

        // Function to delete row
        function deleteRow(button) {
            var table = $('#teacherTable').DataTable();
            table.row($(button).parents('tr')).remove().draw();
        }
    </script>
@endsection
