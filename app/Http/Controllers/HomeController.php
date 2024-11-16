<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Loan;
use App\Models\Schedule;
use Illuminate\Support\Facades\DB;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $allmembers = Loan::count();
        $loans = Loan::sum('loan_amount');
        $duetoday = Schedule::where('installment_date',today())
                    ->where('is_paid','NO')
                    ->sum('installment_amount');


        $overdue = Schedule::with('loan')->where('is_paid','NO')->whereHas(
                    'loan',
                    function ($query) {
                                $query->where('loan_type','<>', '3');
                            }
                        )->sum('installment_amount');


        // add loan amounts of  monthly loans customer
        $overdue += Loan::where('loan_type', '3')->sum('loan_amount');

        //the amount not paid upto yesterday for monhtly customer

        $overdue += Schedule::with('loan')->where('is_paid','NO')->whereHas(
            'loan',
            function ($query) {
                        $query->where('loan_type', '3');
                    }
                )->where('installment_date','<',today())
                ->sum('installment_amount');


        return view('dashboard',compact('allmembers','loans','overdue','duetoday'));
    }
}
