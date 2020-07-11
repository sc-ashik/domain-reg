                        <table id="dtBasicExample2" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                            <th class="th-sm">ID

                            </th>
                            <th class="th-sm"> Domain Name

                            </th>
                            <th class="th-sm"> Start Time

                            </th>
                            <th class="th-sm"> End Time

                            </th>
                            <th class="th-sm"> Response

                            </th>
                            <th class="th-sm"> Req Count

                            </th>
                            <th class="th-sm"> Last Response

                            </th>
                            <th class="th-sm">Api

                            </th>
                            <th class="th-sm"> Action

                            </th>
                            {{-- <th class="th-sm"> Created At

                            </th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($completed_tasks as $task)
                                <tr>
                                    <td>{{$task->id}}</td>
                                    <td>{{$task->domain_name}}</td>
                                    <td>{{$task->begin_time}}</td>
                                    <td>{{$task->end_time}}</td>
                                    <td>{{$task->response}}</td>
                                    <td>{{$task->req_count}}</td>
                                    <td>{{$task->last_response}}</td>
                                    <td>{{$task->api}}</td>
                                    <td>
                                        <button type="button" class="close" aria-label="Close" onclick="deleteThisCom({{$task->id}})">
                                             <span aria-hidden="true">&times;</span>
                                        </button>
                                    </td>
                                    {{-- <td>{{$task->created_at}}</td> --}}

                                </tr>
                            @endforeach 

                        </tbody>
                        <tfoot>
                            <tr>
                            <th class="th-sm">ID

                            </th>
                            <th class="th-sm"> Domain Name

                            </th>
                            <th class="th-sm"> Start Time

                            </th>
                            <th class="th-sm"> End Time
                                
                            </th>
                            <th class="th-sm"> Response

                            </th>
                            <th class="th-sm"> Req Count

                            </th>
                            <th class="th-sm"> Last Response

                            </th>
                            <th class="th-sm">Api

                            </th>
                            <th class="th-sm"> Action

                            </th>
                            {{-- <th class="th-sm"> Created At

                            </th> --}}
                            </tr>
                        </tfoot>
                        </table> 