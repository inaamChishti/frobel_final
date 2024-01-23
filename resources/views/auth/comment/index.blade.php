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
                    <input type="hidden" name="comment_id" id="role_id">

                    <div class="mb-3">
                        <label for="family_id_label" class="form-label">Family ID</label>
                        <input type="number" name="family_id" id="family_id" class="form-control" placeholder="Family Id">
                        <span id="family_idError" class="text-danger error_messages"></span>
                    </div>

                    <div class="mb-3" style="float: right">
                        <button id="show_family_button" class="btn btn-primary">Search</button>
                    </div><br>

                    <div class="mb-3">
                        <label for="student" class="form-label">Students</label>
                        <select name="student" id="student" class="form-control">
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
            <button type="button" class="btn btn-primary" id="saveBtn"></button>
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
                        <th>Commentor</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
                <tfoot>
                    <tr>
                        <th>Family ID</th>
                        <th>Student Name</th>
                        <th>Comment</th>
                        <th>Commentor</th>
                        <th>Created At</th>
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
            ajax: "{{ route('admin.comment.index') }}",
            columns: [
                {data: 'family_id'},
                {data: 'student_name'},
                {data: 'comment'},
                {data: 'commentor'},
                {data: 'created_at'},
            ]
        });


    // Save User
    $('#saveBtn').click(function (e) {
        e.preventDefault();
        $(this).html('Saving...');

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
                if(data.responseJSON.errors){
                    $("#family_idError").html(data.responseJSON.errors.family_id);
                    $("#commentError").html(data.responseJSON.errors.comment);
                    $("#studentError").html(data.responseJSON.errors.student);
                }
                else if(data.responseJSON.message){
                    $("#family_idError").html(data.responseJSON.message);
                }
                $('#saveBtn').html('Save');
            }
        });
    });



    // button clicks and error checks
    $('#add_new_button').click(function () {
        $('#saveBtn').html("Save");
        $('.error_messages').html('');
        $('#userForm').trigger("reset");
        $('#modalHeading').html("Create Comment");
    });

    $('#saveBtn').click(function (e) {
        $('.error_messages').html('');
    });


     // Append student name in select box
     $("#show_family_button").click(function(e){
        e.preventDefault();
        var family_id = $('#family_id').val();
        if(family_id == ''){
            $('#family_idError').html('Family Id is required');
        }
        else
        {
            $('.error_messages').html('');
            $("#show_family_button").attr("disabled", true);
            $('#family_idError').html('');
            $('#student')
                .empty()
                .append('<option selected="selected" disabled>Choose name</option>');

            $.ajax({
                type:'POST',
                url:'{{ route('admin.search.family') }}',
                data:{family_id},
                success:function(data){
                    console.log(data)
                    $("#show_family_button").attr("disabled", false);
                    $.each(data, function (i, item) {
                        $('#student').append($('<option>', {
                            value: item.name,
                            text : item.name
                        }));
                    });

                },
                error: function(error){
                    $("#show_family_button").attr("disabled", false);
                    if(error.responseJSON.error){
                        swal("Oops!", error.responseJSON.error, "error");

                        $('#student')
                        .empty()
                        .append('<option selected="selected" disabled>Choose name</option>');
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


});
</script>
@endsection
