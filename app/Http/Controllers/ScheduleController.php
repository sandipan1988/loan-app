<?php

namespace App\Http\Controllers;


use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Http\Request;


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
        if(session('success')){
            $message = ['success' => true , 'message'=>session('success')];
            session('success','');
        }

        if(session('error')){
            $message = ['success' => false , 'message'=>session('error')];
            session('error', '');
        }

        // get current date (Y-m-d)
        $cur_date = Carbon::now()->format('Y-m-d');
        $schedules = Schedule::with('loan')->where('installment_date', $cur_date)->paginate(2);

        return view('schedule.index', ['schedules' => $schedules ,'message'=>$message]);
    }

    public function search(Request $request)
    {
        $name ="";
        $search_date = "";

        if($request->input('search-date') != ''){
           $search_date= $request->input('search-date');

        }

        if($request->input('name') != ''){
            $name= $request->input('name');

        }

        if($name and $search_date){

            $schedules = Schedule::with('loan')->where('installment_date', $search_date)->whereHas('loan', function ($query) use ($name) {
                $query->where('name', 'like', '%'.$name.'%');
            })->paginate(2);
        }
        elseif($name){
            $schedules = Schedule::with('loan')->whereHas('loan', function ($query) use ($name) {
                $query->where('name', 'like', '%'.$name.'%');
            })->paginate(2);
        }
        elseif($search_date){
              $schedules = Schedule::with('loan')->where('installment_date', $search_date)->paginate(2);
        }
        else{
            $cur_date = Carbon::now()->format('Y-m-d');
            $schedules = Schedule::with('loan')->where('installment_date', $cur_date)->paginate(2);
        }

        return view('schedule.index', ['schedules' => $schedules]);
    }

    public function post(Request $request)
    {
        $schedules = $request->input('schedule_ids') ? explode(",",$request->input('schedule_ids')) : [] ;

        $schedules=array_filter($schedules);

        array_unique($schedules);


        if(!empty($schedules)){
            foreach($schedules as $schedule_id){
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
