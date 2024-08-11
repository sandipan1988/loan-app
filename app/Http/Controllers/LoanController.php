<?php

namespace App\Http\Controllers;

use App\Models\Interests;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Loan;
use App\Models\Schedule;
use Carbon\Carbon;

class LoanController extends Controller
{
    /**
     * Display a listing of the users
     *
     * @param  \App\Models\User  $model
     * @return \Illuminate\View\View
     */
    public function index(Loan $loan)
    {
        $loans = $loan->paginate(15);
        /*echo "<pre/>";
        print_r($loans);
        exit;*/



        return view('loans.index', ['loans' => $loans]);
    }

    public function getScheduleById($loan_id)
    {
        $loan = Loan::with('schedules')->find($loan_id);

        $interest = Interests::where('loan_id', $loan_id)->first();
        return view('loans.amortization', ['loans' => $loan, 'interest' => $interest]);
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


    $loan->name = $request->input('name');
    $loan->email = $request->input('email');
    $loan->phone = $request->input('phone');
    $loan->address = $request->input('address');
    $loan->loan_type = $request->input('loan_type');

    $loan->interest_rate = $request->input('interest_rate');


    if ($loan->interest_rate == "other") {
        $loan->interest_rate = $request->other_interest_value;
    }

    $loan->interest_rate = trim($loan->interest_rate);



    $loan->loan_amount = $request->input('loan_amount');


    $loan->installment_amount = $request->input('installment_amount');



    //No. of installment
    $n = ceil(doubleval($loan->loan_amount / $loan->installment_amount));

    $random = mt_rand(10000000, 99999999);

    $loan->loan_account = "AC" . $random;

    $loan->loan_start_date = $request->input('loan_start_date');


    $loan->save();

    $loan_id = $loan->loan_id;

    $start = Carbon::parse($loan->loan_start_date);
    if ($loan->loan_type == "1") {

        $interest = $loan->loan_amount*$loan->interest_rate*0.01;

        $int_obj = new Interests();

        $int_obj->loan_id = $loan_id;

        $int_obj->interest_amount = $interest;

        $int_obj->save();
        //Daily
        for ($i = 0; $i <= $n; $i++) {
            $installment_date = $start->addRealDays($i)->toDateString();
            $schedule = new Schedule();
            $schedule->loan_id = $loan_id;
            $schedule->installment_amount = $loan->installment_amount;
            $schedule->installment_date = $installment_date;
            $schedule->save();
        }
    } elseif ($loan->loan_type == "2") {

        $interest = $loan->loan_amount*$loan->interest_rate*0.01;

        $int_obj = new Interests();

        $int_obj->loan_id = $loan_id;

        $int_obj->interest_amount = $interest;

        $int_obj->save();
        //Weekly
        for ($i = 0; $i <= $n; $i++) {
            $installment_date = $start->addRealWeeks($i)->toDateString();
            $schedule = new Schedule();
            $schedule->loan_id = $loan_id;
            $schedule->installment_amount = $loan->installment_amount;
           $schedule->installment_date = $installment_date;

            $schedule->save();
        }
    } else {

        $interest = $loan->loan_amount*$loan->interest_rate*0.01;

        $int_obj = new Interests();

        $int_obj->loan_id = $loan_id;

        $int_obj->interest_amount = $interest;

        $int_obj->save();
        //monthly
        for ($i = 0; $i <= $n; $i++) {
            $installment_date = $start->addRealMonths($i)->toDateString();
            $schedule = new Schedule();
            $schedule->loan_id = $loan_id;
            $schedule->installment_amount = $loan->installment_amount;
            $schedule->installment_date = $installment_date;
            $schedule->save();
        }
    }

    return redirect()->route('loan')->with('success', 'Loan updated successfully.');
}

    public function edit($loan_id)
    {
        dd($loan_id);

        $loan = Loan::find($loan_id);

        return view('loans.edit', ['loan'=>$loan]);
    }

    public function delete()
    {
        //return view('loans.add', []);
    }

    public function post(Request $request)
    {


        $loan = new Loan;
        $loan->name = $request->input('name');
        $loan->email = $request->input('email');
        $loan->phone = $request->input('phone');
        $loan->address = $request->input('address');
        $loan->loan_type = $request->input('loan_type');

        $loan->interest_rate = $request->input('interest_rate');


        if ($loan->interest_rate == "other") {
            $loan->interest_rate = $request->other_interest_value;
        }

        $loan->interest_rate = trim($loan->interest_rate);



        $loan->loan_amount = $request->input('loan_amount');


        $loan->installment_amount = $request->input('installment_amount');



        //No. of installment
        $n = ceil(doubleval($loan->loan_amount / $loan->installment_amount));

        $random = mt_rand(10000000, 99999999);

        $loan->loan_account = "AC" . $random;

        $loan->loan_start_date = $request->input('loan_start_date');

        $loan->save();

        $loan_id = $loan->loan_id;

        $start = Carbon::parse($loan->loan_start_date);
        if ($loan->loan_type == "1") {

            $interest = $loan->loan_amount*$loan->interest_rate*0.01;

            $int_obj = new Interests();

            $int_obj->loan_id = $loan_id;

            $int_obj->interest_amount = $interest;

            $int_obj->save();
            //Daily
            for ($i = 0; $i <= $n; $i++) {
                $installment_date = $start->addRealDays($i)->toDateString();
                $schedule = new Schedule();
                $schedule->loan_id = $loan_id;
                $schedule->installment_amount = $loan->installment_amount;
                $schedule->installment_date = $installment_date;
                $schedule->save();
            }
        } elseif ($loan->loan_type == "2") {

            $interest = $loan->loan_amount*$loan->interest_rate*0.01;

            $int_obj = new Interests();

            $int_obj->loan_id = $loan_id;

            $int_obj->interest_amount = $interest;

            $int_obj->save();
            //Weekly
            for ($i = 0; $i <= $n; $i++) {
                $installment_date = $start->addRealWeeks($i)->toDateString();
                $schedule = new Schedule();
                $schedule->loan_id = $loan_id;
                $schedule->installment_amount = $loan->installment_amount;
               $schedule->installment_date = $installment_date;

                $schedule->save();
            }
        } else {

            $interest = $loan->loan_amount*$loan->interest_rate*0.01;

            $int_obj = new Interests();

            $int_obj->loan_id = $loan_id;

            $int_obj->interest_amount = $interest;

            $int_obj->save();
            //monthly
            for ($i = 0; $i <= $n; $i++) {
                $installment_date = $start->addRealMonths($i)->toDateString();
                $schedule = new Schedule();
                $schedule->loan_id = $loan_id;
                $schedule->installment_amount = $loan->installment_amount;
                $schedule->installment_date = $installment_date;
                $schedule->save();
            }
        }

        return redirect(route('loan'))->with('success','loan added successdully');
    }
}
