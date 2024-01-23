@extends('layouts.auth')

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
<div class="container-fluid flex-grow-1 container  -p-y">
    <div class="custom-message" id="successMessage" >
        <p style="display: inline; margin: 0;">notes marked successfully!</p>
      </div>
      <div class="custom-message-error" id="errorMessage" >
        <p style="display: inline; margin: 0;">Something went wrong, please contact customer care!</p>
      </div>
    <div class="ui-bordered px-4 pt-4 mb-4" style="background-color:white; box-shadow: 1px 1px 4px 6px	#b0516a;margin-top:20px">
        <h4 class="font-weight-bold">
            <span class="text-muted font-weight-light"></span><b>Diaries</b>
        </h4>
        <div class="form-row">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Diaries</li>
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

                <div class="mb-3">
                    <label for="refNo" class="form-label">Ref No</label>
                    <input type="number" name="refNo" id="refNo" class="form-control" placeholder="Ref No">
                    <span id="refNoError" class="text-danger error_messages"></span>
                </div>

                <div class="mb-3">
                    <label for="receivedBy" class="form-label">Received By</label>
                    <input type="text" name="receivedBy" id="receivedBy" class="form-control" placeholder="Received By">
                    <span id="receivedByError" class="text-danger error_messages"></span>
                </div>

                <div class="mb-3">
                    <label for="msgFor" class="form-label">Message For</label>
                    <input type="text" name="msgFor" id="msgFor" class="form-control" placeholder="Message For">
                    <span id="msgForError" class="text-danger error_messages"></span>
                </div>

                <div class="mb-3">
                    <label for="msg" class="form-label">Message</label>
                    <textarea name="msg" id="msg" class="form-control" cols="30" rows="3"></textarea>
                    <span id="msgError" class="text-danger error_messages"></span>
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
    <div class="card" style=" box-shadow: 1px 1px 4px 6px	#039dfe;">
      <h6 class="card-header float-right">
        <button type="button" id="add_new_button" data-toggle="modal"
        style="background-image: linear-gradient(to right, #0082e0 , #02d5df); !important""
        data-target="#ajaxModal"
            class="btn btn-primary rounded-pill d-block"
            ><span class="ion ion-md-add"></span>&nbsp; Add Note
        </button>
      </h6>

      <!-- Validation Error -->
      <span id="validationError" style="font-size: 16px" class="text-center text-danger error_messages"></span>

      <div class="card-datatable table-responsive">
            <table id="example" class="datatables-demo table table-striped table-bordered">
                <thead>
                    <tr>
                        <th style="font-weight: bold;font-size:18px;">Sr No</th>
                        <th style="font-weight: bold;font-size:18px;">Ref No</th>
                        <th style="font-weight: bold;font-size:18px;">Name</th>
                        <th style="font-weight: bold;font-size:18px;">Message</th>
                        <th style="font-weight: bold;font-size:18px;">Received By</th>
                        <th style="font-weight: bold;font-size:18px;">Message For</th>
                        <th style="font-weight: bold;font-size:18px;">Created At</th>
                        <th style="font-weight: bold;font-size:18px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
                <tfoot>
                    <tr>
                        <th style="font-weight: bold;font-size:18px;">Sr No</th>
                        <th style="font-weight: bold;font-size:18px;">Ref No</th>
                        <th style="font-weight: bold;font-size:18px;">Name</th>
                        <th style="font-weight: bold;font-size:18px;">Message</th>
                        <th style="font-weight: bold;font-size:18px;">Received By</th>
                        <th style="font-weight: bold;font-size:18px;">Message For</th>
                        <th style="font-weight: bold;font-size:18px;">Created At</th>
                        <th style="font-weight: bold;font-size:18px;">Actions</th>
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

        // Index role view
        var table = $('#example').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('user.note.index') }}",
            columns: [
                {data: 'id'},
                {data: 'ref_no'},
                {data: 'name'},
                {data: 'message'},
                {data: 'received_by'},
                {data: 'message_for'},
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
            url: "{{ route('user.note.store') }}",
            type: "POST",
            dataType: 'json',
            success: function (data) {
                $('#userForm').trigger("reset");
                $('#ajaxModal').modal('hide');
                showSuccessMessage('Note saved successfully!', 2000);
                table.draw();
            },
            error: function (data) {
                if(data.responseJSON.errors){
                    $("#refNoError").html(data.responseJSON.errors.refNo);
                    $("#msgError").html(data.responseJSON.errors.msg);
                    $("#msgForError").html(data.responseJSON.errors.msgFor);
                    $("#receivedByError").html(data.responseJSON.errors.receivedBy);
                }
                $('#saveBtn').html('Save Note');
            }
        });
    });


    // Deleting User
        $('body').on('click', '.deleteButton', function () {

        var note_id = $(this).data("id");

        if(confirm("Are you sure want to delete !")){
            $.ajax({
            type: "DELETE",
            url: "{{ url('users/note/delete') }}" +'/'+ note_id,
            success: function (data) {
                showErrorMessage('Note deleted successfully!', 2000);
                table.draw();
            },
            error: function (data) {
                if(data.responseJSON.message){
                    showErrorMessage(data.responseJSON.message,2000);
                }
                else if(data.responseJSON.error){
                    $("#validationError").html(data.responseJSON.error);
                }
            }
            });
        }


    });



    // button clicks and error checks
    $('#add_new_button').click(function () {
        $('#saveBtn').html("Save Note");
        $('.error_messages').html('');
        $('#userForm').trigger("reset");
        $('#modalHeading').html("Create Note");
        // $('#ajaxModel').modal('show');
    });

    $('#saveBtn').click(function (e) {
        $('.error_messages').html('');
    });


    });
</script>
@endsection
