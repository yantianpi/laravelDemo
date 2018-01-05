@extends('layout.index')
@section('custom-css')
    <link href="/css/task.css" type="text/css" rel="stylesheet" />
@endsection
@section('custom-js')
    <script src="/js/task.js"></script>
@endsection
@section('pageContent')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">
                Filter
            </h3>
        </div>
        <div class="panel-body">
            <form method="post" action="{{route('taskpage')}}" class="form-inline">
                {{ csrf_field() }}
                <div class="form-group">
                    <label>
                        Id
                        <input type="number" name="formData[Id]" class="form-control" placeholder="Id" value="{{ $formData['Id'] or '' }}" />
                    </label>

                </div>
                <div class="form-group">
                    Category
                    <select name="formData[CategoryId]" class="form-control">
                        <option value="">>>请选择</option>
                        @foreach($categoryCollection as $categoryInfo)
                            <option value="{{ $categoryInfo->Id }}" @if(isset($formData['CategoryId']) && $formData['CategoryId'] == $categoryInfo->Id) selected @endif>{{ $categoryInfo->Alias }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    Project
                    <select name="formData[ProjectId]" class="form-control">
                        <option value="">>>请选择</option>
                        @foreach($projectCollection as $projectInfo)
                            <option value="{{ $projectInfo->Id }}" @if(isset($formData['ProjectId']) && $formData['ProjectId'] == $projectInfo->Id) selected @endif>{{ $projectInfo->Name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    NotifyType
                    <select name="formData[NotifyType]" class="form-control">
                        <option value="">>>请选择</option>
                        @foreach($notifyTypeArray as $key => $value)
                            <option value="{{ $key }}" @if(isset($formData['NotifyType']) && $formData['NotifyType'] == $key) selected @endif>{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    CurrentStatus
                    <select name="formData[CurrentStatus]" class="form-control">
                        <option value="">>>请选择</option>
                        @foreach($currentStatusArray as $key => $value)
                            <option value="{{ $key }}" @if(isset($formData['CurrentStatus']) && $formData['CurrentStatus'] == $key) selected @endif>{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    Status
                    <select name="formData[Status]" class="form-control">
                        <option value="">>>请选择</option>
                        @foreach($statusArray as $key => $value)
                            <option value="{{ $key }}" @if(isset($formData['Status']) && $formData['Status'] == $key) selected @endif>{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    Sort
                    <select name="formData[sort]" class="form-control">
                        <option value="">>>请选择</option>
                        @foreach($sortArray as $key => $value)
                            <option value="{{ $key }}" @if(isset($formData['sort']) && $formData['sort'] == $key) selected @endif>{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    Order
                    <select name="formData[order]" class="form-control">
                        <option value="">>>请选择</option>
                        @foreach($orderArray as $key => $value)
                            <option value="{{ $key }}" @if(isset($formData['order']) && $formData['order'] == $key) selected @endif>{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
                <input type="hidden" name="pageLimit" value="{{ $pageLimit or 5 }}" />
                <button type="submit" class="btn btn-info">Query</button>
            </form>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">
                {{ $pageName or 'Home' }}
            </h3>
        </div>
        <div class="panel-body full-height">
            @if(!$dataCollection->isEmpty())
                <input type="number" class="pageInputLimit form-control" />
            @endif
            {{ $dataCollection->links() }}
            <div class="checkbox">
                <label>
                    <input class="selall" type="checkbox" onclick="selectAllItems('selall', 'processtatuscheckbox');" />
                    Select All Items
                </label>
            </div>
            <table class="table table-striped table-hover table-responsive">
                <thead>
                    <tr>
                        <td></td>
                        <td>Id</td>
                        <td>Name</td>
                        <td>Description</td>
                        <td>Project</td>
                        <td>Category</td>
                        <td>CronTime</td>
                        <td>Batch</td>
                        <td>NotifyType</td>
                        <td>Statistic</td>
                        <td>CurrentStatus</td>
                        <td>Status</td>
                        <td>Time</td>
                        <td>Operate</td>
                    </tr>
                </thead>
                <tbody>
                    @forelse($dataCollection as $dataItem)
                        <tr class="info @if($dataItem->Status != 'ACTIVE') warning @endif">
                            <td>
                                <input class="processtatuscheckbox" id="a_{{ $dataItem->Id }}" type="checkbox" value="{{ $dataItem->Id }}" />
                            </td>
                            <td>{{ $dataItem->Id or '' }}</td>
                            <td>{{ $dataItem->Name or '' }}</td>
                            <td>{{ $dataItem->Description }}</td>
                            <td>{{ $dataItem->project->Name or '' }}</td>
                            <td>{{ $dataItem->category->Alias or '' }}</td>
                            <td>{{ $dataItem->CronTime or '' }}</td>
                            <td>
                                @if($dataItem->Batch == 0)
                                    exclusive
                                @else
                                    share
                                @endif

                            </td>
                            <td>{{ $dataItem->NotifyType or '' }}</td>
                            <td>
                                run:{{ $dataItem->MonitorCount }}<br />
                                alert:{{ $dataItem->AlertCount }}
                                <hr style="width: 90%"/>
                                seriesAlert:{{ $dataItem->SeriesAlertCount }}<br />
                                alertLimit:{{ $dataItem->AlertLimit }}
                            </td>
                            <td>{{ $dataItem->CurrentStatus or '' }}</td>
                            <td>{{ $dataItem->Status or '' }}</td>
                            <td class="tdTime">
                                s:{{ $dataItem->StartTime or '' }}<br />
                                e:{{ $dataItem->EndTime or '' }}
                                <hr style="width: 90%"/>
                                a:{{ $dataItem->AddTime or '' }}<br />
                                u:{{ $dataItem->UpdateTime or '' }}<br />
                                t:{{ $dataItem->Timestamp or '' }}
                            </td>
                            <td>
                                <a href="javascript:void(0);" type="button" class="btn btn-info" data-toggle="modal" data-id="{{ $dataItem->Id }}" data-target="#oneModal" data-backdrop="static">
                                    详情
                                </a>
                                <a type="button" target="_blank" class="btn btn-info" href="{{ url('/task/edit/' . $dataItem->Id) . '?action=edit' }}">
                                    编辑
                                </a>
                                <a type="button" target="_blank" class="btn btn-info" href="{{ url('/task/edit') }}">
                                    添加
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td></td>
                            <td colspan="9">{{ $notData or 'null' }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="checkbox">
                <label>
                    <input class="selall" type="checkbox" onclick="selectAllItems('selall', 'processtatuscheckbox');" />
                    Select All Items
                </label>
            </div>
            {{ $dataCollection->links() }}
        </div>
    </div>
@endsection

