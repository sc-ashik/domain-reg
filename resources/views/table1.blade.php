<table id="dtBasicExample1" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                            <th class="th-sm">ID

                            </th>
                            <th class="th-sm">Domain Name

                            </th>
                            <th class="th-sm">Start Time

                            </th>
                            <th class="th-sm">End Time

                            </th>
                            <th class="th-sm">Action

                            </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($scheduled_tasks as $task)
                                <tr>
                                    <td>{{$task->id}}</td>
                                    <td>{{$task->domain_name}}</td>
                                    <td>{{$task->datetime}}</td>
                                    <td>{{$task->end_datetime}}</td>
                                    <td>
                                        <button type="button" class="close" aria-label="Close" onclick="deleteThis({{$task->id}})">
                                             <span aria-hidden="true">&times;</span>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach 

                        </tbody>
                        <tfoot>
                            <tr>
                            <th class="th-sm">ID

                            </th>
                            <th class="th-sm">Domain Name

                            </th>
                            <th class="th-sm">Start Time

                            </th>
                            <th class="th-sm">End Time

                            </th>
                            <th class="th-sm">Action

                            </th>
                            </tr>
                        </tfoot>
                        </table>    