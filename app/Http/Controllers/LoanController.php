<?php

namespace App\Http\Controllers;

use App\Models\Interests;
use App\Models\Member;
use Illuminate\Http\Request;
use App\Models\Loan;
use App\Models\Schedule;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Client\Request as ClientRequest;

use function PHPSTORM_META\exitPoint;


class LoanController extends Controller
{
    /**
     * Display a listing of the users
     *
     * @param  \App\Models\User  $model
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        

        if ($request->search == 1) {

            if (!empty($request->name)) {

                $name = $request->name;

                $loans = Loan::with('members')->whereHas(
                    'members',
                    function ($query) use ($name) {
                        $query->where('name', $name);
                    }
                )->get();

                $data = [
                    'loans' => $loans,
                    'name' => $request->name,
                    'search' => '1'
                ];
            } 

        }else{

            $loans = Loan::with('members')->paginate(10);
            $data = [
                'loans' => $loans,
                'name' => '',
                'search' => ''
            ];
        }
       

        return view('loans.index', $data);
    }

    public function findByName(Request $request){
        $name = $request->input('name');
        $members = Member::where('name', 'like', '%' . $name . '%')->get();
        return response()->json($members);
    }
    

    public function getScheduleById($loan_id)
    {
        $loans = Loan::with('members')->where('loan_id',$loan_id)->first();


        $schedules= Schedule::where('loan_id', $loan_id)->paginate(10);

        //dd($schedules); exit;
        $interest = Interests::where('loan_id', $loan_id)->first();


        return view('loans.amortization', ['loans' => $loans, 'schedules' => $schedules, 'interest' => $interest]);
    }

    public function getScheduleDownload($loan_id)
    {
        $loans = Loan::where('loan_id', $loan_id)->first();

        //dd($loans); exit;
        $schedules= Schedule::where('loan_id', $loan_id)->get();

        //dd($schedules); exit;
        $interest = Interests::where('loan_id', $loan_id)->first();

        $filename='amortization-'.$loans->name.'-'.time().'.pdf';

        $pdf = Pdf::loadView('loans.amortizationPDF', ['loans' => $loans, 'schedules' => $schedules, 'interest' => $interest]);

        //return $pdf->stream($filename);
        return $pdf->download($filename);

    }
    public function add()
    {
        return view('loans.add', []);
    }

    public function update(Request $request, $loan_id)
    {
    $loan = Loan::find($loan_id);

    if (!$loan) {
        return redirect()->route('loan')->with('error', 'Loan not found.');
    }

     // delete existing schedule
     Schedule::where('loan_id',$loan_id)->delete();

     // delete existing interest
     Interests::where('loan_id',$loan_id)->delete();

    $phone = $request->input('phone');

    // find member id by phone
    $member = Member::where('phone', $phone)->first();
    $loan->member_id = $member->member_id;
    
    $loan->loan_type = $request->input('loan_type');

    $loan->interest_rate = $request->input('interest_rate');


    if ($loan->interest_rate == "other") {
        $loan->interest_rate = $request->other_interest_value;
    }

    $loan->interest_rate = trim($loan->interest_rate);

    $loan->loan_amount = $request->input('loan_amount');

    $random = mt_rand(10000000, 99999999);

    $loan->loan_account = "AC" . $random;

    $loan->loan_start_date = $request->input('loan_start_date');

    
    if ($loan->loan_type == "1") {

        //No. of installment
        $N=100;
        $installment_amount = doubleval($loan->loan_amount / 100);

        $loan->installment_amount = $installment_amount;

        $loan->save();

        $interest = $loan->loan_amount*$loan->interest_rate*0.01;

        $int_obj = new Interests();

        $int_obj->loan_id = $loan_id;

        $int_obj->interest_amount = $interest;

        $int_obj->save();
        //Daily
        for ($i = 1; $i <= $N; $i++) {
            $start = Carbon::parse($loan->loan_start_date);
            $installment_date = $start->addRealDays($i)->toDateString();

            $schedule = new Schedule();
            $schedule->loan_id = $loan_id;
            $schedule->installment_amount = $installment_amount;
            $schedule->installment_date = $installment_date;
            $loan_end_date = $installment_date;
            $schedule->save();
        }

     //update loan last date
      $loan->loan_end_date = $loan_end_date;
      $loan->save();

    } elseif ($loan->loan_type == "2") {

         //No. of installment
         $N=ceil(doubleval(100/7));

        $installment_amount = 7*doubleval($loan->loan_amount / 100);
        $loan->installment_amount = $installment_amount;

        $loan->save();

        $interest = $loan->loan_amount*$loan->interest_rate*0.01;

        $int_obj = new Interests();
        $int_obj->loan_id = $loan_id;

        $int_obj->interest_amount = $interest;

        $int_obj->save();
        $sum_of_installment = 0;
        //Weekly
        for ($i = 1; $i <= $N; $i++) {
            $start = Carbon::parse($loan->loan_start_date);
            $installment_date = $start->addRealWeeks($i)->toDateString();
            $schedule = new Schedule();
            $schedule->loan_id = $loan_id;
            $schedule->installment_date = $installment_date;
            $loan_end_date = $installment_date;

            $sum_of_installment = $sum_of_installment+$installment_amount;

                if ($sum_of_installment < $loan->loan_amount) {
                    $schedule->installment_amount = $installment_amount;
                } else {
                    $schedule->installment_amount = $loan->loan_amount - $installment_amount*($N-1);
                }
            $schedule->save();
        }

        $loan->loan_end_date = $loan_end_date;
        $loan->save();
    } else {
        $N = (12*5) ;
        $interest = $loan->loan_amount*$loan->interest_rate*0.01;
        $installment_amount = $interest;
        $loan->installment_amount = $installment_amount;
        $loan->save();

        $loan_id = $loan->loan_id;

        $int_obj = new Interests();

        $int_obj->loan_id = $loan_id;

        $int_obj->interest_amount = $interest;

        $int_obj->save();
        //monthly
        for ($i = 0; $i <= $N; $i++) {
            $start = Carbon::parse($loan->loan_start_date);
            $installment_date = $start->addRealMonths($i)->toDateString();
            $schedule = new Schedule();
            $schedule->loan_id = $loan_id;
            $schedule->installment_amount = $installment_amount;
            $schedule->installment_date = $installment_date;
            $schedule->save();
        }
    }


    return redirect()->route('loan')->with('success', 'Loan updated successfully.');
}

    public function edit($loan_id)
    {


        $loan = Loan::find($loan_id);
        //dd($loan);

        return view('loans.edit', ['loan'=>$loan]);
    }

    public function delete($loan_id)
    {
        $loan = Loan::find($loan_id);
        if($loan)
        foreach($loan->schedules as $schedule){
        $schedule->delete();
        }
        $interest = Interests::where('interests.loan_id','=', $loan_id);

            $interest->delete();


        $loan->delete();
        return redirect()->route('loan')->with('success','data deleted successfully');
    }

    public function post(Request $request)
    {


        $loan = new Loan;
        $phone = trim($request->input('phone'));
        // find member id by phone
        $member = Member::where('phone', $phone)->first();
     
        $loan->loan_type = $request->input('loan_type');

        $loan->member_id = $member->member_id;

        $loan->interest_rate = $request->input('interest_rate');


        if ($loan->interest_rate == "other") {
            $loan->interest_rate = $request->other_interest_value;
        }

        $loan->interest_rate = trim($loan->interest_rate);
        $loan->loan_amount = $request->input('loan_amount');

        $loan->processing_charge = $request->input('processing_charge');

        $random = mt_rand(10000000, 99999999);

        $loan->loan_account = "AC" . $random;

        $loan->loan_start_date = $request->input('loan_start_date');

        if ($loan->loan_type == "1") {

            //No. of installment
            $N=100;
            $installment_amount = doubleval($loan->loan_amount / 100);

            $loan->installment_amount = $installment_amount;

            $loan->save();

            $loan_id = $loan->loan_id;

            $interest = $loan->loan_amount*$loan->interest_rate*0.01;

            $int_obj = new Interests();

            $int_obj->loan_id = $loan_id;

            $int_obj->interest_amount = $interest;

            $int_obj->save();
            //Daily
            for ($i = 1; $i <= $N; $i++) {
                $start = Carbon::parse($loan->loan_start_date);
                $installment_date = $start->addRealDays($i)->toDateString();

                $schedule = new Schedule();
                $schedule->loan_id = $loan_id;
                $schedule->installment_amount = $installment_amount;
                $schedule->installment_date = $installment_date;
                $loan_end_date = $installment_date;
                $schedule->save();
            }
            $loan->loan_end_date = $loan_end_date;
            $loan->save();

        } elseif ($loan->loan_type == "2") {

             //No. of installment
             $N=ceil(doubleval(100/7));

            $installment_amount = 7*doubleval($loan->loan_amount / 100);
            $loan->installment_amount = $installment_amount;
            $loan->save();

            $loan_id = $loan->loan_id;

            $interest = $loan->loan_amount*$loan->interest_rate*0.01;

            $int_obj = new Interests();

          

            $int_obj->loan_id = $loan_id;

            $int_obj->interest_amount = $interest;

            $int_obj->save();
            $sum_of_installment =0;
            //Weekly
            for ($i = 1; $i <= $N; $i++) {
                $start = Carbon::parse($loan->loan_start_date);
                $installment_date = $start->addRealWeeks($i)->toDateString();
                $schedule = new Schedule();
                $schedule->loan_id = $loan_id;
               
                $schedule->installment_date = $installment_date;
                $loan_end_date = $installment_date;
                $sum_of_installment = $sum_of_installment+$installment_amount;

                if ($sum_of_installment < $loan->loan_amount) {
                    $schedule->installment_amount = $installment_amount;
                } else {
                    $schedule->installment_amount = $loan->loan_amount - $installment_amount*($N-1);
                }

                $schedule->save();
            }
            $loan->loan_end_date = $loan_end_date;
            $loan->save();
        } else {
            $N = (12*5) ;
            $interest = $loan->loan_amount*$loan->interest_rate*0.01;
            $installment_amount = $interest;
            $loan->installment_amount = $installment_amount;
            $loan->save();
   
            $loan_id = $loan->loan_id;

            $int_obj = new Interests();

            $int_obj->loan_id = $loan_id;

            $int_obj->interest_amount = $interest;

            $int_obj->save();
            //monthly
            for ($i = 0; $i <= $N; $i++) {
                $start = Carbon::parse($loan->loan_start_date);
                $installment_date = $start->addRealMonths($i)->toDateString();
                $schedule = new Schedule();
                $schedule->loan_id = $loan_id;
                $schedule->installment_amount = $installment_amount;
                $schedule->installment_date = $installment_date;
                $schedule->save();
            }
        }

        return redirect(route('loan'))->with('success','loan added successfully');
    }

    public function getStatement($loan_id)
    {
       $loans  = Loan::where('loan_id', $loan_id)->first();

        //dd($loans); exit;
        $schedules= Schedule::where('loan_id', $loan_id)->where('is_paid','YES')->get();

        //dd($schedules); exit;
        $interest = Interests::where('loan_id', $loan_id)->first();
        //return view('loans.statement',  ['loans' => $loans, 'schedules' => $schedules, 'interest' => $interest]);
        $filename='Stmnt-'.$loans->name.'-'.time().'.pdf';

        $pdf = Pdf::loadView('loans.statement', ['loans' => $loans, 'schedules' => $schedules, 'interest' => $interest]);

        //return $pdf->stream($filename);
        return $pdf->download($filename);
    }

    public function close_loan(Request $request){
        $loan_id = $request->input('loan_id');
        $loss= trim($request->input('loss_amount'));

        $loan = Loan::find($loan_id);


        $loan->loss_amount=$loss;
        $loan->status='CLOSED';
       
        $loan->loan_end_date=Carbon::now()->toDateString();
        $loan->save();
        return redirect()->route('amortization-schedule',$loan_id);
    }

    
}
