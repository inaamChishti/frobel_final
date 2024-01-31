@extends('layouts.auth')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/libs/datatables/datatables.css') }}">
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
@endsection

@section('content')
<div class="container-fluid flex-grow-1 container-p-y">

    <h4 class="font-weight-bold py-3 mb-4">
        <span class="text-muted font-weight-light">Student Tests /</span> Teacher Comment
    </h4>

    <!-- Start Add New User -->
    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalHeading">Edit Comment</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editForm" name="editForm">
                        @csrf
                        <input type="hidden" name="comment_id" id="comment_id">
                        <input type="hidden" name="row_id" id="row_id">

                        <div class="mb-3">
                            <label for="family_id" class="form-label">Family ID</label>
                            <input type="number" name="family_id" id="family_id" class="form-control"
                                placeholder="Family Id" readonly>
                            <span id="family_idError" class="text-danger error_messages"></span>
                        </div>

                        <div class="mb-3">
                            <label for="student" class="form-label">Students</label>
                            <input type="text" name="student" disabled id="student" class="form-control">
                            <span id="studentError" class="text-danger error_messages"></span>
                        </div>

                        <div class="mb-3">
                            <label for="comment" class="form-label">Comment</label>
                            <textarea name="comment" id="comment" class="form-control" cols="30" rows="3"></textarea>
                            <span id="commentError" class="text-danger error_messages"></span>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="updateBtn">Update</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Store Modal -->
    <div class="modal fade" id="ajaxModal" tabindex="-1" aria-labelledby="ajaxModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalHeading">Add Comment</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="userForm" name="userForm">
                        @csrf
                        <input type="hidden" name="comment_id" id="comment_id">

                        <div class="mb-3">
                            <label for="family_id" class="form-label">Family ID</label>
                            <input type="text" name="family_id" id="family_idd" class="form-control" placeholder="Family Id">
                            <span id="family_idError" class="text-danger error_messages"></span>
                        </div>

                        <div class="mb-3">
                            <label for="student" class="form-label">Students</label>
                            <select name="student" id="students" class="form-control">
                                <option selected disabled>Choose name</option>
                            </select>
                            <span id="studentError" class="text-danger error_messages"></span>
                        </div>


                        <div class="mb-3">
                            <label for="comment" class="form-label">Comment</label>
                            <textarea name="comment" id="comment" class="form-control" cols="30" rows="3"></textarea>
                            <span id="commentError" class="text-danger error_messages"></span>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveBtn">Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- DataTable within card -->
    <div class="card">
        <h6 class="card-header float-right">
            <button type="button" id="add_new_button" data-toggle="modal" data-target="#ajaxModal"
                class="btn btn-primary rounded-pill d-block"><span class="ion ion-md-add"></span>&nbsp; Add Comment
            </button>
        </h6>

        <div class="card-datatable table-responsive">
            <table id="example" class="datatables-demo table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Family ID</th>
                        <th>Student Name</th>
                        <th>Comment</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
                <tfoot>
                    <tr>
                        <th>Family ID</th>
                        <th>Student Name</th>
                        <th>Comment</th>
                        <th>Action</th>
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
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table = $('#example').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.comment.index') }}",
            columns: [
                { data: 'family_id' },
                { data: 'student_name' },
                { data: 'comment' },
                { data: 'action' },
            ]
        });

        // Edit button click event
        $('#example').on('click', '.editButton', function () {
            var commentId = $(this).data('id');
            $.ajax({
                url: "{{ url('admin/teacher/getcomments') }}",
                type: "GET",
                data: { comment_id: commentId },
                dataType: 'json',
                success: function (data) {
                    $('#modalHeading').html("Edit Comment");

                    // Append hidden row_id
                    $('#row_id').val(commentId);

                    // Replace select with text input for student
                    $('#student').replaceWith('<input type="text" name="student" disabled id="student" class="form-control" value="' + data.student_name + '">');

                    // Populate other fields
                    $('#comment_id').val(data.id);
                    $('#family_id').val(data.family_id);
                    $('#comment').val(data.comment);
                    $('#family_id').prop('readonly', true); // Disable family_id input on edit
                    $('#editModal').modal('show');
                },
                error: function (error) {
                    swal("Oops!", "Something went wrong while fetching comment details!", "error");
                }
            });
        });

        // Update User
        $('#updateBtn').click(function (e) {
    e.preventDefault();


    $.ajax({
        data: $('#editForm').serialize(),
        url: "{{ url('admin/teacher/commentstore') }}", // Update the URL
        type: "POST",
        dataType: 'json',
        success: function (data) {
            $('#editForm').trigger("reset");
            $('#editModal').modal('hide');
            swal("Good job!", "Comment updated successfully!", "success");
            table.draw();
        },
        error: function (data) {
            // Handle errors
            if (data.responseJSON.errors) {
                $("#family_idError").html(data.responseJSON.errors.family_id);
                $("#commentError").html(data.responseJSON.errors.comment);
                $("#studentError").html(data.responseJSON.errors.student);
            } else if (data.responseJSON.message) {
                $("#family_idError").html(data.responseJSON.message);
            }
            $('#updateBtn').html('Update');
        }
    });
});


        // Save User
        $('#saveBtn').click(function (e) {
            e.preventDefault();


            $.ajax({
                data: $('#userForm').serialize(),
                url: "{{ route('admin.comment.store') }}",
                type: "POST",
                dataType: 'json',
                success: function (data) {
                    $('#userForm').trigger("reset");
                    $('#ajaxModal').modal('hide');
                    swal("Good job!", "Comment saved successfully!", "success");
                    table.draw();
                },
                error: function (data) {
                    // Handle errors
                    if (data.responseJSON.errors) {
                        $("#family_idError").html(data.responseJSON.errors.family_id);
                        $("#commentError").html(data.responseJSON.errors.comment);
                        $("#studentError").html(data.responseJSON.errors.student);
                    } else if (data.responseJSON.message) {
                        $("#family_idError").html(data.responseJSON.message);
                    }
                    $('#saveBtn').html('Save');
                }
            });
        });

    });

    $(document).ready(function () {
    $('#family_idd').on('focusout', function () {
        var familyId = $(this).val();

        // Make an AJAX call to fetch students based on family_id
        $.ajax({
            url: "{{ url('admin/teacher/getStudents') }}",
            type: "GET",
            data: { family_id: familyId },
            dataType: 'json',
            success: function (data) {
                // Clear existing options
                $('#students').empty();

                // Append new options
                $.each(data, function (key, value) {
                    $('#students').append('<option value="' + value.studentname + ' ' + value.studentsur + '">' + value.studentname + ' ' + value.studentsur + '</option>');
                });
            },
            error: function (error) {
                console.error("Error fetching students:", error);
            }
        });
    });
});


</script>

@endsection
