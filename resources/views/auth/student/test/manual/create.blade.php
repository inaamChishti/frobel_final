@extends('layouts.auth')

@section('styles')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.0.1/min/dropzone.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.2.0/min/dropzone.min.js"></script>

@endsection

@section('content')
<div class="container-fluid flex-grow-1 container-p-y">

    <h4 class="font-weight-bold py-3 mb-4">
      <span class="text-muted font-weight-light">Student Tests /</span> Add Record
    </h4>


    <!-- alerts -->

    @if (Session::has('alert-success'))
    <div class="alert alert-success alert-dismissible">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>Success!</strong> {{ Session::get('alert-success') }}.
    </div>
    @endif


    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif


    <!-- DataTable within card -->
    <div class="card">
        <div class="card-header bg-primary text-white"><h5><b>Add Student Test</b></h5></div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.student.test.manual.store') }}">
                @csrf
                <div class="form-group">
                    <label for="">Family Id</label>
                    <input type="number" name="family_id" id="family_id" value="{{ old('family_id') }}" class="form-control" placeholder="1">
                </div>
                <div class="form-group">
                    <label for="">Student Name</label>
                    <select name="student_name" id="student_name" class="form-control">
                        <option value="" disabled selected>Choose Option</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Subjects</label>
                    <select name="subject" id="subject" class="form-control">
                        <option value="" disabled selected>Choose Option</option>
                        @if (count($subjects) > 0)
                            @foreach ($subjects as $subject)
                                <option value="{{ $subject->name }}">{{ $subject->name }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Book</label>
                    <input type="text" name="book" value="{{ old('book') }}" class="form-control" placeholder="Book name">
                </div>
                <div class="form-group">
                    <label for="">Test No</label>
                    <input type="text" name="test_no" value="{{ old('test_no') }}" class="form-control" placeholder="Test No">
                </div>
                <div class="form-group">
                    <label for="">Attempt</label>
                    <input type="text" name="attempt" value="{{ old('attempt') }}" class="form-control" placeholder="Attempt">
                </div>
                <div class="form-group">
                    <label for="">Date</label>
                    <input type="date" name="date" value="{{ old('date') }}" class="form-control">
                </div>
                <div class="form-group">
                    <label for="">Percentage</label>
                    <input type="text" name="percentage" value="{{ old('percentage') }}" class="form-control" placeholder="10">
                </div>
                <div class="form-group">
                    <label for="">Status</label>
                    <input type="text" name="status" value="{{ old('status') }}" class="form-control" placeholder="status">
                </div>
                <div class="form-group">
                    <label for="">Tutor</label>
                    <input type="text" name="tutor" value="{{ old('tutor') }}" class="form-control" placeholder="Tutor name">
                </div>

                <div class="form-group">
                    <label for="">Updated By</label>
                    <input type="text" name="updated_by" value="{{ old('updated_by') }}" class="form-control" placeholder="Updated By">
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-info">Submit</button>
                </div>
            </form>
        </div>
    </div>

  </div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#family_id').on('focusout', function() {
            var family_id = this.value;
            $('#student_name').empty('');
            $('#student_name').append('<option value="" disabled selected>Choose Option</option>');

            $.ajax({
                url: "{{ route('get-family-students', '') }}" + '/' + family_id,
                method: "Post",
                data: { family_id },
                success: function (data) {
                    $.each(data, function (i, item) {
                        $('#student_name').append($('<option>', {
                            value: item.name,
                            text : item.name
                        }));
                    });
                },
                error: function (error) {
                    swal("Erorr!", "Something went wrong, Please refresh the webpage and try again, if still problem persists contact with administrator", "error");
                }
            });
        });
    })
</script>
@endsection
