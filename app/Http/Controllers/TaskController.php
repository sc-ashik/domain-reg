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
    public function __construct()
    {
      $this->middleware('auth');
    }
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
    public function reselloReg($domain){
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
            "response"=>"success:".$success,
            "api"=>"resello"
        ]);
    }
    public function namecheapReg($domain){
    
        $url="https://api.sandbox.namecheap.com/xml.response?" .
               env("API_USER") . "&" .
               env("API_KEY_NAMECHEAP") . "&" .
               env("USERNAME")."&" .
               "Command=namecheap.domains.create&" .
               env("CLIENTIP")."&" .
               env("YEARS")."&" .
               "AuxBillingFirstName=John&" .
                "AuxBillingLastName=Smith&" .
                "AuxBillingAddress1=8939%20S.cross%20Blv&" .
                "AuxBillingStateProvince=CA&" .
                "AuxBillingPostalCode=90045&" .
                "AuxBillingCountry=US&" .
                "AuxBillingPhone=+1.6613102107&" .
                "AuxBillingEmailAddress=john@gmail.com&" .
                "AuxBillingOrganizationName=NC&" .
                "AuxBillingCity=CA&" .
                "TechFirstName=John&" .
                "TechLastName=Smith&" .
                "TechAddress1=8939%20S.cross%20Blvd&" .
                "TechStateProvince=CA&" .
                "TechPostalCode=90045&" .
                "TechCountry=US&" .
                "TechPhone=+1.6613102107&" .
                "TechEmailAddress=john@gmail.com&" .
                "TechOrganizationName=NC&" .
                "TechCity=CA&" .
                "AdminFirstName=John&" .
                "AdminLastName=Smith&" .
                "AdminAddress1=8939%cross%20Blvd&" .
                "AdminStateProvince=CA&" .
                "AdminPostalCode=9004&" .
                "AdminCountry=US&" .
                "AdminPhone=+1.6613102107&" .
                "AdminEmailAddress=joe@gmail.com&" .
                "AdminOrganizationName=NC&" .
                "AdminCity=CA&" .
                "RegistrantFirstName=John&" .
                "RegistrantLastName=Smith&" .
                "RegistrantAddress1=8939%20S.cross%20Blvd&" .
                "RegistrantStateProvince=CS&" .
                "RegistrantPostalCode=90045&" .
                "RegistrantCountry=US&" .
                "RegistrantPhone=+1.6613102107&" .
                "RegistrantEmailAddress=jo@gmail.com&" .
                "RegistrantOrganizationName=NC&" .
                "RegistrantCity=CA&" .
                "GenerateAdminOrderRefId=False&".
                "DomainName=".$domain;
        // var_dump($url);
        $client = new Client();
        
        $requested_at=Carbon::now();
        $response = $client->post($url);
        $received_at=Carbon::now();

        $xmlResponse = simplexml_load_string($response->getBody());
        // $rjson=$xmlResponse->xpath("ApiResponse");
        // var_dump($rjson);
        $success=(string)$xmlResponse->CommandResponse->DomainCreateResult->attributes()->Registered;
        // echo "<pre>";

        // print_r($success);
        // echo "</pre>";

        // die();

        // JSON encode the XML, and then JSON decode to an array.
        // $rjson = json_decode(json_encode($xmlResponse), true);
        // var_dump($rjson);
        
        // return ;
        // $success = $rjson->success? 'true' : 'false';
        CompletedTask::create([
            "domain_name"=>$domain,
            "begin_time"=>$requested_at,
            "end_time"=>$received_at,
            "req_count"=>1,
            "last_response"=>$received_at,
            "response"=>"success:".$success,
            "api"=>"namecheap"
        ]);
    }
    public function getRegistrantID(){
        $url="https://soap-test.secureapi.com.au/API-2.0.wsdl";
        // var_dump($url);
        $client = new Client([
            'headers'=>array('content-type'=> 'application/soap+xml')
        ]);
        $response = $client->post($url,
        [
            "body"=>'<?xml version="1.0" encoding="UTF-8"?>
<env:Envelope xmlns:env="http://www.w3.org/2003/05/soap-envelope" xmlns:ns1="http://soap-test.secureapi.com.au/API-2.0">
	<env:Header>
		<ns1:Authenticate> 
			<AuthenticateRequest>
				<ResellerID>23172</ResellerID>
				<APIKey>e165aee9aa5765c36273ee5efb61c584</APIKey> 
			</AuthenticateRequest>
		</ns1:Authenticate> 
	</env:Header> 
	<env:Body>
		<ns1:ContactCloneToRegistrant> 
			<ContactCloneToRegistrantRequest>
				<ContactIdentifier>C-001172439-SN</ContactIdentifier> 
			</ContactCloneToRegistrantRequest>
		</ns1:ContactCloneToRegistrant>
	</env:Body>
</env:Envelope>'
        ]);
        $body=str_replace("https://{__HOSTNAME__}/API-2.0",$url,$response->getBody());
        // echo $body;  

        $xmlResponse = simplexml_load_string($body);
        return $xmlResponse->xpath('.//ContactIdentifier')[0]->__toString();
        // echo ($xmlResponse->children('http://www.w3.org/2003/05/soap-envelope')->body);
        // foreach($xmlResponse->children('http://www.w3.org/2003/05/soap-envelope')->Body->children($url) as $e){
        //     echo $e->getName().'\n';
        // }
        // // echo $response->getBody();
        // print_r($response->getBody());
        // die();
    }
    public function secureApiReg($domain){
    
        $url="https://soap-test.secureapi.com.au/API-2.0.wsdl";
        // var_dump($url);
        $client = new Client([
            'headers'=>array('content-type'=> 'application/soap+xml')
        ]);
        $registrantID=$this->getRegistrantID();
        $requested_at=Carbon::now();
        $response = $client->post($url,
        [
            "body"=>'<?xml version="1.0" encoding="UTF-8"?>
<env:Envelope xmlns:env="http://www.w3.org/2003/05/soap-envelope" xmlns:ns1="http://soap-test.secureapi.com.au/API-2.0">
	<env:Header>
		<ns1:Authenticate> 
			<AuthenticateRequest>
				<ResellerID>23172</ResellerID>
				<APIKey>e165aee9aa5765c36273ee5efb61c584</APIKey> 
			</AuthenticateRequest>
		</ns1:Authenticate> 
	</env:Header> 
	<env:Body>
 		<ns1:DomainCreate> 
			<DomainCreateRequest>
				<DomainName>'.$domain.'</DomainName> 				
				<RegistrantContactIdentifier>'.$registrantID.'</RegistrantContactIdentifier> 
				<AdminContactIdentifier>C-001172439-SN</AdminContactIdentifier> 
				<BillingContactIdentifier>C-001172439-SN</BillingContactIdentifier> 
				<TechContactIdentifier>C-001172439-SN</TechContactIdentifier>
				<RegistrationPeriod>1</RegistrationPeriod>
				<NameServers>
					<item xsi:type="ns1:NameServer"> 
						<Host>ns1.parkme.com.au</Host> 
						<IP>203.170.87.1</IP>
					</item>
					<item xsi:type="ns1:NameServer">
						<Host>ns2.parkme.com.au</Host>
						<IP>203.170.87.2</IP> 
					</item>
				</NameServers>
			</DomainCreateRequest>
		</ns1:DomainCreate>
	</env:Body> 
</env:Envelope>'

        ]);
        $received_at=Carbon::now();

        $body=str_replace("https://{__HOSTNAME__}/API-2.0",$url,$response->getBody());
        // echo $body;  

        $xmlResponse = simplexml_load_string($body);
        // print_r($xmlResponse->xpath('.//DomainDetails'));
        $success="False";
        if(!empty($xmlResponse->xpath('.//DomainDetails')))
            $success="True";
        // echo $success;
        // die();
        // $rjson=$xmlResponse->xpath("ApiResponse");
        // var_dump($rjson);
        // $success=(string)$xmlResponse->CommandResponse->DomainCreateResult->attributes()->Registered;
        // echo "<pre>";

        // print_r($success);
        // echo "</pre>";

        // die();

        // JSON encode the XML, and then JSON decode to an array.
        // $rjson = json_decode(json_encode($xmlResponse), true);
        // var_dump($rjson);
        
        // return ;
        // $success = $rjson->success? 'true' : 'false';
        CompletedTask::create([
            "domain_name"=>$domain,
            "begin_time"=>$requested_at,
            "end_time"=>$received_at,
            "req_count"=>1,
            "last_response"=>$received_at,
            "response"=>"success:".$success,
            "api"=>"secureapi"
        ]);
    }    
    public function store(Request $request)
    {
        // return $request->all();
        if($request->input("register")){
            // $scheduled_at=Carbon::now();
            $domains=explode("\r\n", $request->input("domains"));
            // return var_dump($domains);
            foreach($domains as $domain){
                // return $domain;
                if($request->input("resello"))
                    $this->reselloReg($domain);
                if($request->input("secureapi"))
                    $this->secureApiReg($domain);
                if($request->input("namecheap"))
                    $this->namecheapReg($domain);
            }
            return Redirect::back()->with('message', 'Successfully executed!');
            
        }
        else{
            $domains=explode("\r\n", $request->input("domains"));
            // $datetime=$request->input("date")." ".$request->input("time");
            $begin_datetime=Carbon::create($request->input('begin'));
            $begin_microsecond=$begin_datetime->timestamp;

            $end_datetime=Carbon::create($request->input('begin'));
            $end_datetime->addSeconds($request->input('end'));
            // $end_datetime=Carbon::create($request->input('end'));
            $end_microsecond=$end_datetime->timestamp;

            // return $end_datetime;
            if($end_microsecond<=$begin_microsecond || $end_microsecond-$begin_microsecond>15)
              return Redirect::back()->withErrors(["Duraction can't be negative or more than 15 s"]);

            // return $datetime;
            
            foreach($domains as $domain){
                if($request->input("resello"))
                    Task::create(["domain_name"=>$domain,"scheduled_at"=>$begin_microsecond,"datetime"=>$begin_datetime,'end_at'=>$end_microsecond,"end_datetime"=>$end_datetime,'req_p_sec'=>$request->input('req_p_sec'),'api'=>"resello"]);
                if($request->input("namecheap"))
                    Task::create(["domain_name"=>$domain,"scheduled_at"=>$begin_microsecond,"datetime"=>$begin_datetime,'end_at'=>$end_microsecond,"end_datetime"=>$end_datetime,'req_p_sec'=>$request->input('req_p_sec'),"api"=>"namecheap"]);
                if($request->input("secureapi"))
                    Task::create(["domain_name"=>$domain,"scheduled_at"=>$begin_microsecond,"datetime"=>$begin_datetime,'end_at'=>$end_microsecond,"end_datetime"=>$end_datetime,'req_p_sec'=>$request->input('req_p_sec'),"api"=>"secureapi"]);
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
