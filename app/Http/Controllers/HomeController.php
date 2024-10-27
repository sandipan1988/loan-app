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

        $overdue = DB::table('schedules')
                 ->where('schedules.is_paid','NO')
                 ->sum('schedules.installment_amount');
        return view('dashboard',compact('allmembers','loans','overdue','duetoday'));
    }
}
