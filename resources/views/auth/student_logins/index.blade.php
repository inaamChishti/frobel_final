@extends('layouts.auth')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/libs/datatables/datatables.css') }}">
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0/css/bootstrap-select.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0/dist/js/bootstrap-select.min.js"></script>
<style>
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
</style>
@endsection

@section('content')
<div class="container-fluid flex-grow-1 container-p-y">
    <div class="custom-message" id="successMessage" >
        <p style="display: inline; margin: 0;">User added successfully!</p>
      </div>
    <div class="ui-bordered px-4 pt-4 mb-4" style="background-color:white;box-shadow: 1px 1px 4px 6px	#b0516a;">
        <h4 class="font-weight-bold">
            <span class="text-muted font-weight-light"></span><b>Student Logins</b>
        </h4>
        <div class="form-row">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Student Logins</li>
                </ol>
            </nav>
        </div>
    </div>


    <!--Start Add New User -->
    <div class="modal fade" id="ajaxModal" tabindex="-1" aria-labelledby="ajaxModalLabel" aria-hidden="true" >
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="modalHeading"></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </div>
            <div class="modal-body">
                <form id="userForm" name="userForm">
                    @csrf
                    <input type="hidden" name="user_id" id="user_id">

                    {{-- <div class="mb-3">
                        <label for="name" class="form-label">Name <span id="star">*</span></label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Name">
                        <span id="nameError" class="text-danger error_messages"></span>
                    </div> --}}

                    <div class="mb-3">
                        <label for="username" class="form-label">Username <span id="star">*</span></label>
                        <input type="text" readonly name="username" id="username" class="form-control"  placeholder="Username">
                        <span id="usernameError" class="text-danger error_messages"></span>
                    </div>

                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Email address <span id="star">*</span></label>
                        <input type="email" name="email" id="email" class="form-control" placeholder="Email" id="exampleInputEmail1" aria-describedby="emailHelp">
                        <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                        <span id="emailError" class="text-danger error_messages"></span>
                    </div>



                    <div class="mb-3">
                        <label for="exampleInputPassword" class="form-label">Password <span id="star"></span> </label>
                        <input type="text" name="password" id="password" class="form-control" placeholder="Password" id="exampleInputpassword" aria-describedby="passwordHelp">
                        <span id="customPasswordLabel"></span><span id="customPassword" class="text-danger error_messages"></span>
                        <span id="passwordError" class="text-danger error_messages"></span>
                    </div>

                    {{-- <div class="mb-3">
                        <label for="role" class="form-label">Role <span style="opacity: 0.5">(optional)</span></label>
                        <select name="role[]" id="role" class="selectpicker form-control" multiple data-live-search="true">
                            <option disabled>Select option</option>
                            {{-- @foreach ($roles as $role)
                            <option value="{{ $role->id }}" @if(old('role') == $role->id) selected @endif >{{ $role->name }}</option>
                            @endforeach --}}
                        {{-- </select>
                        <span id="roleError" class="text-danger error_messages"></span>
                    </div>  --}}

                    <div class="mb-3">
                        <label for="role" class="form-label">Role <span style="opacity: 0.5">(optional)</span></label>
                        <select name="role" id="" class="form-control">
                            <option selected value="student">student</option>

                            {{-- @foreach ($roles as $role)
                            <option value="{{ $role->name }}" @if(old('role') == $role->name) selected @endif >{{ $role->name }}</option>
                            @endforeach --}}
                        </select>
                        <span id="roleError" class="text-danger error_messages"></span>
                    </div>


                </form>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary saveBtnn" id="saveBtn"></button>
            </div>
        </div>
        </div>
    </div>

    <!-- DataTable within card -->
    <div class="card" style="box-shadow: 1px 1px 4px 6px	#039dfe;">
      {{-- <h6 class="card-header float-right">
        <button type="button" id="add_new_button" class="rounded-pill d-block btn btn-primary"
        data-toggle="modal"
        style="background-image: linear-gradient(to right, #0082e0 , #02d5df); !important""
        data-target="#ajaxModal">
            <span class="ion ion-md-add"></span>&nbsp;  Add User
        </button>
      </h6> --}}

      <div class="card-datatable table-responsive">
        <table id="example" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>username</th>
                    <th>email</th>
                    <th>password</th>
                    <th>usertype</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
            {{-- <tfoot>
                <tr>
                    <th>Name</th>
                    <th>E-mail</th>
                    <th>Role</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </tfoot> --}}
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
     function showSuccessMessage(message, duration) {
            const successMessage = document.getElementById('successMessage');
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
    var table = $('#example').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('student.logins') }}",
        columns: [
            {data: 'username'},
            {data: 'email'},
            {data: 'password'},
            {data: 'usertype'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
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
            showSuccessMessage("User saved successfully!", 2000);
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

            $('#saveBtn').html('Save');
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
    $('#saveBtn').html("Save");
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
    $.get("{{ url('admin/users/') }}" + '/' + user_id + '/edit', function (data) {
        $('#modalHeading').html("Edit Credentials");
        $('#saveBtn').html("Save");
        $("#ajaxModal").modal("show");
        $('#user_id').val(data.user.id);
        $('#username').val(data.user.username);
        $('#email').val(data.user.email);
        $('#customPasswordLabel').html('Previous password is ');
        $('#password').val(data.user.custom_pw);
        console.log('ok');
        console.log(data.user);

        // Clear existing options in the dropdown
        $('#role').empty();

        // Append all roles to the dropdown
        $.each(data.roles, function (index, role) {
            // Select the option if usertype matches
            var selected = data.user.usertype == role.name ? 'selected' : '';
            $('#role').append('<option value="' + role.name + '" ' + selected + '>' + role.name + '</option>');
        });

        // No need to refresh for a normal dropdown
    });
});





    });
</script>
@endsection
