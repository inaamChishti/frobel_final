@extends('layouts.auth')

@section('styles')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.0.1/min/dropzone.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.2.0/min/dropzone.min.js"></script>

@endsection

@section('content')
<div class="container-fluid flex-grow-1 container-p-y">

    <h4 class="font-weight-bold py-3 mb-4">
      <span class="text-muted font-weight-light">Student Tests /</span> Add Records
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
        <h5 class="card-header float-right">Upload sheet</h5>


     <div class="container-fluid mt-3">
        <form action="{{ route('admin.student-test.import') }}" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="mb-3">
              <label for="file" class="form-label">Choose Excel</label>
              <input type="file" name="file" class="form-control">
              <small class="text-danger">Only these format will be accepted. (xls, csv, xlsx)</small> <br>
              <button type="submit" class="btn btn-primary mt-2">Submit</button>
            </div>
        </form>

        <div>
            <form method="post" action="{{ route('admin.download.sample.sheet') }}">
                @csrf
                <button class="btn btn-info mb-2" style="float: right">Download Template Sheet</button>
            </form>
        </div>

     </div>
    </div>

  </div>
@endsection

@section('scripts')
@endsection
