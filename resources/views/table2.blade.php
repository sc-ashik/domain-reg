                        <table id="dtBasicExample2" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                            <th class="th-sm">ID

                            </th>
                            <th class="th-sm">Domain Name

                            </th>
                            <th class="th-sm">Scheduled At

                            </th>
                            <th class="th-sm"> Fast Request At

                            </th>
                            <th class="th-sm"> Last Request At

                            </th>
                            <th class="th-sm"> Response

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
                                    <td>{{$task->scheduled_at}}</td>
                                    <td>{{$task->requested_at}}</td>
                                    <td>{{$task->received_at}}</td>
                                    <td>{{$task->response}}</td>
                                    {{-- <td>{{$task->created_at}}</td> --}}

                                </tr>
                            @endforeach 

                        </tbody>
                        <tfoot>
                            <tr>
                            <th class="th-sm">ID

                            </th>
                            <th class="th-sm">Domain Name

                            </th>
                            <th class="th-sm">Scheduled At

                            </th>
                            <th class="th-sm"> Fast Request At

                            </th>
                            <th class="th-sm"> Last Request At

                            </th>
                            <th class="th-sm"> Response

                            </th>
                            {{-- <th class="th-sm"> Created At

                            </th> --}}
                            </tr>
                        </tfoot>
                        </table> 