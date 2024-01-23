@extends('layouts.auth')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/libs/datatables/datatables.css') }}">
@endsection

@section('content')
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<!-- Bootstrap JS -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<div class="container-fluid flex-grow-1 container-p-y">
   <h4 class="font-weight-bold py-3 mb-4" style="text-align:center">
    <span class="text-muted font-weight-light"></span> Search Student
  </h4>
   <div class="row">
      <div class="col-xl-12 mx-auto">
         @if ($errors->any())
         <div class="alert alert-danger">
            <ul>
               @foreach ($errors->all() as $error)
               <li>{{ $error }}</li>
               @endforeach
            </ul>
         </div>
         @endif


         <!-- Student alerts -->
         <x-flash-message></x-flash-message>

         <!-- Student Form -->
         <div class="row" >
            <div class="col-xl-12 mx-auto" >


               <div class="card border-top border-0 border-4 border-info" style="box-shadow: 1px 1px 4px 6px	#b0516a;">
                  {{-- <div class="card-body"> --}}
                     <div class="border p-4 rounded">
                        <div class="card-title d-flex align-items-center">
                           <div><i class="bx bxs-user me-1 font-22 text-info"></i>
                           </div>

                            {{-- <a href="{{ route('admin.admission.create') }}" class="btn btn-primary rounded-pill d-block"> <span class="ion ion-md-add"></span>&nbsp; Add Student</a> --}}
                        </div>
                        <hr>
                        {{--  --}}
                        <div class="d-flex justify-content-center">
                           <form method="GET" action="{{route('admin.admission.getadmissions')}}">
                               @csrf
                               <div class="form-inline">
                                   <div class="form-group">
                                       <select class="form-control" name="option" id="search-option" required>
                                           <option value="">Select an option</option>
                                           <option value="student_name">Student Name</option>
                                           <option value="parent_name">Parent Name</option>
                                           {{-- <option value="postCode">Postal Code</option> --}}
                                           <option value="phone">Phone</option>
                                           <option value="family_id">Family id</option>

                                       </select>
                                   </div>
                                   <div class="form-group">
                                       <input type="text" class="form-control" id="search-input" name="search" style="margin-left:20px;" required placeholder="Search...">
                                   </div>
                                   <button type="submit" class="btn btn-primary" style="margin-left:20px;">Submit</button>
                               </div>
                           </form>
                       </div>


                        {{--  --}}

               @if(@$students)

                        <table id="example" class="datatables-demo table table-striped table-bordered" style="margin-top:20px;">
                            <thead>
                              <tr>
                                <th style="font-size:17px;font-weight:bold;">Student ID</th>
                                <th style="font-size:17px;font-weight:bold;">Family ID</th>
                                <th style="font-size:17px;font-weight:bold;">Name</th>
                                <th style="font-size:17px;font-weight:bold;">Surname</th>
                                <th style="font-size:17px;font-weight:bold;">Date of Birth</th>
                                <th style="font-size:17px;font-weight:bold;">Gender</th>
                                <th style="font-size:17px;font-weight:bold;">Years in school</th>
                                <th style="font-size:17px;font-weight:bold;">Action</th>


                              </tr>
                            </thead>
                           <tbody>
                              @foreach(@$students as $student)
                              <tr>
                                 <th>{{@$student->studentid}}</th>
                                 <th>{{@$student->admissionid}}</th>
                                 <th>{{@$student->studentname}}</th>
                                 <th>{{@$student->studentsur}}</th>
                                 {{-- <th>{{@$student->studentdob}}</th> --}}
                                 <th>
                                    @if(!empty($student->studentdob) && preg_match('/\d/', $student->studentdob))
                                    {{ \Carbon\Carbon::parse($student->studentdob)->format('d-F-Y') }}
                                @endif

                                </th>

                                 <th>{{@$student->studentgender}}</th>
                                 <th>{{@$student->studentyearinschool}}</th>
                                 <th>

                                    <div style="display:flex;">
                                        <a href="{{ route('admin.admission.show', $student->studentid) }}"
                                            data-toggle="tooltip"
                                            title="View"

                                            class="btn btn-sm btn-success view viewButton ml-1">
                                            View
                                         </a>
                                         <a href="{{ route('admin.admission.edit', $student->studentid) }}"
                                            data-toggle="tooltip"
                                            title="Edit"
                                            class="btn btn-sm btn-primary edit editButton ml-1">
                                            Edit
                                         </a>
                                         {{-- <form method="POST" action="{{ route('admin.admission.destroy') }}">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="student_id" value="{{ $student->admission_id }}">
                                            <button class="btn btn-sm btn-danger del deleteButton ml-1">Delete</button>
                                        </form> --}}
                                    </div>

                              </th>
                              </tr>
                              @endforeach
                           </tbody>
                        </table>
                       @endif
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/libs/datatables/datatables.js') }}"></script>
<script>
   const searchOption = document.getElementById('search-option');
   const searchInput = document.getElementById('search-input');

   // Define the event listeners for each option
   function addEventListenersForOption(option) {
     searchInput.removeEventListener('keypress', alphaNumericOnly);
     searchInput.removeEventListener('keypress', numericOnly);
     if (option == 'student_name' || option == 'parent_name') {
       searchInput.addEventListener('keypress', alphaNumericOnly);
     } else if (option == 'postCode') {
       // Do nothing
     } else if (option == 'phone') {
       searchInput.addEventListener('keypress', numericOnly);
     } else if (option == 'family_id') {

        searchInput.addEventListener('keypress', numericOnly);

     }
     else {

     }
   }

   // Add the initial event listeners
   addEventListenersForOption(searchOption.value);

   // Add an event listener to the dropdown menu to update the input field's event listeners
   searchOption.addEventListener('change', function() {
     // Remove the old event listeners
     searchInput.removeEventListener('keypress', alphaNumericOnly);
     searchInput.removeEventListener('keypress', numericOnly);
      //clear input fields
      searchInput.value = '';
     // Add the new event listeners
     addEventListenersForOption(this.value);
   });

   // Define the alpha-numeric only validator
   function alphaNumericOnly(event) {
     if (!/[a-zA-Z\s]/i.test(event.key)) {
       event.preventDefault();
     }
   }

   // Define the numeric only validator
   function numericOnly(event) {
     if (!/\d/.test(event.key)) {
       event.preventDefault();
     }
   }
 </script>


{{-- <script>
   var table = $('#example').DataTable({
       processing: true,
       serverSide: true,
       ajax: {
           url: "{{ route('admin.admission.getadmissions') }}",
           type: 'GET',
           success: function(data) {
               console.log(data);
           }
       },
       columns: [
           {data: 'name'},
       ]
   });
</script> --}}
@endsection
