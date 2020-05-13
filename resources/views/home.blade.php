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

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="/profile">
                            @csrf

                            <div class="item">
                                <p>Enter one domains per line </p>
                                <textarea rows="3"></textarea>
                            </div>

                            <div class="item">
                                <p>Reservation Date</p>
                                <input type="date" name="bdate" required/>
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                                <div class="item">
                                <p>Reservation Time</p>
                                <input type="time" name="btime" required/>
                            </div>

                            
                            <div class="btn-block">
                            <button type="submit" href="/">Register Now</button>
                            &nbsp;&nbsp;
                            <button type="submit" href="/">Schedule</button>
                            
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
        $(document).ready(function () {
            $('#dtBasicExample1').DataTable();
            $('#dtBasicExample2').DataTable();
            $('.dataTables_length').addClass('bs-select');
            setInterval(function () {
                refreshTable(); 
            }, 1000);  
        });
        function refreshTable() {
            // $('div.table-container1').fadeOut();
            $('div.table-container1').load("/table1", function() {
                // $('div.table-container1').fadeIn();
                $('#dtBasicExample1').DataTable();
            });
            $('div.table-container2').load("/table2", function() {
                // $('div.table-container1').fadeIn();
                $('#dtBasicExample2').DataTable();
            });
        }
    </script>
</div>




@endsection
