<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Schedule;
use App\Models\Interests;
use App\Models\Loan;

class ReportController extends Controller
{
    //

    public function getDues()
    {
        //todays due 
        // get current date (Y-m-d)
        $cur_date = Carbon::now()->format('Y-m-d');
        $schedules = Schedule::with('loan')->where('installment_date', $cur_date)->where('is_paid', 'NO')->paginate(10);
        $schedules_amount = Schedule::where('installment_date', $cur_date)->where('is_paid', 'NO')->sum('installment_amount');

        //yesterday's due 
        $yesterday_date = Carbon::yesterday()->format('Y-m-d');
        $schedules_yesterday = Schedule::with('loan')->where('installment_date', $yesterday_date)->where('is_paid', 'NO')->paginate(10);
        $schedules_amount_yesterday = Schedule::where('installment_date', $yesterday_date)->where('is_paid', 'NO')->sum('installment_amount');


        //all due upto today

        $schedules_all = Schedule::with('loan')->where('installment_date', '<=', $cur_date)->where('is_paid', 'NO')->orderBy('installment_date')->paginate(10);
        $schedules_amount_all = Schedule::where('installment_date', '<=', $cur_date)->where('is_paid', 'NO')->sum('installment_amount');

        $data = [
            'schedules' => $schedules,
            'schedules_yes' => $schedules_yesterday,
            'schedules_all' => $schedules_all,
            'schedules_amount' => $schedules_amount,
            'cur_date' => $cur_date,
            'yesterday_date' => $yesterday_date,
            'schedules_amount_yesterday' => $schedules_amount_yesterday,
            'schedules_amount_all' => $schedules_amount_all

        ];

        return view('report.due', $data);
    }
    public function searchDues(Request $request)
    {
        // dd($request->all()); exit;
        $data = [
            'schedules' => [],
            'start_date' => '',
            'end_date' => '',
            'name' => '',
            'search' => ''
        ];
        if ($request->search == 1) {

            if (!empty($request->name)) {

                $name = $request->name;

                $schedules = Schedule::with('loan')->whereHas(
                    'loan',
                    function ($query) use ($name) {
                        $query->with('members')->whereHas(
                            'members',
                            function ($query1) use ($name) {
                                $query1->where('name', $name);
                            }
                        );
                    }
                )->where('is_paid', 'NO')->get();
                $data = [
                    'schedules' => $schedules,
                    'start_date' => '',
                    'end_date' => '',
                    'name' => $request->name,
                    'search' => '1'
                ];
            } elseif (!empty($request->from_search_date) && !empty($request->to_search_date)) {
                $start_date = $request->from_search_date;
                $end_date = $request->to_search_date;
                $schedules = Schedule::with('loan')->whereBetween('installment_date', [$start_date, $end_date])->where('is_paid', 'NO')->get();

                $data = [
                    'schedules' => $schedules,
                    'start_date' => $start_date,
                    'end_date' => $end_date,
                    'name' => '',
                    'search' => '1'
                ];
            } else {
                $data = [
                    'message' => 'Name or Date Range required.',
                    'success' => false,
                    'schedules' => [],
                    'start_date' => '',
                    'end_date' => '',
                    'name' => '',
                    'search' => '1'

                ];
            }
        }

        return view('report.due', $data);
    }

    public function interest(Request $request)
    {

        if ($request->search == 1) {
            if (!empty($request->name)) {

                $name = $request->name;

                $interest = Interests::with('loan')->whereHas(
                    'loan',
                    function ($query) use ($name) {
                        $query->with('members')->whereHas(
                            'members',
                            function ($query1) use ($name) {
                                $query1->where('name', $name);
                            }
                        );
                    }
                )->get();

                $total_interests = Interests::with('loan')->whereHas(
                    'loan',
                    function ($query) use ($name) {
                        $query->with('members')->whereHas(
                            'members',
                            function ($query1) use ($name) {
                                $query1->where('name', $name);
                            }
                        );
                    }
                )->sum('interest_amount');


                $data = [
                    'schedules' => $interest,
                    'start_date' => '',
                    'end_date' => '',
                    'name' => $request->name,
                    'search' => '1',
                    'total_interests' => $total_interests,
                ];
            } elseif (!empty($request->from_search_date) && !empty($request->to_search_date)) {
                $start_date = $request->from_search_date;
                $end_date = $request->to_search_date;
                $interest = Interests::with('loan')->whereHas(
                    'loan',
                    function ($query) use ($start_date, $end_date) {
                        $query->whereBetween('loan_start_date', [$start_date, $end_date]);
                    }
                )->get();

                $total_interests = Interests::with('loan')->whereHas(
                    'loan',
                    function ($query) use ($start_date, $end_date) {
                        $query->whereBetween('loan_start_date', [$start_date, $end_date]);
                    }
                )->sum('interest_amount');

                $data = [
                    'schedules' => $interest,
                    'start_date' => $start_date,
                    'end_date' => $end_date,
                    'name' => '',
                    'search' => '1',
                    'total_interests' => $total_interests,
                ];
            } else {
                $data = [
                    'message' => 'Name or Date Range required.',
                    'success' => false,
                    'schedules' => [],
                    'start_date' => '',
                    'end_date' => '',
                    'name' => '',
                    'search' => '1',
                    'total_interests' => 0,

                ];
            }
        } else {
            $interests = Interests::with('loan')->paginate(10);

            $total_interests = Interests::sum('interest_amount');

            $data = [
                'schedules' => $interests,
                'total_interests' => $total_interests,
                'start_date' => '',
                'end_date' => '',
                'name' => '',
                'search' => ''
            ];
        }

        return view('report.interest', $data);
    }


    public function ledger($member_id)
    {
        $loans_member = Loan::with('members')->where('member_id', $member_id)->get();
        $data = ['loans' => $loans_member];
        return view('report.ledger', $data);
    }

    public function saleReport(Request $request)
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
                    'start_date' => '',
                    'end_date' => '',
                    'name' => $request->name,
                    'search' => '1'
                ];
            } elseif (!empty($request->from_search_date) && !empty($request->to_search_date)) {
                $start_date = $request->from_search_date;
                $end_date = $request->to_search_date;
                $loans = Loan::with('members')->whereBetween('loan_start_date', [$start_date, $end_date])->get();

                $data = [
                    'loans' => $loans,
                    'start_date' => $start_date,
                    'end_date' => $end_date,
                    'name' => '',
                    'search' => '1'
                ];
            } else {
                $data = [
                    'message' => 'Name or Date Range required.',
                    'success' => false,
                    'schedules' => [],
                    'start_date' => '',
                    'end_date' => '',
                    'name' => '',
                    'search' => '1'

                ];
            }
        } else {
            $loans = Loan::with('members')->paginate(10);

            $data = [
                'loans' => $loans,
                'start_date' => '',
                'end_date' => '',
                'name' => '',
                'search' => ''
            ];
        }

        return view('report.sale', $data);
    }
}
