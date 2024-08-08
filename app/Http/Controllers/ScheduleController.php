<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the users
     *
     * @param  \App\Models\User  $model
     * @return \Illuminate\View\View
     */
    public function index(User $model)
    {
        return view('schedule.index', ['users' => $model->paginate(15)]);
    }

    public function add()
    {
        return view('members.add', []);
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
