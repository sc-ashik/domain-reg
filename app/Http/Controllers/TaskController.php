<?php

namespace App\Http\Controllers;

use App\CompletedTask;
use App\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Redirect;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request->all();
        if($request->input("register")){
            // $scheduled_at=Carbon::now();
            $domains=explode("\r\n", $request->input("domains"));
            // return var_dump($domains);
            foreach($domains as $domain){
                // return $domain;
                $client = new Client([
                    "headers"=>array("X-APIKEY"=>env("RESELLO_API_KEY"),"label"=>env('LABEL'))
                ]);
                
                $requested_at=Carbon::now();
                $response = $client->post(env("RESELLO_API_URL"), [
                    'json' => [
                        "customer"=> env("CUSTOMER_ID"),
                        "type"=> "new",
                        "order"=> [
                                "type"=> "domain-register-order",
                                "name"=> $domain,
                                "interval"=> 12
                            ]
                    ],
                    "http_errors"=>false
                ]);
                $response = $client->post(env("RESELLO_API_URL"), [
                    'json' => [
                        "customer"=> env("CUSTOMER_ID"),
                        "domain"=> $domain,
                        "interval"=> 12
                    ],
                    "http_errors"=>false
                ]);
                $received_at=Carbon::now();
                $rjson=json_decode($response->getBody());
                $success = $rjson->success? 'true' : 'false';
                CompletedTask::create([
                    "domain_name"=>$domain,
                    "begin_time"=>$requested_at,
                    "end_time"=>$received_at,
                    "req_count"=>1,
                    "last_response"=>$received_at,
                    "response"=>"success:".$success
                ]);
            }
            return redirect('/')->with('message', 'Successfully executed!');
            
        }
        else{
            $domains=explode("\r\n", $request->input("domains"));
            // $datetime=$request->input("date")." ".$request->input("time");
            $begin_datetime=Carbon::create($request->input('begin'));
            $begin_microsecond=$begin_datetime->timestamp;
            $end_datetime=Carbon::create($request->input('end'));
            $end_microsecond=$end_datetime->timestamp;

            if($end_microsecond<=$begin_microsecond || $end_microsecond-$begin_microsecond>10)
              return Redirect::back()->withErrors(["Duraction can't be negative or more than 10 s"]);

            // return $datetime;
            
            foreach($domains as $domain){
                Task::create(["domain_name"=>$domain,"scheduled_at"=>$begin_microsecond,"datetime"=>$begin_datetime,'end_at'=>$end_microsecond,"end_datetime"=>$end_datetime,'req_p_sec'=>$request->input('req_p_sec')]);
            }
        }
        return Redirect::back()->with('message', 'Successfully scheduled!');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Task::find($id)->delete();
    }
}
