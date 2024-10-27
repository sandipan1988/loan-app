<?php

namespace App\Http\Controllers;


use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Session\Session;


class ScheduleController extends Controller
{
    /**
     * Display a listing of the users
     *
     * @param  \App\Models\User  $model
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $message = [];
        if (session('success')) {
            $message = ['success' => true, 'message' => session('success')];
            session('success', '');
        }

        if (session('error')) {
            $message = ['success' => false, 'message' => session('error')];
            session('error', '');
        }




        $search_date = '';
        $phone = '';
        $name = '';
        if (session('search') && (session('search')['name']!="" || session('search')['search_date']!="")) {
            $search_data = session('search');
            //print_r($search_data);

            $search_date = $search_data['search_date'];
            $phone = $search_data['phone'];
            $name = $search_data['name'];


            if ($phone and $search_date) {


                $schedules = Schedule::with('loan')->where('installment_date', $search_date)->whereHas(
                    'loan',
                    function ($query) use ($phone) {
                        $query->with('members')->whereHas(
                            'members',
                            function ($query1) use ($phone) {
                                $query1->where('phone', $phone);
                            }
                        );
                    }
                )->paginate(10);
            } elseif ($phone) {
                $schedules = Schedule::with('loan')->whereHas(
                    'loan',
                    function ($query) use ($phone) {
                        $query->with('members')->whereHas(
                            'members',
                            function ($query1) use ($phone) {
                                $query1->where('phone', $phone);
                            }
                        );
                    }
                )->paginate(10);
            } elseif ($search_date) {
                $schedules = Schedule::with('loan')->where('installment_date', $search_date)->paginate(10);
            }

            session(['search' => '']);
        }
        else{
                    // get current date (Y-m-d)
        $cur_date = Carbon::now()->format('Y-m-d');
        $schedules = Schedule::with('loan')->where('installment_date', $cur_date)->paginate(10);
        }
        //echo $search_date;

        //dd($schedules);
        $data=[
            'schedules' => $schedules,
            'message' => $message,
            'search_date' => $search_date? Carbon::parse($search_date) : "",
            'phone' => $phone,
            'name' => $name
        ];

        //echo $data['search_date'];

        return view(
            'schedule.index', $data
            
        );
    }

    public function search(Request $request)
    {
        $name = "";
        $phone = "";
        $search_date = "";

        if ($request->input('search-date') != '') {
            $search_date = $request->input('search-date'); 
        }

        if ($request->input('name') != '') {
            $name = $request->input('name');
            $phone = $request->input('phone');
        }



        $search_data = ['name' => $name, 'phone' => $phone, 'search_date' => $search_date];

        session(['search' => $search_data]);

        return redirect()->route('schedule');
    }

    public function post(Request $request)
    {
        $schedules = $request->input('schedule_ids') ? explode(",", $request->input('schedule_ids')) : [];

        $schedules = array_filter($schedules);

        array_unique($schedules);


        if (!empty($schedules)) {
            foreach ($schedules as $schedule_id) {
                $schedule = Schedule::find($schedule_id);
                $schedule->is_paid = 'YES';
                $schedule->paid_date = Carbon::now()->format('Y-m-d');
                $schedule->save();
            }
        }

        return redirect()->route('schedule')->with('success', 'Payment status changed successfully.');
    }

    public function edit()
    {
        return view('members.edit', []);
    }
    public function delete()
    {
        //return view('members.add', []);
    }
}
