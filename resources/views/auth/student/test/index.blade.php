@extends('layouts.auth')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/libs/datatables/datatables.css') }}">
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
@endsection

@section('content')
<div class="container-fluid flex-grow-1 container-p-y">

    <h4 class="font-weight-bold py-3 mb-4">
      <span class="text-muted font-weight-light">Student Tests / </span> View Records
    </h4>



    <!-- DataTable within card -->
    <div class="card">
      <div class="card-datatable table-responsive">

        <div class="row">
            <div class="col-md-6">
                <div class="form-group ml-2 mr-2">
                    <label>Family ID</label>
                    <input type="number" name="family_id" id="family_id" class="form-control">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group ml-2 mr-2">
                    <label>Student</label>
                    <select name="student_name" id="student_name" class="form-control">
                        <option value="" selected>Choose Option</option>


                        @if (count($students) > 0)

                            @foreach ($students as $student)
                            @php
                            $fullName = $student->studentname . ' ' . $student->studentname;
                            @endphp
                            <option style="color: black;" value="{{ $fullName }}">{{ $fullName }}</option>
                                @endforeach
                            @endif
                    </select>
                </div>
            </div>

        </div>

        <table id="example" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>Famiy ID</th>
                    <th>Student Name</th>
                    <th>Book</th>
                    <th>Test No</th>
                    <th>Attempt</th>
                    <th>Date</th>
                    <th>Percentage</th>
                    <th>Status</th>
                    <th>Subject</th>
                    <th>Tutor</th>
                    <th>Updated By</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
            <tfoot>
                <tr>
                    <th>Famiy ID</th>
                    <th>Student Name</th>
                    <th>Book</th>
                    <th>Test No</th>
                    <th>Attempt</th>
                    <th>Date</th>
                    <th>Percentage</th>
                    <th>Status</th>
                    <th>Subject</th>
                    <th>Tutor</th>
                    <th>Updated By</th>
                </tr>
            </tfoot>
        </table>
      </div>
    </div>

  </div>
@endsection

@section("scripts")
<script src="{{ asset('assets/libs/datatables/datatables.js') }}"></script>
{{-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
<script>
$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var table = $('#example').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.student.test.index') }}",
        columns: [
            {data: 'family_id'},
            {data: 'student_name'},
            {data: 'book'},
            {data: 'test_no'},
            {data: 'attempt'},
            {data: 'test_date'},
            {data: 'percentage'},
            {data: 'status'},
            {data: 'subject'},
            {data: 'tutor'},
            {data: 'tutor_updated_by'}
        ]
    });


// Save User
$('#saveBtn').click(function (e) {
    e.preventDefault();
    $(this).html('Saving...');

    $.ajax({
        data: $('#userForm').serialize(),
        url: "{{ route('admin.user.store') }}",
        type: "POST",
        dataType: 'json',
        success: function (data) {
            $('#userForm').trigger("reset");
            $('#ajaxModal').modal('hide');
            swal("Good job!", "User saved successfully!", "success");
            table.draw();

        },
        error: function (data) {

            if(data.responseJSON.errorMessage){
                $("#passwordError").html(data.responseJSON.errorMessage);
            }
            if(data.responseJSON.errors){
                $("#nameError").html(data.responseJSON.errors.name);
                $("#usernameError").html(data.responseJSON.errors.username);
                $("#emailError").html(data.responseJSON.errors.email);
                $("#passwordError").html(data.responseJSON.errors.password);
                $("#roleError").html(data.responseJSON.errors.role);
                $('#customPasswordLabel').html('');
            }
            if(data.responseJSON.email_error){
                $("#emailError").html(data.responseJSON.email_error);
            }
            if(data.responseJSON.username_error){
                $("#usernameError").html(data.responseJSON.username_error);
            }

            $('#saveBtn').html('Save User');
        }
    });
});

// Delete User
    $('body').on('click', '.deleteButton', function () {

    var user_id = $(this).data("id");
    if(confirm("Are You sure want to delete !")){
        $.ajax({
            type: "DELETE",
            url: "{{ url('admin/users/delete') }}"+'/'+ user_id,
            success: function (data) {
                table.draw();
            },
            error: function (data) {
                // console.log('Error:', data);
            }
        });
    }
});





//clicks

    $('#add_new_button').click(function () {
        $('#saveBtn').html("Save User");
        $('#user_id').val('');
        $('.error_messages').html('');
        $('#userForm').trigger("reset");
        $('#modalHeading').html("Create User");
        $('#role option').prop("selected", false).trigger('change');
    });
    $('#saveBtn').click(function (e) {
        $('.error_messages').html('');
    });

    $('body').on('click', '.editButton', function () {
        $('.error_messages').html('');
    });

    $('body').on('click', '.editButton', function () {
        var user_id = $(this).data('id');
        $.get("{{ url('admin/users/') }}" +'/' + user_id +'/edit', function (data) {
            $('#modalHeading').html("Edit User");
            $('#saveBtn').html("Save User");
            $("#ajaxModal").modal("show");
            $('#user_id').val(data.id);
            $('#name').val(data.name);
            $('#username').val(data.username);
            $('#email').val(data.email);
            $('#customPasswordLabel').html('Previous password is ');
            $('#customPassword').html(data.custom_password);
            console.log(data)

            var roles = data.roles;
                let optArr = [];
                for (var i = 0; i < roles.length; i++) {
                    optArr.push(roles[i].id);
                }
                $('.selectpicker').selectpicker('val', optArr);
                $('.selectpicker').selectpicker('refresh')

            });
    });


    $('#family_id').focusout(function() {
        var family_id = this.value;
        table
        .columns(0)
        .search( family_id )
        .draw();
    });

    $('#student_name').change(function() {
        var student_name = this.value;
        table
        .columns(1)
        .search( student_name )
        .draw();
    });


    $('#family_id').on('focusout', function() {
            var family_id = this.value;

            if (family_id) {

                $('#student_name').empty('');
                $('#student_name').append('<option value="" selected>Choose Option</option>');

                $.ajax({
                    url: "{{ route('get-family-students', '') }}" + '/' + family_id,
                    method: "Post",
                    data: { family_id },
                    success: function (data) {
                        $.each(data, function (i, item) {
                            $('#student_name').append($('<option>', {
                                value: item.studentname,
                                text : item.studentname
                            }));
                        });
                    },
                    error: function (error) {
                        swal("Erorr!", "Something went wrong, Please refresh the webpage and try again, if still problem persists contact with administrator", "error");
                    }
                });

            }

        });


    });
</script>
@endsection
