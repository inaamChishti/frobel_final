@extends('layouts.auth')

@section('title', 'Subjects')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/libs/datatables/datatables.css') }}">
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
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
        <p style="display: inline; margin: 0;">Attendance marked successfully!</p>
      </div>
    <div class="ui-bordered px-4 pt-4 mb-4" style="background-color:white; box-shadow: 1px 1px 4px 6px	#b0516a; ">
        <h4 class="font-weight-bold">
            <span class="text-muted font-weight-light"></span><b>Add Subject</b>
        </h4>
        <div class="form-row">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Add Subject</li>
                </ol>
            </nav>
        </div>
    </div>


    <!--Start Add New User -->
    <div class="modal fade" id="ajaxModal" tabindex="-1" aria-labelledby="ajaxModalLabel" aria-hidden="true">
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
                    <input type="hidden" name="subject_id" id="subject_id">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Name">
                        <span id="nameError" class="text-danger error_messages"></span>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="saveBtn"></button>
            </div>
        </div>
        </div>
    </div>

    <!-- DataTable within card -->
    <div class="card" style=" box-shadow: 1px 1px 4px 6px	#039dfe; ">
      <h6 class="card-header float-right">
        <button type="button" id="add_new_button" data-toggle="modal" data-target="#ajaxModal"
        style="background-image: linear-gradient(to right, #0082e0 , #02d5df); !important""
        class="btn btn-primary rounded-pill d-block">
            <span class="ion ion-md-add"></span>&nbsp;
             Add Subject
        </button>
      </h6>

      <div class="card-datatable table-responsive">
            <table id="example" class="datatables-demo table table-striped table-bordered">
                <thead>
                    <tr>
                        <th style="font-weight: bold; font-size:18px;">Name</th>

                        <th style="font-weight: bold; font-size:18px;">Actions</th>
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

        // Index role view
        var table = $('#example').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('subjects.index') }}",
            columns: [
                {data: 'name'},

                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });


    // Save User
    $('#saveBtn').click(function (e) {
        e.preventDefault();
        $(this).html('Saving...');

        $.ajax({
            data: $('#userForm').serialize(),
            url: "{{ route('subjects.store') }}",
            type: "POST",
            dataType: 'json',
            success: function (data) {
                $('#userForm').trigger("reset");
                $('#ajaxModal').modal('hide');

                showSuccessMessage("Subject saved successfully!", 2000);
                table.draw();
            },
            error: function (data) {
                if(data.responseJSON.errors){
                    $("#nameError").html(data.responseJSON.errors.name);
                }
                else if(data.responseJSON.message){
                    $("#nameError").html(data.responseJSON.message);
                }
                $('#saveBtn').html('Save Subject');
            }
        });
    });


    // Deleting User
        $('body').on('click', '.deleteButton', function () {

        var subject_id = $(this).data("id");

        if(confirm("Are You sure want to delete !")){
            $.ajax({
            type: "DELETE",
            url: "{{ route('subjects.destroy', '') }}" +'/'+ subject_id,
            success: function (data) {
                table.draw();
            },
            error: function (data) {
                if(data.responseJSON.message){
                    showSuccessMessage(data.responseJSON.message, 2000);
                }
                // console.log('Error:', data);
            }
            });
        }


    });



    // button clicks and error checks
    $('#add_new_button').click(function () {
        $('#saveBtn').html("Save Subject");
        $('#subject_id').val('');
        $('.error_messages').html('');
        $('#userForm').trigger("reset");
        $('#modalHeading').html("Create Subject");
        // $('#ajaxModel').modal('show');
    });
    $('body').on('click', '.editButton', function () {
        $('.error_messages').html('');
    });
    $('#saveBtn').click(function (e) {
        $('.error_messages').html('');
    });

    // Editing Subject
    $('body').on('click', '.editButton', function () {
        var subject_id = $(this).data('id');
        $.ajax({
            type: "GET",
            url: "{{ url('subjects', '') }}" + '/' +subject_id+ '/edit',
            success: function (data) {
                $('#modalHeading').html("Edit Subject");
                $('#saveBtn').html("Save Subject");
                $("#ajaxModal").modal("show");
                $('#subject_id').val(data.id);
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
