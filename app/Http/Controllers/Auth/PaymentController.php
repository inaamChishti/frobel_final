<?php

namespace App\Http\Controllers\Auth;

use App\Exports\PaymentExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\PaymentRequest;
use App\Models\Admission;
use App\Models\ExistingPayment;
use App\Models\Payment;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DataTables;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class PaymentController extends Controller
{
    public function paymentExportForm()
    {
        return view('auth.payment.export');
    }
    public function showExportPayments(Request $request)
    {


        $from_date = date('Y-m-d', strtotime(str_replace('/', '-', $request->from_date)));
        $to_date = date('Y-m-d', strtotime(str_replace('/', '-', $request->to_date)));
        // dd(Carbon::parse($from_date)->format('m/d/Y'));
        // dd($from_date,$to_date);
        $payment_method = $request->payment_method;
        // dd($request->all(),$from_date,$to_date,Carbon::parse($from_date)->format('m/d/Y'),Carbon::parse($to_date)->format('m/d/Y'));
        if($payment_method == 'Cash Payment') {

            $payments = Payment::whereNotNull('payment_method')
            ->Where('payment_method', 'LIKE', '%Cash%')->whereBetween('paymentdate', [$from_date, $to_date])

            ->orderByDesc('paymentid')
            ->orderByDesc('paymentdate')
            ->get();


        }
        else if ($payment_method == 'Bank Transfer') {

            $payments = Payment::whereNotNull('payment_method')
            ->Where('payment_method', 'LIKE', '%Bank%')->whereBetween('paymentdate', [$from_date, $to_date])
            ->orderByDesc('paymentid')
            ->orderByDesc('paymentdate')
            ->get();

            // $payments = Payment::where(function ($query) use ($from_date, $to_date) {
            //     $query->where(function ($query) use ($from_date, $to_date) {
            //         $query->whereBetween('paymentdate', [$from_date, $to_date])
            //             ->orWhereBetween('paymentdate', [
            //                 Carbon::parse($from_date)->format('d/m/Y'),
            //                 Carbon::parse($to_date)->format('d/m/Y')
            //             ]);
            //     });
            // })
            // ->where(function ($query) use ($payment_method) {
            //     $query->where('payment_method', 'Bank/Online')
            //         ->orWhere('payment_method', 'Bank Transfer')
            //         ->orWhere('payment_method', 'LIKE', '%Bank/Online%')
            //         ->orWhere('payment_method', 'LIKE', '%Bank Transfer%');
            // })
            // ->orderByDesc('paymentid')
            // ->orderByDesc('paymentdate')
            // ->get();

        }

        else if($payment_method == 'Card Payment') {

            $payments = Payment::whereNotNull('payment_method')
            ->Where('payment_method', 'LIKE', '%Card%')
            ->whereBetween('paymentdate', [$from_date, $to_date])
            ->orderByDesc('paymentid')
            ->orderByDesc('paymentdate')
            ->get();
            // $payments = Payment::where(function ($query) use ($from_date, $to_date, $payment_method) {
            //     $query->where(function ($query) use ($from_date, $to_date) {
            //         $query->whereBetween('paymentdate', [$from_date, $to_date])
            //             ->orWhereBetween('paymentdate', [
            //                 Carbon::parse($from_date)->format('d/m/Y'),
            //                 Carbon::parse($to_date)->format('d/m/Y')
            //             ]);
            //     })
            //     ->where('payment_method', 'Card Payment');
            // })
            // ->orderByDesc('paymentid')
            // ->orderByDesc('paymentdate')
            // ->get();

        }
        else if($payment_method == 'Adjustment') {
            $payments = Payment::whereNotNull('payment_method')
            ->Where('payment_method', 'LIKE', '%Adjustment%')
            // ->Where('payment_method','Adjustment')
            ->whereBetween('paymentdate', [$from_date, $to_date])
            ->orderByDesc('paymentid')
            ->orderByDesc('paymentdate')
            ->get();
            // $payments = Payment::where(function ($query) use ($from_date, $to_date, $payment_method) {
            //     $query->where(function ($query) use ($from_date, $to_date) {
            //         $query->whereBetween('paymentdate', [$from_date, $to_date])
            //             ->orWhereBetween('paymentdate', [
            //                 Carbon::parse($from_date)->format('d/m/Y'),
            //                 Carbon::parse($to_date)->format('d/m/Y')
            //             ]);
            //     })
            //     ->where(function($query) use ($payment_method) {
            //         $query->where('payment_method', 'Adjustment')
            //             // ->orWhere('payment_method', 'Bank Transfer')
            //             ->orWhere('payment_method', 'LIKE', '%Adjustment%');
            //             // ->orWhere('payment_method', 'LIKE', '%Bank Transfer%');
            //     });
            // })
            // ->orderByDesc('paymentid')
            // ->orderByDesc('paymentdate')
            // ->get();
        }
        else if($payment_method == 'all')
        {
            $payments = Payment::whereNotNull('payment_method')
            ->whereBetween('paymentdate', [$from_date, $to_date])
            ->orderByDesc('paymentid')
            ->orderByDesc('paymentdate')
            ->get();
        }
        else
        {
            // $payments = Payment::where(function($query) use ($from_date, $to_date, $payment_method) {
            //     $query->where('paymentdate', '>=' , $from_date)
            //     ->where('paymentdate', '<=' , $to_date);
            // })
            // $payments = Payment::where(function ($query) use ($from_date, $to_date) {
            //     $query->whereBetween('paymentdate', [$from_date, $to_date]);
            // })
            // ->orWhere(function ($query) use ($from_date, $to_date) {
            //     $query->whereBetween('paymentdate', [
            //         Carbon::parse($from_date)->format('Y-m-d'),
            //         Carbon::parse($to_date)->format('Y-m-d')
            //     ]);
            // })
            // ->where(function($query) use ($payment_method) {
            //     $query->where('payment_method', '=' , $payment_method);
            // })
            // ->orderByDesc('paymentid')
            // ->orderByDesc('paymentdate')
            // ->get();
            $payments = Payment::whereNotNull('payment_method')
            ->whereNull('is_deleted')
            ->whereBetween('paymentdate', [$from_date, $to_date])
            ->orderByDesc('paymentid')
            ->orderByDesc('paymentdate')
            ->get();

            }

        $total_sum = $payments->sum('paid');
        // dd($payments);


        if(count($payments) < 1){
            return view('auth.payment.export')->withErrors('No record found corresponding to these details.');
        }
        else
        {
            return view('auth.payment.export', compact('payments','total_sum'));
        }

    }
    public function create()
    {
        return view('auth.payment.create');
    }
    public function show(Request $request)
    {

        $request->validate([
            'family_id' => 'required|numeric',
        ]);
        $family_id = $request->family_id;
        $students = Student::where('admissionid', $family_id)->get();
        $students_ids = array();
        foreach($students as $student){
            $students_ids[] = $student->studentid;
        }
        if(count($students_ids) <= 0){
            return redirect()->route('admin.payment.create')->withErrors([
                'error' => 'No student found, corresponding this family id.'
            ]);
        }
        foreach($students as $student){
            $student_names[] = $student->studentname;
        }
        $student_names = implode (" + ", $student_names);
        $std = Student::where('admissionid', $family_id)->first();
        $std_familyId = $std->admissionid;

        $payment = Payment::where('paymentfamilyid', $std_familyId)->orderBy('paymentid', 'desc')->first();
        if($payment == null)
        {

            $admission = Admission::where('familyno',$std_familyId)->first();
            $last_package = $admission->feedetail;
            $last_paid = null;
            $paid_up_to_date = null;
            $balance = null;

            $auth_user = null;
            $last_payment_date = null;

            $last_payment_date = null;

            $comments = \DB::table('payment_comments')
            ->where('family_id', $family_id)->first();
            if(!$comments)
            {
                $comments = null;
            }
            $package= $admission->feedetail;
            return view('auth.payment.create', compact('package', 'comments', 'last_package', 'last_paid', 'paid_up_to_date', 'auth_user', 'student_names', 'family_id', 'last_payment_date', 'students', 'balance'));
        }else
        if($payment){
            $admission = Admission::where('familyno',$std_familyId)->first();
            $last_package = $payment->package;
            $last_paid = $payment->paid;

            $paid_up_to_date = $payment->paymentto;
            $dateObject = \DateTime::createFromFormat('d/m/Y', $paid_up_to_date);

            if (!$dateObject) {
                // If the first format fails, try the second format
                $dateObject = \DateTime::createFromFormat('Y-m-d', $paid_up_to_date);
            }

            if ($dateObject) {
                // Convert the date to the desired format (12 December 2015)
                $formattedDate = $dateObject->format('d F Y');

                // Now $formattedDate contains the date in the desired format
                $paid_up_to_date = $formattedDate;
            } else {
                // Handle invalid date formats
                $paid_up_to_date = 'Invalid Date';
            }


            // $paid_up_to_date =$paid_up_to_date ? \Carbon\Carbon::parse($paid_up_to_date)->format('d-F-Y') : null; //strtotime($paid_up_to_date);
            // $paid_up_to_date = date('d/m/Y' ,$paid_up_to_date);
            $balance = ($payment->balance < 0 ? '+' : '') . abs(floatval($payment->balance));
            $package = $admission->feedetail;

            $auth_user = $payment->collector;
            $last_payment_date = $payment->paymentdate;

            $dateObject = \DateTime::createFromFormat('d/m/Y', $last_payment_date);

            if (!$dateObject) {
                // If the first format fails, try the second format
                $dateObject = \DateTime::createFromFormat('Y-m-d', $last_payment_date);
            }

            if ($dateObject) {
                // Convert the date to the desired format (12 December 2015)
                $last_payment_date = $dateObject->format('d F Y');

                // Now $formattedDate contains the date in the desired format
                $last_payment_date = $last_payment_date;
            } else {
                // Handle invalid date formats
                $last_payment_date = 'Invalid Date';
            }


            // $last_payment_date = \Carbon\Carbon::parse($last_payment_date)->format('d-F-Y');//date("d/m/Y", strtotime($last_payment_date));
            // $last_payment_date = $last_payment_date ? \Carbon\Carbon::parse($last_payment_date)->format('d-F-Y') : null;



            // dd( $payment->paymentto,$paid_up_to_date,'ok',$last_payment_date,$payment->paymentdate);

            $comments = \DB::table('payment_comments')
            ->where('family_id', $family_id)->first();
            // dd($comments->comments);


            return view('auth.payment.create', compact( 'package','comments', 'last_package', 'last_paid', 'paid_up_to_date', 'auth_user', 'student_names', 'family_id', 'last_payment_date', 'students', 'balance'));
        }
        else
        {
            return redirect()->route('admin.payment.create')->withErrors([
                'error' => 'No payment found, corresponding this family id.'
            ]);
        }
    }
    public function store(PaymentRequest $request)
    {
        // dd($request->all());
        $request->payment_method = implode(',', array_keys(array_filter([
            'Cash Payment' => $request->input('cash_payment_amount'),
            'Card Payment' => $request->input('card_payment_amount'),
            'Bank Transfer' => $request->input('bank_transfer_amount'),
            'Adjustment' => $request->input('adjustment_amount'),
        ])));

        // $request->payment_method = implode(', ', $request->payment_method);

        $request->balance = str_replace('+', '-', $request->balance);

        $family_id = $request->existing_family_id;

        $payment = Payment::where('paymentfamilyid', $family_id)->orderBy('paymentdate', 'desc')->first();
        // dd($payment);
        // dd($request->all(),$payment);
        $paid_up_to_date = 0;
        if($paid_up_to_date == 0){
            if($request->paid_to == ''){
                $paid_up_to_date = $payment->paymentto;
                $paid_up_to_date = date('Y-m-d',strtotime(str_replace('/', '-',  $paid_up_to_date)));
            }else
            {
                $paid_up_to_date = date('Y-m-d',strtotime(str_replace('/', '-',  $request->paid_to)));
            }

            $paid_from = date('Y-m-d',strtotime(str_replace('/', '-',  $request->paid_from)));
            $paid_to = date('Y-m-d',strtotime(str_replace('/', '-',  $request->paid_to)));
            $extractedDigits = preg_replace('/[^\d ]*\b(\d+)\b.*/', '$1', $request->package);

            if (preg_match('/[a-zA-Z]/', $extractedDigits)) {
                $extractedDigits = preg_replace('/^.*?(\d+).*?$/', '$1', $extractedDigits);

            }


            $existingPayment = Payment::where([
                'paymentfrom' => $paid_from,
                'paymentto' => $paid_to,
                'paymentfamilyid' => $family_id,
                'paymentdate' => date('Y-m-d', strtotime(str_replace('/', '-', $request->payment_date))),
                'paid' => $request->paid,
                'package' => $request->package,
                'collector' => auth()->user()->username,
                'balance' => $request->balance,
            ])->latest('created_at')->first();

            // Check if the existing record is within the last 1.5 minutes
            // dd($existingPayment,now()->diffInMinutes($existingPayment->created_at));
            if ($existingPayment && now()->diffInMinutes($existingPayment->created_at) <= 2) {


            }
            else
            {
                $payment = Payment::create([
                    'paymentfrom' => $paid_from,
                    'paymentto' => $paid_to,
                    'paymentfamilyid' => $family_id,
                    'paymentdate' => date('Y-m-d', strtotime(str_replace('/', '-', $request->payment_date))),
                    'paid' => $request->paid,
                    'package' => $request->package,
                    'collector' => auth()->user()->username,
                    'balance' => $request->balance,
                    'payment_method' => $request['payment_method'],
                    'payment_detail' => $request->paid,
                    'bank_transfer' => $request->input('bank_transfer_amount'),
                    'adjustment' => $request->input('adjustment_amount'),
                    'card_payment' => $request->input('card_payment_amount'),
                    'cash_payment' => $request->input('cash_payment_amount'),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }


            // dd($request->all(),$request['payment_method']);
            // $payment = Payment::firstOrNew([
            //     'paymentfrom' => $paid_from,
            //     'paymentto' => $paid_to,
            //     'paymentfamilyid' => $family_id,
            //     'paymentdate' => date('Y-m-d', strtotime(str_replace('/', '-', $request->payment_date))),
            //     'paid' => $request->paid,
            //     'package' => $request->package,
            //     'collector' => auth()->user()->username,
            //     'balance' => $request->balance,
            // ]);
            // // Check if the record already exists
            // if (!$payment->exists) {
            //     $payment->fill([
            //         // 'comment' => $request->comment,
            //         'payment_method' => $request['payment_method'],
            //         'payment_detail' => $request->paid,
            //         'bank_transfer' => $request->input('bank_transfer_amount'),
            //         'adjustment' => $request->input('adjustment_amount'),
            //         'card_payment' => $request->input('card_payment_amount'),
            //         'cash_payment' => $request->input('cash_payment_amount'),
            //         'created_at' => now(),
            //         'updated_at' => now(),
            //     ])->save();
            // }


            //  $payment = payment::create([
            //     'paymentfrom' => $paid_from,
            //     'paymentto' => $paid_to,
            //     'paid' => $request->paid,
            //     'paymentfamilyid' => $family_id,//$paid_up_to_date,
            //     'paymentdate' => date('Y-m-d',strtotime(str_replace('/', '-',  $request->payment_date))),//\Carbon\Carbon::now()->format('Y-m-d'),
            //     'package' => $request->package,
            //     'collector' => auth()->user()->username,
            //     'balance' => $request->balance,
            //     // 'comment' => $request->comment,
            //     'payment_method' => $request['payment_method'],
            //     'payment_detail' => $request->paid,
            //     'bank_transfer' => $request->input('bank_transfer_amount'),
            //     'adjustment' => $request->input('adjustment_amount'),
            //     'card_payment' => $request->input('card_payment_amount'),
            //     'cash_payment' => $request->input('cash_payment_amount'),
            //     'created_at' => now(),
            //     'updated_at' => now(),
            // ]);


            \DB::table('payment_comments')
            ->updateOrInsert(
                ['family_id' => $family_id],
                ['comments' => $request->comment]
            );


            if($request->signal == 1)
            {
                $pdf = new Dompdf();
                $pdf->setOptions(new Options([
                    'isPhpEnabled' => true,
                    'isRemoteEnabled' => true,
                    'isHtml5ParserEnabled' => true,
                    'margin-top' => '0mm',
                    'margin-right' => '0mm',
                    'margin-bottom' => '0mm',
                    'margin-left' => '0mm',
                ]));
                $data = [];

                $date = $currentDate = Carbon::now()->format('Y-m-d');

                        $timestamp = time();
                        $rand_num = rand(10, 999);
                        $random = $timestamp . $rand_num;

                        $year = date('y');
                        $day = date('d');
                        $month = date('m');
                        $hour = date('H');
                        $minute = date('i');
                        $random = rand(0, 999);
                        $random = $year . $day . $month . $hour . $minute;

                        $from = $paid_from;
                        $to = $paid_to;

                        $receivedfrom = $family_id;
                        $receivedto = auth()->user()->username;


                        function numberToWords($number) {
                            $words = [
                                0 => 'zero', 1 => 'one', 2 => 'two', 3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six',
                                7 => 'seven', 8 => 'eight', 9 => 'nine', 10 => 'ten', 11 => 'eleven', 12 => 'twelve',
                                13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen', 16 => 'sixteen', 17 => 'seventeen',
                                18 => 'eighteen', 19 => 'nineteen', 20 => 'twenty', 30 => 'thirty', 40 => 'forty',
                                50 => 'fifty', 60 => 'sixty', 70 => 'seventy', 80 => 'eighty', 90 => 'ninety'
                            ];

                            $number = str_replace(',', '', $number);
                            $number = (int) $number;

                            if ($number < 21) {
                                return $words[$number];
                            }

                            if ($number < 100) {
                                $tens = (int) ($number / 10) * 10;
                                $units = $number % 10;
                                return $words[$tens] . ($units ? '-' . $words[$units] : '');
                            }

                            if ($number < 1000) {
                                $hundreds = (int) ($number / 100);
                                $remainder = $number % 100;
                                return $words[$hundreds] . ' hundred' . ($remainder ? ' and ' . numberToWords($remainder) : '');
                            }

                            if ($number < 1000000) {
                                $thousands = (int) ($number / 1000);
                                $remainder = $number % 1000;
                                return numberToWords($thousands) . ' thousand' . ($remainder ? ' ' . numberToWords($remainder) : '');
                            }

                            if ($number < 1000000000) {
                                $millions = (int) ($number / 1000000);
                                $remainder = $number % 1000000;
                                return numberToWords($millions) . ' million' . ($remainder ? ' ' . numberToWords($remainder) : '');
                            }

                            throw 'Number is too large to convert to words';
                        }

                        $paid = $request->paid;
                        $amount_in_words = numberToWords($paid);
                        // dd($amount_in_words);
                        $feeAmount =  $request->package;
                        $thisPayment = $request->paid;
                        $thisbalance = $request->balance = str_replace('-', '+', $request->balance);
                        $paymentMethod = $request->payment_method;

                        $date = date('d F Y', strtotime($request->payment_date));
                        $from = date('d F Y', strtotime($from));
                        $to = date('d F Y', strtotime($to));



                        $data = ['date'=> $date,'random'=>$random,'from'=>$from,'to'=>$to,
                        'receivedfrom' => $receivedfrom,'receivedto'=>$receivedto,'amount_in_words'=>$amount_in_words,
                        'feeAmount'=>$feeAmount,'thisPayment' =>$thisPayment, 'thisbalance'=>$thisbalance,'paymentMethod'=>$paymentMethod,
                        'paid'=>$paid,
                        ];

                        $pdf->loadHtml(view('reports.receipt', $data));
                        $pdf->render();
                        $pdfOutput = $pdf->output();

                        // Generate a data URI for the PDF
                        $pdfDataUri = 'data:application/pdf;base64,' . base64_encode($pdfOutput);

                        // Create a unique ID for the new window or tab
                        $windowId = 'pdf-window-' . uniqid();

                        // Create a JavaScript function that opens the PDF in a new window or tab and redirects back to the previous page
                        $url = '/admin/payments/show?family_id=' . $family_id;
                        $script = "
                        <script>
                            var pdfOpened = false;

                            function openPdf() {
                                if (!pdfOpened) {
                                    pdfOpened = true;
                                    var pdfWindow = window.open('', '$windowId', 'toolbar=0,status=0,menubar=0,scrollbars=1,resizable=1,width=800,height=600');
                                    pdfWindow.document.write('<iframe src=\"$pdfDataUri\" style=\"width:100%; height:100%;\"></iframe>');

                                    pdfWindow.onunload = function() {
                                        pdfOpened = false;
                                        showSuccessMessage();
                                    };
                                }
                            }
                            openPdf();

                            function showSuccessMessage() {
                                // Redirect directly when the PDF window is closed
                                window.location.href = '$url';
                            }
                        </script>
                    ";

                        // Return the JavaScript function as a response
                        return response($script);






            }


            // $request->session()->flash('success-message', 'Fees Paid Successfully');
        }
        // dd($request->paid_to);

        return redirect()->back();
    }
    public function oldPayments(Request $request)
    {
        $payments = Payment::select('paymentid', 'paymentfamilyid', 'paymentfrom', 'paymentto', 'paymentdate' , 'package', 'paid', 'balance', 'payment_method', 'collector')->orderBy('paymentdate', 'desc');
        if ($request->ajax()) {
            return Datatables::of($payments)
                        ->addIndexColumn()
                        ->addColumn('paymentfrom', function($row){
                            if ($row->paymentfrom != null) {
                                $originalDate = $row->paymentfrom;

                                // Convert "2023-12-15" format to "12 December 2012"
                                $convertedDate = date('d F Y', strtotime($originalDate));

                                // Convert "01/27/2020" format to "12 December 2012"
                                $convertedDate = date('d F Y', strtotime(str_replace('/', '-', $originalDate)));

                                return $convertedDate;
                            }

                        })
                        ->addColumn('paymentto', function($row){
                            if($row->paymentto != null) {
                                // Convert "YYYY-MM-DD" format to "12 December 2012"
                                $convertedDate = date('d F Y', strtotime($row->paymentto));

                                // Convert "MM/DD/YYYY" format to "12 December 2012"
                                $convertedDate = date('d F Y', strtotime(str_replace('/', '-', $row->paymentto)));

                                return $convertedDate;
                            }
                        })

                        ->addColumn('paymentdate', function($row){
                            if($row->paymentdate != null) {
                                // Convert "YYYY-MM-DD" format to "12 December 2012"
                                $convertedDate = date('d F Y', strtotime($row->paymentdate));

                                // Convert "MM/DD/YYYY" format to "12 December 2012"
                                $convertedDate = date('d F Y', strtotime(str_replace('/', '-', $row->paymentdate)));

                                return $convertedDate;
                            }
                        })

                        ->rawColumns(['action'])
                        ->make(true);
        }
        return view('auth.payment.old');
    }
    public function exportPayments(Request $request)
    {
        return Excel::download(new PaymentExport, 'payment-export'. time(). '.csv');
    }
    public function previousPaymentForm()
    {
        return view('auth.payment.previous');
    }
    public function previousPaymentShow(Request $request)
    {

        $request->validate([
            'family_id' => 'required|integer'
        ]);
        $family_id = $request->family_id;

        $payments = Payment::where('paymentfamilyid', $family_id)
            ->where(function ($query) {
                $query->whereNull('is_deleted')
                    ->orWhere('is_deleted', '');
            })
            ->orderBy('paymentdate', 'desc')
            ->orderBy('paymentid', 'desc')
            ->select(
                '*',
                \DB::raw("COALESCE(DATE_FORMAT(STR_TO_DATE(paymentfrom, '%m/%d/%Y'), '%d %M %Y'), DATE_FORMAT(STR_TO_DATE(paymentfrom, '%Y-%m-%d'), '%d %M %Y')) as formatted_paymentfrom"),
                \DB::raw("COALESCE(DATE_FORMAT(STR_TO_DATE(paymentto, '%m/%d/%Y'), '%d %M %Y'), DATE_FORMAT(STR_TO_DATE(paymentto, '%Y-%m-%d'), '%d %M %Y')) as formatted_paymentto"),
                \DB::raw("COALESCE(DATE_FORMAT(STR_TO_DATE(paymentdate, '%m/%d/%Y'), '%d %M %Y'), DATE_FORMAT(STR_TO_DATE(paymentdate, '%Y-%m-%d'), '%d %M %Y')) as formatted_paymentdate")
            )
            ->get();
            // dd($payments);

        return view('auth.payment.previous', compact('payments'));
    }
    public function paymentLogForm()
    {
        $users = User::all();
        return view('auth.payment.log.index', compact('users'));
    }
    public function paymentLogShow(Request $request)
    {
        // dd(User::all());
            // dd($request->all());
        $request->validate([
            'users' => 'required',
            'date' => 'required'
        ]);
        $users = User::all();
       ;
        $date = date('Y-m-d', strtotime(str_replace('/', '-', $request->date)));
        $selectedUsers = $request->users;
        $allPayments = array();
        // dd($date);
        $count = 0;
        if(count($selectedUsers) > 0){
            foreach($selectedUsers as $key => $user){
                if($user == 'all'){
                    $allPayments = Payment::where('paymentdate', $date)->orderByDesc('paymentid')->get();
                    $count++;
                }
                else
                {
                    // it's checking that if all is selected will not execute else
                    if($count == 0){
                        $allPayments = Payment::where('collector', $user)->where('paymentdate', $date)->orderByDesc('paymentid')->get();
                    }
                }
            }
        }

        // dd($allPayments);

        return view('auth.payment.log.index', compact('allPayments', 'users'));


    }
    public function PrevDelete($id)
    {
        $paymentData = Payment::where('paymentid', $id)->first();
        DB::table('deleted_payments')->insert([
            'paymentid' => $paymentData->paymentid,
            'paymentfamilyid' => $paymentData->paymentfamilyid,
            'paymentfrom' => $paymentData->paymentfrom,
            'paymentto' => $paymentData->paymentto,
            'paymentdate' => $paymentData->paymentdate,
            'package' => $paymentData->package,
            'paid' => $paymentData->paid,
            'balance' => $paymentData->balance,
            'payment_method' => $paymentData->payment_method,
            'collector' => $paymentData->collector,
            'payment_detail' => $paymentData->payment_detail,
        ]);
        $payment = Payment::where('paymentid', $id)->update(['is_deleted' => now()]);
        // $payment = Payment::where('paymentid',$id)->delete();
       if($payment)
       {
        return back();
       }
       else
       {
        abort(404);
       }

    }

    public function pdfGenerate(Request $request, $id)
    {
        $latestPayment = Payment::where('paymentfamilyid', $id)
                        ->orderByDesc('paymentid')
                        ->first();


                        $pdf = new Dompdf();
                        $pdf->setOptions(new Options([
                            'isPhpEnabled' => true,
                            'isRemoteEnabled' => true,
                            'isHtml5ParserEnabled' => true,
                            'margin-top' => '0mm',
                            'margin-right' => '0mm',
                            'margin-bottom' => '0mm',
                            'margin-left' => '0mm',
                        ]));
                        $date = $currentDate = Carbon::now()->format('Y-m-d');

                        $timestamp = time();
                        $rand_num = rand(10, 999);
                        $random = $timestamp . $rand_num;

                        $year = date('y');
                        $day = date('d');
                        $month = date('m');
                        $hour = date('H');
                        $minute = date('i');
                        $random = rand(0, 999);
                        $random = $year . $day . $month . $hour . $minute;

                        $from = $latestPayment->paymentfrom;
                        $to = $latestPayment->paymentto;

                        $receivedfrom = $latestPayment->paymentfamilyid;
                        $receivedto = $latestPayment->collector;


                        function numberToWords($number) {
                            $words = [
                                0 => 'zero', 1 => 'one', 2 => 'two', 3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six',
                                7 => 'seven', 8 => 'eight', 9 => 'nine', 10 => 'ten', 11 => 'eleven', 12 => 'twelve',
                                13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen', 16 => 'sixteen', 17 => 'seventeen',
                                18 => 'eighteen', 19 => 'nineteen', 20 => 'twenty', 30 => 'thirty', 40 => 'forty',
                                50 => 'fifty', 60 => 'sixty', 70 => 'seventy', 80 => 'eighty', 90 => 'ninety'
                            ];

                            $number = str_replace(',', '', $number);
                            $number = (int) $number;

                            if ($number < 21) {
                                return $words[$number];
                            }

                            if ($number < 100) {
                                $tens = (int) ($number / 10) * 10;
                                $units = $number % 10;
                                return $words[$tens] . ($units ? '-' . $words[$units] : '');
                            }

                            if ($number < 1000) {
                                $hundreds = (int) ($number / 100);
                                $remainder = $number % 100;
                                return $words[$hundreds] . ' hundred' . ($remainder ? ' and ' . numberToWords($remainder) : '');
                            }

                            if ($number < 1000000) {
                                $thousands = (int) ($number / 1000);
                                $remainder = $number % 1000;
                                return numberToWords($thousands) . ' thousand' . ($remainder ? ' ' . numberToWords($remainder) : '');
                            }

                            if ($number < 1000000000) {
                                $millions = (int) ($number / 1000000);
                                $remainder = $number % 1000000;
                                return numberToWords($millions) . ' million' . ($remainder ? ' ' . numberToWords($remainder) : '');
                            }

                            throw 'Number is too large to convert to words';
                        }

                        $paid = $latestPayment->paid;
                        $amount_in_words = numberToWords($paid);
                        // dd($amount_in_words);
                        $feeAmount = $latestPayment->package;
                        $thisPayment = $latestPayment->paid;
                        $thisbalance = $latestPayment->balance = str_replace('-', '+', $latestPayment->balance);
                        $paymentMethod = $latestPayment->payment_method;

                        // $cash =  $latestPayment->payment_method == 'Cash Payment' ? 'Yes' : '';
                        // $adjustment = $latestPayment->payment_method == 'Adjustment' ? 'Yes' : '';

                        $date = date('d F Y', strtotime($latestPayment->paymentdate));
                        $from = date('d F Y', strtotime($from));
                        $to = date('d F Y', strtotime($to));

                        $data = ['date'=> $date,'random'=>$random,'from'=>$from,'to'=>$to,
                        'receivedfrom' => $receivedfrom,'receivedto'=>$receivedto,'amount_in_words'=>$amount_in_words,
                        'feeAmount'=>$feeAmount,'thisPayment'=>$thisPayment, 'thisbalance'=>$thisbalance,'paymentMethod'=>$paymentMethod,
                        // 'cash'=>$cash,'adjustment'=>$adjustment,
                        'paid'=>$paid,
                        ];

                        $pdf->loadHtml(view('reports.receipt', $data));
                        $pdf->render();
                        $pdfOutput = $pdf->output();

                        $pdfDataUri = 'data:application/pdf;base64,' . base64_encode($pdfOutput);

                        return response()->json(['pdfDataUri' => $pdfDataUri]);
    }

    public function defaulterList()
    {
        $paymentRecords = \DB::table('payment')
            ->select(
                'paymentfamilyid',
                \DB::raw('MAX(paymentdate) AS last_payment_date'),
                \DB::raw('MAX(paymentto) AS payment_expiry_date'),
                'balance'
            )
            ->whereIn('paymentfamilyid', function ($query) {
                $query->select('familyno')
                    ->from('admission')
                    ->where('familystatus', 'Active');
            })
            // ->where('paymentto', '<', now())
             ->where(function ($query) {
        $query->where('paymentto', '<', now())
            ->orWhere('paymentto', '<', \Carbon\Carbon::createFromFormat('m/d/Y', '01/01/2020'));
    })
            ->groupBy('paymentfamilyid', 'balance')
            ->orderBy('last_payment_date', 'desc')
            ->get();

        // Format payment_expiry_date using Carbon or PHP date functions
        foreach ($paymentRecords as $record) {
            $record->payment_expiry_date = $record->payment_expiry_date; // Replace with formatting logic
        }

        foreach ($paymentRecords as $record) {
            // Format last_payment_date
            if (!empty($record->last_payment_date)) {
                $lastPaymentDate = \DateTime::createFromFormat('Y-m-d', $record->last_payment_date);
                if ($lastPaymentDate !== false) {
                    $record->last_payment_date = $lastPaymentDate->format('d F Y');
                }
            }

            // Format payment_expiry_date
            if (!empty($record->payment_expiry_date)) {
                $expiryDate = \DateTime::createFromFormat('Y-m-d', $record->payment_expiry_date);
                if ($expiryDate !== false) {
                    $record->payment_expiry_date = $expiryDate->format('d F Y');
                }
            }
        }

        // Dump the updated collection
        // dd($paymentRecords->orderBy('last_payment_date', 'desc'));

        return view('defaulter.index', compact('paymentRecords'));
    }



}
