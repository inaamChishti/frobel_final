@extends('layouts.auth')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/libs/datatables/datatables.css') }}">
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
@endsection

@section('content')
<div class="container-fluid flex-grow-1 container-p-y">

    <div class="ui-bordered px-4 pt-4 mb-4" style="background-color:white;  box-shadow: 1px 1px 4px 6px	#b0516a; ">
        <h4 class="font-weight-bold">
            <span class="text-muted font-weight-light"></span><b>Add Roles</b>
        </h4>
        <div class="form-row">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Add Roles</li>
                </ol>
            </nav>
        </div>
    </div>


    <!--Start Add New User -->
    <div class="modal fade" id="ajaxModal" tabindex="-1" aria-labelledby="ajaxModalLabel" aria-hidden="true" >
        <div class="modal-dialog">
        <div class="modal-content">
            <form  method="POST" action="{{ route('admin.role.store') }}" id="userForm" name="userForm">
            <div class="modal-header">
            <h5 class="modal-title" id="modalHeading"></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </div>
            <div class="modal-body">

                    @csrf
                    <input type="hidden" name="role_id" id="role_id">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Name">
                        <input type="hidden" name="editable" id="editable" class="form-control">
                        <span id="nameError" class="text-danger error_messages"></span>
                    </div>

            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            {{-- <button type="button" class="btn btn-primary" id="saveBtn"></button> --}}
            <button type="button" class="btn btn-primary" id="saveBtnn">Save</button>
            </div>
        </form>
        </div>
        </div>
    </div>

    <!-- DataTable within card -->
    <div class="card" style=" box-shadow: 1px 1px 4px 6px	#039dfe; ">
      <h6 class="card-header float-right">
        <button type="button" id="add_new_button" data-toggle="modal" data-target="#ajaxModal"
        style="background-image: linear-gradient(to right, #0082e0 , #02d5df); !important""
        class="btn btn-primary rounded-pill d-block"><span class="ion ion-md-add">
                </span>&nbsp; Add Role
        </button>
      </h6>

      <div class="card-datatable table-responsive">
        @if($errors->any())
            <div class="alert alert-danger">
                {{ $errors->first('error') }}
            </div>
        @endif
        @if($errors->any())
            <div class="alert alert-success">
                {{ $errors->first('success') }}
            </div>
        @endif


            <table id="example" class="datatables-demo table table-striped table-bordered">
                <thead>
                    <tr>
                        <th style="font-weight:bold; font-size:18px">Name</th>
                        <th style="font-weight:bold; font-size:18px">Created At</th>
                        <th style="font-weight:bold; font-size:18px">Actions</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>

            </table>
      </div>
    </div>

  </div>
@endsection

@section('scripts')
<script src="{{ asset('assets/libs/datatables/datatables.js') }}"></script>
<script>
    document.getElementById('saveBtnn').addEventListener('click', function () {
        document.getElementById('userForm').submit();
    });
</script>
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Index role view
        var table = $('#example').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.role.index') }}",
            columns: [
                {data: 'name'},
                {data: 'created_at'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });


    // Save User
    $('#saveBtn').click(function (e) {
        e.preventDefault();
        $(this).html('Saving...');

        $.ajax({
            data: $('#userForm').serialize(),
            url: "{{ route('admin.role.store') }}",
            type: "POST",
            dataType: 'json',
            success: function (data) {
                $('#userForm').trigger("reset");
                $('#ajaxModal').modal('hide');
                swal("Good job!", "Role saved successfully!", "success");
                table.draw();
            },
            error: function (data) {
                if(data.responseJSON.errors){
                    $("#nameError").html(data.responseJSON.errors.name);
                }
                else if(data.responseJSON.message){
                    $("#nameError").html(data.responseJSON.message);
                }
                $('#saveBtn').html('Save Role');
            }
        });
    });


    // Deleting User
        $('body').on('click', '.deleteButton', function () {

        var role_id = $(this).data("id");

        if(confirm("Are You sure want to delete !")){
            $.ajax({
            type: "DELETE",
            url: "{{ url('admin/roles/delete') }}" +'/'+ role_id,
            success: function (data) {
                table.draw();
            },
            error: function (data) {
                if(data.responseJSON.message){
                    swal("Danger!", data.responseJSON.message , "error");
                }
                // console.log('Error:', data);
            }
            });
        }


    });



    // button clicks and error checks
    $('#add_new_button').click(function () {
        $('#saveBtn').html("Save Role");
        $('#role_id').val('');
        $('.error_messages').html('');
        $('#userForm').trigger("reset");
        $('#modalHeading').html("Create Role");
        // $('#ajaxModel').modal('show');
    });
    $('body').on('click', '.editButton', function () {
        $('.error_messages').html('');
    });
    $('#saveBtn').click(function (e) {
        $('.error_messages').html('');
    });

    // Editing role
    $('body').on('click', '.editButton', function () {
        var role_id = $(this).data('id');
        $.ajax({
            type: "GET",
            url: "{{ url('admin/roles') }}" + '/' +role_id+ '/edit',
            success: function (data) {
                $('#userForm').attr('action', "{{ route('admin.role.update') }}");
                $('#modalHeading').html("Edit Role");
                $('#saveBtn').html("Save Role");
                $("#ajaxModal").modal("show");
                $('#id').val(data.id);
                $('#editable').val(data.id);
                $('#name').val(data.name);
            //  $('#role').val(data.role);
            },
            error: function (data) {
            }
        });
    });


    });
</script>
@endsection
