<table id="dtBasicExample1" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                            <th class="th-sm">ID

                            </th>
                            <th class="th-sm">Domain Name

                            </th>
                            <th class="th-sm">Scheduled At

                            </th>
                            <th class="th-sm">Created At

                            </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($scheduled_tasks as $task)
                                <tr>
                                    <td>{{$task->id}}</td>
                                    <td>{{$task->domain_name}}</td>
                                    <td>{{$task->datetime}}</td>
                                    <td>{{$task->created_at}}</td>
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
                            <th class="th-sm">Created At

                            </th>
                            </tr>
                        </tfoot>
                        </table>    