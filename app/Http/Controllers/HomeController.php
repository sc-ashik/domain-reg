<?php

namespace App\Http\Controllers;

use App\CompletedTask;
use App\Task;
use Illuminate\Http\Request;
use Carbon\Carbon;

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
        $completed_tasks=CompletedTask::orderBy("id","desc")->get();
        $scheduled_tasks=Task::orderBy("scheduled_at","asc")->get();
        return view('home',["completed_tasks"=>$completed_tasks,"scheduled_tasks"=>$scheduled_tasks]);
    }
    public function table1()
    {
        $scheduled_tasks=Task::orderBy("scheduled_at","asc")->get();
        return view('table1',["scheduled_tasks"=>$scheduled_tasks]);
    }
    public function table2()
    {
        $completed_tasks=CompletedTask::orderBy("id","desc")->get();
        return view('table2',["completed_tasks"=>$completed_tasks]);
    }
}
