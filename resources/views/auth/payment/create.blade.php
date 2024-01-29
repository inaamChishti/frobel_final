@extends('layouts.auth')
@section('styles')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<link href="{{ asset('assets/libs/datetimepicker/css/classic.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/libs/datetimepicker/css/classic.date.css') }}" rel="stylesheet" />

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<!-- Include Bootstrap CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<!-- Include Bootstrap Select CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.min.css">

<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>

<!-- Include Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- Include Bootstrap Select JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>


<style>

   .float-container {
   border: 3px solid #fff;
   padding: 20px;
   }
   .float-child {
   width: 45%;
   margin-left: 5px;
   float: left;
   }
   #star {
      color: red;
   }
   .sticker {
    background-color: #1e70cd;
    color: #fff;
    font-weight: bold;
    border-radius: 0.25rem 0 0 0.25rem;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
   }
</style>
@endsection
@section('content')

<div class="container-fluid flex-grow-1 container-p-y">
    <div class="ui-bordered px-4 pt-4 mb-4" style="background-color:white;box-shadow: 1px 1px 4px 6px	#b0516a;">
        <h4 class="font-weight-bold">
            <span class="text-muted font-weight-light"></span><b>Pay Student Fee</b>
        </h4>
        <div class="form-row">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Pay Student Fee</li>
                </ol>
            </nav>
        </div>
    </div>
   <div class="card mb-4" style="box-shadow: 1px 1px 4px 6px	#039dfe;">
      <h6 class="card-header" style="font-size: 19px;  color: black;font-weight:bold;">
         Student Fee Form
      </h6>
      <div class="card-body">
        @if ($errors->any())
        <div class="alert alert-danger alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            @foreach ($errors->all() as $error)
             <li>{{ $error }}</li>
            @endforeach
        </div>
        @endif
        @if(session()->has('success-message'))
            <div class="alert alert-success alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                {{ session()->get('success-message') }}
            </div>
        @endif
        <form method="GET" action="{{ route('admin.payment.show') }}">
            <div class="form-row float-container">
               <div class="col-md-6-12 offset-4">
                  <input type="number" name="family_id" class="form-control float-child" id="family_id" placeholder="Family ID" required>
                  <button type="submit" style="width: 100px;background-image: linear-gradient(to right, #0082e0 , #02d5df); !important"

                  class="btn btn-primary float-child">Search</button>
               </div>
            </div>
        </form>
        <div style="    border: 1px solid rgba(24, 28, 33, 0.06);
        padding:20px;border-radius:5px; box-shadow: 1px 1px 3px 2px	#f07910;
         margin-top:20px;">
        @isset($family_id)
        <form  method="POST" id="payment_form" action="{{ route('admin.payment.store') }}">
            @csrf
            <div>
                <div class="form-group mt-3">
                <div class="row">
                    <div class="col-md-3">
                    <input type="number" name="existing_family_id" class="form-control existing_family_id" placeholder="Family ID" value="{{ $family_id }}" readonly>
                    </div>
                    <div class="col-md-3">
                    <input type="text" name="total_student" class="form-control" placeholder="Family students" value="{{ $student_names }}" readonly>
                    </div>
                    <div class="col-md-03" style="margin-left:10px;">
                        <div class="input-group">
                            <label class="input-group-text sticker"  for="Last Paid" style=" background-image: linear-gradient(to right, #0082e0 , #02d5df); !important">Last Package</label>
                            <input type="text" class="form-control" id="last_payment_package" name="last_payment_package" placeholder="£0" value="{{ $last_package }}" readonly style="width: 100px">
                        </div>
                    </div>
                    <div class="col-md-03" style="margin-left:10px;">
                        <div class="input-group">
                            <label class="input-group-text sticker"  for="Last Paid" style=" background-image: linear-gradient(to right, #0082e0 , #02d5df); !important">Last Paid (£)</label>
                            <input type="text" class="form-control" id="last_package" name="last_paid" placeholder="£0" value="{{ $last_paid }}" readonly style="width: 100px">
                        </div>
                    </div>
                </div>
                </div>
            </div>
            <!-- Existing Fees Section -->
            <section id="Existing-fee-section ">
                <div class="row g-3 mt-4">
                   <div class="col-md-4">
                    <div class="input-group">
                        <label class="input-group-text sticker" for="Paid up to Date"style=" background-image: linear-gradient(to right, #0082e0 , #02d5df); !important">Paid up to Date</label>
                        <input type="text" class="form-control" id="paid_up_to_date" name="paid_up_to_date" placeholder="dd-mm-yyyy" value="{{ $paid_up_to_date }}" readonly>
                    </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group ">
                            <div class="input-group-prepend">
                                <span class="input-group-text sticker-text sticker"style=" background-image: linear-gradient(to right, #0082e0 , #02d5df); !important">Collector</span>
                            </div>
                            <input type="text" name="collector" class="form-control" placeholder="Collector name" value="{{ $auth_user }}" readonly>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text sticker-text sticker"
                                style=" background-image: linear-gradient(to right, #0082e0 , #02d5df); !important">Last Paid Date</span>
                            </div>
                            <input type="text" name="last_paid_date" class="form-control" placeholder="dd/mm/yyyy" value="{{ $last_payment_date ? $last_payment_date : '' }}" readonly>
                        </div>
                    </div>
                   {{-- <div class="col">
                     <label for="Paid up to Date">Paid up to Date</label>
                     <input type="text" name="paid_up_to_date" id="paid_up_to_date" class="form-control" placeholder="dd-mm-yyyy" value="{{ $paid_up_to_date }}" readonly>
                   </div> --}}
                </div>
                <button id="printBtn" class="btn btn-primary d-block mx-auto mt-5" style="width: 200px;">Print Previous Receipt</button>

                <div class="row g-3 mt-4">

                   <div class="col">
                   </div>

                </div>

             </section>


            </div>

             <!-- New Fees Section -->


<div style="    border: 1px solid rgba(24, 28, 33, 0.06);
padding:50px;border-radius:5px; box-shadow: 1px 1px 3px 2px	#b96edd;
 margin-top:20px;">
             <section id="new-fee-section">
               <div class="row g-3 mt-3">

                  <div class="col">
                    <label for="Package" style="font-size: 14px; color: black;font-weight:bold; margin: 0; display: block; opacity: 1; -webkit-transition: .333s ease top, .333s ease opacity; transition: .333s ease top, .333s ease opacity;" class="">
                        Package (£) <span id="star"
                        style="font-size:12px;"></span>
                    </label>
                     <input type="text" name="package" id="package" class="form-control" value="{{ $package }}" placeholder="Package" readonly>
                     <span id="lblError" class="text-danger"></span>
                    </div>
                  <div class="col">
                    <label for="Paid" style="font-size: 14px; color: black;font-weight:bold; margin: 0; display: block; opacity: 1; -webkit-transition: .333s ease top, .333s ease opacity; transition: .333s ease top, .333s ease opacity;">
                        Paid (£) <span id="star"
                        style="font-size:12px;">(required)</span></label>
                     <input type="number"
                     name="paid"
                     id="main_amount"
                     class="form-control"
                      value=""
                       placeholder="Amount only">
                  </div>
                  <div class="col">
                    <label for="Balance"
                    style="font-size: 14px;
                    color: black;font-weight:bold;

                    margin: 0; display: block; opacity: 1;
                    -webkit-transition: .333s ease top, .333s ease opacity; transition: .333s ease top, .333s ease opacity;">
                        Balance</label>

                        <input type="text" name="balance" class="form-control" value="{{ $balance }}" placeholder="£0" >

                  </div>
               </div>
               <div class="row g-3 mt-4">
                  <div class="col">
                    <label for="Paid from" style="font-size: 14px; color: black;font-weight:bold;">Paid from<span id="star"
                        style="font-size:12px;">(required)</span></label>
                     {{-- <input type="text" name="paid_from" class="form-control datepicker" value="{{ old('paid_from') }}" placeholder="dd/mm/yyyy"> --}}
                     <input type="text" id="datee" name="paid_from" class="form-control "  value=""
                            placeholder="dd/mm/yyyy">

                  </div>
                  <div class="col">
                    <label for="Paid to" style="font-size: 14px; color: black;font-weight:bold;">Paid to <span id="star"
                        style="font-size:12px;">(required)</span></label>
                     {{-- <input type="text" name="paid_to" class="form-control datepicker" value="{{ old('paid_to') }}" placeholder="dd/mm/yyyy"> --}}
                     <input type="text" id="date" name="paid_to" class="form-control "  value=""
                     placeholder="dd/mm/yyyy">


                  </div>

                  <div class="col">
                    <label for="Paid to" style="font-size: 14px; color: black;font-weight:bold;">Payment Date <span id="star"
                        style="font-size:12px;">(required)</span></label>
                     {{-- <input type="text" name="payment_date" class="form-control datepicker" value="{{ old('payment_date') }}" placeholder="dd/mm/yyyy"> --}}
                     <input type="text" id="date" name="payment_date" class="form-control "  value=""
                     placeholder="dd/mm/yyyy">
                  </div>

               </div>

               <div class="row mt-4">
                <div class="col">
                    <label for="comment" style="font-size: 14px; color: black;font-weight:bold;">Comment</label>
                     <textarea name="comment" class="form-control" cols="30" rows="5" placeholder="Enter comment here...">{{@$comments->comments}}</textarea>
                  </div>
               </div>
            </section>

            <section id="payment-method-section">
                {{-- <div class="row col-md-5 g-3 mt-3">
                    <div class="col">
                        <label for="Payment method" style="font-size: 14px; color: black;font-weight:bold;">Payment Method <span id="star"
                            style="font-size:12px;">(required)</span></label>
                         <select name="payment_method"  class="">
                            <option  disabled>Choose option</option>
                            <option @if( old('payment_method') == 'Cash Payment') selected @endif value="Cash Payment">Cash Payment</option>
                            <option @if( old('payment_method') == 'Card Payment') selected @endif value="Card Payment">Card Payment</option>
                            <option @if( old('payment_method') == 'Bank Transfer') selected @endif value="Bank Transfer">Bank Transfer</option>
                            <option @if( old('payment_method') == 'Adjustment') selected @endif value="Adjustment">Adjustment</option>
                         </select>
                      </div>

                      <div class="row col-md-5 g-3 mt-2">
                        <label for="Paid" style="font-size: 14px; color: black;font-weight:bold; margin: 0; display: block; opacity: 1; -webkit-transition: .333s ease top, .333s ease opacity; transition: .333s ease top, .333s ease opacity;">
                            Paid (£) <span id="star"
                            style="font-size:12px;">(required)</span></label>
                         <input type="number"
                         name="amount"
                         class="form-control"
                          value="{{ old('amount') }}"
                           placeholder="Amount only">
                      </div>
                </div> --}}

                <div class="row col-md-5 g-3 mt-3">
                    <div class="col">
                        <label for="Payment method" style="font-size: 14px; color: black;font-weight:bold;">Payment Method <span id="star"
                                style="font-size:12px;">(required)</span></label>
                        <select name="payment_method" id="payment_method" class="">
                            <option disabled>Choose option</option>
                            <option @if( old('payment_method') == 'Cash Payment') selected @endif value="Cash Payment">Cash Payment</option>
                            <option @if( old('payment_method') == 'Card Payment') selected @endif value="Card Payment">Card Payment</option>
                            <option @if( old('payment_method') == 'Bank Transfer') selected @endif value="Bank Transfer">Bank Transfer</option>
                            <option @if( old('payment_method') == 'Adjustment') selected @endif value="Adjustment">Adjustment</option>
                        </select>
                    </div>

                    <div class="row col-md-5 g-3 mt-2">
                        <!-- Add a class to all amount input fields for easier selection -->
                        <label for="Paid" style="font-size: 14px; color: black;font-weight:bold; margin: 0; display: block; opacity: 1; -webkit-transition: .333s ease top, .333s ease opacity; transition: .333s ease top, .333s ease opacity;">
                            Paid (£) <span id="star" style="font-size:12px;">(required)</span>
                        </label>
                        <input type="number" name="cash_payment_amount" class="form-control amount-input" value="" placeholder="Cash Payment Amount">
                        <input type="number" name="card_payment_amount" class="form-control amount-input" style="display: none;" value="" placeholder="Card Payment Amount">
                        <input type="number" name="bank_transfer_amount" class="form-control amount-input" style="display: none;" value="" placeholder="Bank Transfer Amount">
                        <input type="number" name="adjustment_amount" class="form-control amount-input" style="display: none;" value="" placeholder="Adjustment Amount">
                    </div>
                </div>

                <script>
                    // Add an event listener to the payment method select element
                    document.getElementById('payment_method').addEventListener('change', function () {
                        // Get the selected value
                        var selectedPaymentMethod = this.value;

                        // Hide all amount input fields
                        document.querySelectorAll('.amount-input').forEach(function (element) {
                            element.style.display = 'none';
                        });

                        // Show the amount input field for the selected payment method
                        if (selectedPaymentMethod !== 'Choose option') {
                            var amountInput = document.querySelector('[name="' + selectedPaymentMethod.toLowerCase().replace(' ', '_') + '_amount"]');
                            if (amountInput) {
                                amountInput.style.display = 'block';
                            }
                        }
                    });
                </script>





                    <div class="mt-5 text-center">
                        <button type="submit" class="btn btn-primary print" id="submitPayment"  style="background-image: linear-gradient(to right, #0082e0 , #02d5df); !important">Submit Payment</button>
                        <input type="checkbox" id="signal_work" checked>
<label for="signal_work">Print Receipt</label>
<input type="hidden" name="signal" id="signal" value="1">
<script>
    document.getElementById('submitPayment').addEventListener('click', function () {
        // Disable the button
        this.disabled = true;

        // Set a timeout to enable the button after 10 seconds
        setTimeout(function () {
            document.getElementById('submitPayment').disabled = false;
        }, 4000); // 10000 milliseconds = 10 seconds


    });
</script>


<script>
  $(document).ready(function() {
    // Set default state of checkbox and hidden input field
    $('#signal_work').prop('checked', true);
    $('#signal').val('1');

    // Add event listener to checkbox
    $('#signal_work').on('change', function() {
      if ($(this).is(':checked')) {
        // Checkbox is checked, set hidden input value to 1
        $('#signal').val('1');
      } else {
        // Checkbox is unchecked, set hidden input value to 0
        $('#signal').val('0');
      }
    });
  });
</script>


                    </div>

                </div>

<div style="    border: 1px solid rgba(24, 28, 33, 0.06);
padding-left:50px;padding-right:50px;border-radius:5px; box-shadow: 1px 1px 3px 2px	#b0516a;
 margin-top:20px;">
            @if (count($students) > 0)
                <div class="row g-3 mt-5">
                    <table class="table">
                        <thead>
                            <th style="font-size: 14px; color: black;font-weight:bold;">Name</th>
                            <th style="font-size: 14px; color: black;font-weight:bold;">Years</th>
                            <th style="font-size: 14px; color: black;font-weight:bold;">Hours</th>
                        </thead>
                        <tbody>
                           @foreach ($students as $student)
                               <tr>
                                 <td>{{ $student->name }}</td>
                                 <td>{{ $student->years_in_school }}</td>
                                 <td>{{ $student->hours }}</td>
                               </tr>
                           @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
            </section>



        </form>
        @endisset
        </div>
   </div>
</div>
<div id="#pdf"></div>
@endsection

@section('scripts')
<script src="{{ asset('assets/libs/datetimepicker/js/picker.js') }}"></script>
<script src="{{ asset('assets/libs/datetimepicker/js/picker.date.js') }}"></script>
<script>
    $(document).ready(function() {
      // Add click event listener to the submit button
      $("#submitPayment").click(function(event) {
        // Prevent the form from submitting initially
        event.preventDefault();

        // Check if the main_amount input field is null
        var mainAmountValue = $("#main_amount").val();
        if (mainAmountValue === null || mainAmountValue.trim() === "") {
          alert("Please enter a value for the Paid (£).");
        } else {
          // Check if all input fields are empty
          var allEmpty = true;
          $(".amount-input").each(function() {
            if ($(this).val() !== "") {
              allEmpty = false;
              return false; // Break out of the loop
            }
          });

          // Show alert if all fields are empty, otherwise submit the form
          if (allEmpty) {
            alert("Please enter the amount paid for the selected payment method.");
          } else {
            // Submit the form
            $("#payment_form").submit();

            var form = document.getElementById("payment_form");

                // Reset the form
                form.reset();
          }
        }
      });
    });
  </script>

<script>
    flatpickr("#date", {
      dateFormat: "Y-m-d",
      // Set the first day of the week to Monday (1 for Monday, 7 for Sunday)
      locale: {
        firstDayOfWeek: 1
      }
    });
  </script>

<script>
    $(document).ready(function () {
        $("#date").datepicker({
            dateFormat: 'dd/mm/yy',
            changeYear: true, // Allow changing the year
            yearRange: 'c-100:c+10', // Display a range of years centered around the current year
            showButtonPanel: true, // Show today and done buttons at the bottom
            closeText: 'Done', // Text for the close link
            currentText: 'Today', // Text for the current day link
            showAnim: 'slideDown', // Animation effect
            showOtherMonths: true, // Show dates from other months
            selectOtherMonths: true, // Allow selection of dates from other months
            showWeek: true, // Show the week number
        });

        // Set the current date as the default
        const today = new Date();
        $("#date").datepicker("setDate", today);
    });
</script>
<script>
    flatpickr("#datee", {
      dateFormat: "Y-m-d",
      // Set the first day of the week to Monday (1 for Monday, 7 for Sunday)
      locale: {
        firstDayOfWeek: 1
      }
    });
  </script>

<script>
    $(document).ready(function () {
        $("#datee").datepicker({
            dateFormat: 'dd/mm/yy',
            changeYear: true, // Allow changing the year
            yearRange: 'c-100:c+10', // Display a range of years centered around the current year
            showButtonPanel: true, // Show today and done buttons at the bottom
            closeText: 'Done', // Text for the close link
            currentText: 'Today', // Text for the current day link
            showAnim: 'slideDown', // Animation effect
            showOtherMonths: true, // Show dates from other months
            selectOtherMonths: true, // Allow selection of dates from other months
            showWeek: true, // Show the week number
        });

        // Set the current date as the default
        const today = new Date();
        $("#datee").datepicker("setDate", today);
    });
</script>
<script>

$('#printBtn').click(function(event) {
    event.preventDefault();
    var family_id = $('.existing_family_id').val();

    $.ajax({
        url: '{{ url("admin/pdfGenerate") }}/' + family_id,
    method: 'GET',
    success: function(data) {
        var pdfDataUri = data.pdfDataUri;
        var newWindow = window.open();
        newWindow.document.write('<iframe src="' + pdfDataUri + '" style="width:100%; height:100%;"></iframe>');
    },
    error: function(xhr, status, error) {
        console.log(error);
    }
});


});
    </script>

<script>
    // When the user clicks the .print button



</script>

<script>
   $(document).ready(function(){
        $('.datepicker').pickadate({
            selectMonths: true,
            selectYears: true,
            format: 'd/m/yyyy'
        });
   });
</script>

<script type="text/javascript">
    $(function () {
        $("#package").keypress(function (e) {
            var keyCode = e.keyCode || e.which;
            $("#lblError").html("");
            var regex = /^[A-Za-z0-9]+$/;

            //Validate TextBox value against the Regex.
            var isValid = regex.test(String.fromCharCode(keyCode));
            if (!isValid) {
                $("#lblError").html("Only Alphabets and Numbers allowed.");
            }
            else
            {
                $("#lblError").html("");
            }

            return isValid;
        });
    });

    // $('#package').bind("paste",function(){

    //     var data= $('#package').val() ;
    //     var removedNotAllowed = data.replace(/[^ws]/gi, '');
    //     $( '#package' ).val(removedNotAllowed);
    //     $("#lblError").html("Only Alphabets and Numbers allowed.");
    // });
</script>
<script>
    $(document).ready(function() {
        $('#print-btn').click(function() {
            window.print();
        });
    });
</script>
@endsection
