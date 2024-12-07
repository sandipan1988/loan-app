<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Schedule;
use App\Models\Interests;
use App\Models\Loan;
use App\Exports\DailyExport;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    //

    public function getDues()
    {

        $data = $this->getDueData();
        
        return view('report.due', $data);
    }

    public function export() 
{
    return Excel::download(new DailyExport, 'invoices.xlsx');
}

    public function getDueData(){
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

       return  $data = [
            'schedules' => $schedules,
            'schedules_yes' => $schedules_yesterday,
            'schedules_all' => $schedules_all,
            'schedules_amount' => $schedules_amount,
            'cur_date' => $cur_date,
            'yesterday_date' => $yesterday_date,
            'schedules_amount_yesterday' => $schedules_amount_yesterday,
            'schedules_amount_all' => $schedules_amount_all,
            'search' => '0',
            'start_date' => '',
            'end_date' => '',
            'name' => '',

        ];

    }
    public function searchDues(Request $request)
    {
        // dd($request->all()); exit;
        $data = [
            'schedules' => [],
            'start_date' => '',
            'end_date' => '',
            'name' => '',
            'search' => '',
            'total_due' => '0'
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

                $total_due = Schedule::with('loan')->whereHas(
                    'loan',
                    function ($query) use ($name) {
                        $query->with('members')->whereHas(
                            'members',
                            function ($query1) use ($name) {
                                $query1->where('name', $name);
                            }
                        );
                    }
                )->where('is_paid', 'NO')->sum('installment_amount');
                $data = [
                    'schedules' => $schedules,
                    'start_date' => '',
                    'end_date' => '',
                    'name' => $request->name,
                    'search' => '1',
                    'total_due' => $total_due
                ];
            } elseif (!empty($request->from_search_date) && !empty($request->to_search_date)) {
                $start_date = $request->from_search_date;
                $end_date = $request->to_search_date;
                $schedules = Schedule::with('loan')->whereBetween('installment_date', [$start_date, $end_date])->where('is_paid', 'NO')->get();

                $total_due = Schedule::with('loan')->whereBetween('installment_date', [$start_date, $end_date])->where('is_paid', 'NO')->sum('installment_amount');
                $data = [
                    'schedules' => $schedules,
                    'start_date' => $start_date,
                    'end_date' => $end_date,
                    'name' => '',
                    'search' => '1',
                    'total_due' => $total_due
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
                    'total_due' => '0'

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

                $total_loan = Loan::with('members')->whereHas(
                    'members',
                    function ($query) use ($name) {
                                $query->where('name', $name);
                            }
                        )->sum('loan_amount');

                 $total_loss = Loan::with('members')->whereHas(
                            'members',
                            function ($query) use ($name) {
                                        $query->where('name', $name);
                                    }
                                )->sum('loss_amount');
                    
            


                $data = [
                    'schedules' => $interest,
                    'start_date' => '',
                    'end_date' => '',
                    'name' => $request->name,
                    'search' => '1',
                    'profit' => $total_loan + $total_interests - $total_loss,
                    'total_loan' => $total_loan,
                    'total_interests' => $total_interests,
                    'total_loss' => $total_loss

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

                $total_loan = Loan::whereBetween('loan_start_date', [$start_date, $end_date])->sum('loan_amount');

                $total_loss = Loan::whereBetween('loan_start_date', [$start_date, $end_date])->sum('loss_amount');

                $data = [
                    'schedules' => $interest,
                    'start_date' => $start_date,
                    'end_date' => $end_date,
                    'name' => '',
                    'search' => '1',
                    'profit' => $total_loan + $total_interests - $total_loss,
                    'total_loan' => $total_loan,
                    'total_interests' => $total_interests,
                    'total_loss' => $total_loss
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
                    'profit' => '0',
                    'total_loan' => '0',
                    'total_interests' => '0',
                    'total_loss' => '0'

                ];
            }
        } else {
            $interests = Interests::with('loan')->paginate(10);

            $total_loan = Loan::sum('loan_amount');


            $total_interests = Interests::sum('interest_amount');

            $total_loss = Loan::sum('loss_amount');
        

            $data = [
                'schedules' => $interests,
                'profit' => $total_loan + $total_interests - $total_loss,
                'start_date' => '',
                'end_date' => '',
                'name' => '',
                'search' => '',
                'total_loan' => $total_loan,
                'total_interests' => $total_interests,
                'total_loss' => $total_loss
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

                $total_loan = Loan::with('members')->whereHas(
                    'members',
                    function ($query) use ($name) {
                        $query->where('name', $name);
                    }
                )->sum('loan_amount');

            $total_installation_amount = Loan::with('members')->whereHas(
                'members',
                function ($query) use ($name) {
                    $query->where('name', $name);
                }
            )->sum('installment_amount');

                $data = [
                    'loans' => $loans,
                    'start_date' => '',
                    'end_date' => '',
                    'name' => $request->name,
                    'search' => '1',
                    'total_loan' => $total_loan,
                'total_installation_amount' =>  $total_installation_amount
           
                ];
            } elseif (!empty($request->from_search_date) && !empty($request->to_search_date)) {
                $start_date = $request->from_search_date;
                $end_date = $request->to_search_date;
                $loans = Loan::with('members')->whereBetween('loan_start_date', [$start_date, $end_date])->get();
                $total_loan = Loan::with('members')->whereBetween('loan_start_date', [$start_date, $end_date])->sum('loan_amount');

                $total_installation_amount = Loan::with('members')->whereBetween('loan_start_date', [$start_date, $end_date])->sum('installment_amount');

                $data = [
                    'loans' => $loans,
                    'start_date' => $start_date,
                    'end_date' => $end_date,
                    'name' => '',
                    'search' => '1',
                    'total_loan' => $total_loan,
                'total_installation_amount' =>  $total_installation_amount
           
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
                    'total_loan' => '0',
                'total_installation_amount' =>  '0'
           

                ];
            }
        } else {
            $loans = Loan::with('members')->paginate(10);

            $total_loan = Loan::sum('loan_amount');

            $total_installation_amount = Loan::sum('installment_amount');

            $data = [
                'loans' => $loans,
                'start_date' => '',
                'end_date' => '',
                'name' => '',
                'search' => '',
                'total_loan' => $total_loan,
                'total_installation_amount' =>  $total_installation_amount
            ];
        }

        return view('report.sale', $data);
    }
}
