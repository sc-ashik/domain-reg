@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row justify-content-center">
        <div class="col-2">
            <div class="list-group" id="list-tab" role="tablist">
            <a class="list-group-item list-group-item-action active" id="list-home-list" data-toggle="list" href="#list-home" role="tab" aria-controls="home">Registration</a>
            <a class="list-group-item list-group-item-action" id="list-profile-list" data-toggle="list" href="#list-profile" role="tab" aria-controls="profile">Scheduled Task</a>
            <a class="list-group-item list-group-item-action" id="list-messages-list" data-toggle="list" href="#list-messages" role="tab" aria-controls="messages">Completed Tasks</a>
            </div>
        </div>
        <div class="col-10">
            <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="list-home" role="tabpanel" aria-labelledby="list-home-list">
                <div class="card">
                    <div class="card-header">Dashboard</div>
                    @if(session()->has('message'))
                        <div class="alert alert-success">
                            {{ session()->get('message') }}
                        </div>
                    @endif
                    @if($errors->any())
                        <div class="alert alert-danger">
                            {{$errors->first()}}</h4>
                        </div>
                    @endif
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="/task">
                            @csrf

                            <div class="item">
                                <p>Enter one domains per line </p>
                                <textarea id="domains" name="domains" rows="3" oninvalid="InvalidMsg(this);" 
           oninput="InvalidMsg(this);" required ></textarea>
                            </div>

                            <div class="item">
                                <p>Start Datetime</p>
                                <input id="date" step="1" type="datetime-local" name="begin" min="{{$minDate}}"/>
                            </div>
                                <div class="item">
                                <p>Stop Datetime</p>
                                <input type="datetime-local" name="end" id="time" step="1"/>
                            </div>
                            <div>
                                <p> Sleep Time in milliseconds</p>
                                <input class='numB' type="number" name='req_p_sec' value='10'>
                            </div>
                            
                            <div class="btn-block">
                            <input id="regBtn" class="button" type="submit" name="register" value="Register Now" />
                            &nbsp;&nbsp;
                            <input id="scBtn" class="button" type="submit" name="schedule" value="Schedule"/>
                            
                            </div>

                        </form>
                    </div>
                </div>
                
            </div>
            <div class="tab-pane fade" id="list-profile" role="tabpanel" aria-labelledby="list-profile-list">
                <div class="card">
                    <div class="card-header">Tasks yet to execute</div>
                    <div class="card-body">
                                            
                        <div class="table-container1">
                        @include("table1")
                        </div>
                    </div>

                </div>

            </div>
            <div class="tab-pane fade" id="list-messages" role="tabpanel" aria-labelledby="list-messages-list">
                <div class="card">
                    <div class="card-header">Status of the executed Tasks</div>
                    <div class="card-body">

                        <div class="table-container2">
                            @include('table2')
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
    <script type="application/javascript"> 
        // Date.prototype.timeNow = function () {
        //     return ((this.getHours() < 10)?"0":"") + this.getHours() +":"+ ((this.getMinutes() < 10)?"0":"") + (this.getMinutes());
        // }
        var p2=0
        var table1=null
        var table2=null
        $(document).ready(function () {
            // $("#date").on("input",function(){
            //     var datenow=curday('-')
            //     var selectedDate=$(this).val()
            //     // console.log($(this).val()+ "== "+datenow)
            //     if(datenow==selectedDate){
            //         var timeNow=new Date().timeNow()
            //         console.log(timeNow)
            //         $('#time').attr("min",timeNow);

            //     }
            //     else{
            //         $('#time').removeAttr('min')
            //     }
            // })
            $("#scBtn").click(function(e){
                var splitted=$("#domains").val().split("\n")
                // console.log("zz "+splitted)
                var flag=true
                splitted.forEach(element => {
                    flag=flag && CheckIsValidDomain(element)
                });           
                if(!flag){
                    // alert(date)
                    document.getElementById("domains").setCustomValidity('DD')
                    // e.preventDefault()
                    // return
                }
                else
                    document.getElementById("domains").setCustomValidity('')


                var date=$("#date").val()              
                if(!date){
                    // alert(date)
                    document.getElementById("date").setCustomValidity('Field is required')
                    // e.preventDefault()
                }
                else{
                    var now = new Date()
                    var selected=new Date(date)
                    console.log(now+" " +selected)
                    if(selected<=now)
                        document.getElementById("date").setCustomValidity("Can't be Past")
                    else
                        document.getElementById("date").setCustomValidity('')
                    // alert(1)
                }

                var time=$("#time").val()              
                if(!time){
                    // alert(date)
                    document.getElementById("time").setCustomValidity('Field is required')
                    // e.preventDefault()
                }
                else{
                    var now = new Date()
                    var selected=new Date(time)
                    console.log(now+" " +selected)
                    if(selected<=now)
                        document.getElementById("time").setCustomValidity("Can't be Past")
                    else
                        document.getElementById("time").setCustomValidity('')
                    // alert(1)
                }
                    
            })

            table1=$('#dtBasicExample1').DataTable({
                    order: [[ 0, 'desc' ]],
                    retrieve:true,
                });
            table2=$('#dtBasicExample2').DataTable({
                order: [[ 0, 'desc' ]],
                retrieve:true
            });
            $('.dataTables_length').addClass('bs-select');
            setInterval(function () {
                p1=table1.page()
                p2=table2.page()
                // console.log("p2 in f "+table2.page())
                refreshTable(); 
            }, 2000);  
        });
        function refreshTable() {
            // $('div.table-container1').fadeOut();
            $('div.table-container1').load("/table1", function() {
                // $('div.table-container1').fadeIn();
                table1=$('#dtBasicExample1').DataTable({
                    order: [[ 0, 'desc' ]],
                    retrieve:true,
                });
                table1.page(p1).draw('page')
                // table1.draw(false)
            });
            $('div.table-container2').load("/table2", function() {
                // $('div.table-container1').fadeIn();
                table2=$('#dtBasicExample2').DataTable({
                    order: [[ 0, 'desc' ]],
                    retrieve:true,
                });
                // console.log("p2: "+p2)
                table2.page(p2).draw('page')
                // p2=table2.page()
                // table2.draw(false)
            });
        }
        function InvalidMsg(textbox) {
            var splitted = $('#domains').val().split("\n");
            // console.log(splitted)
            var flag=true
            splitted.forEach(element => {
                flag=flag && CheckIsValidDomain(element)
            });
            if (!flag) {
                textbox.setCustomValidity('Invalid domain list');
            }
            else {
            textbox.setCustomValidity('');
            }

            return true;
        }
        function CheckIsValidDomain(domain) { 
            var re = new RegExp(/^((?:(?:(?:\w[\.\-\+]?)*)\w)+)((?:(?:(?:\w[\.\-\+]?){0,62})\w)+)\.(\w{2,6})$/); 
            return domain.match(re);
        }
        function deleteThis(id){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type:'DELETE',
                url:"/task/"+id,
                success:function(data){
                    console.log(data);
                }
            });
        }
        function deleteThisCom(id){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type:'DELETE',
                url:"/completedtask/"+id,
                success:function(data){
                    console.log(data);
                }
            });
        }
        function curday(sp){
            var today = new Date();
            var dd = today.getDate();
            var mm = today.getMonth()+1; //As January is 0.
            var yyyy = today.getFullYear();

            if(dd<10) dd='0'+dd;
            if(mm<10) mm='0'+mm;
            return (yyyy+sp+mm+sp+dd);
        };
    </script>
</div>




@endsection
