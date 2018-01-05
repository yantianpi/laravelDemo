@extends('layout.index')
@section('custom-css')
    <link href="/css/log.css" type="text/css" rel="stylesheet" />
@endsection
@section('custom-js')
    <script src="/js/log.js"></script>
@endsection
@section('pageContent')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">
                Filter
            </h3>
        </div>
        <div class="panel-body">
            <form method="post" action="{{route('logpage')}}" class="form-inline">
                {{ csrf_field() }}
                <div class="form-group">
                    <label>
                        Id
                        <input type="number" name="formData[Id]" class="form-control" placeholder="Id" value="{{ $formData['Id'] or '' }}" />
                    </label>

                </div>
                <div class="form-group">
                    <label>
                        MapId
                        <input type="number" name="formData[MapId]" class="form-control" placeholder="MapId" value="{{ $formData['MapId'] or '' }}" />
                    </label>

                </div>
                <div class="form-group">
                    <label>
                        Keyword
                        <input type="text" name="formData[Keyword]" class="form-control" placeholder="Keyword" value="{{ $formData['Keyword'] or '' }}" />
                    </label>

                </div>
                <div class="form-group">
                    Type
                    <select name="formData[LogType]" class="form-control">
                        <option value="">>>请选择</option>
                        @foreach($typeArray as $key => $value)
                            <option value="{{ $key }}" @if(isset($formData['LogType']) && $formData['LogType'] == $key) selected @endif>{{ $value }}</option>
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
                        <td>Id<hr style="width: 90%"/>MapId</td>
                        <td>LogType</td>
                        <td>Program</td>
                        <td>Keyword</td>
                        <td>HasAlert</td>
                        <td>Time</td>
                        <td>Operate</td>
                    </tr>
                </thead>
                <tbody>
                    @forelse($dataCollection as $dataInfo)
                        <tr class="info">
                            <td>
                                <input class="processtatuscheckbox" id="a_{{ $dataInfo->Id }}" type="checkbox" value="{{ $dataInfo->Id }}" />
                            </td>
                            <td>
                                {{ $dataInfo->Id or '' }}
                                <hr style="width: 90%"/>
                                {{ $dataInfo->MapId or '' }}
                            </td>
                            <td>{{ $dataInfo->LogType or '' }}</td>
                            <td>{{ $dataInfo->Program or '' }}</td>
                            <td>{{ $dataInfo->Keyword or '' }}</td>
                            <td>{{ $dataInfo->HasAlert or '' }}</td>
                            <td>
                                a:{{ $dataInfo->AddTime or '' }}
                                <hr style="width: 90%"/>
                                u:{{ $dataInfo->UpdateTime or '' }}
                                <hr style="width: 90%"/>
                                t:{{ $dataInfo->Timestamp or '' }}
                            </td>
                            <td>
                                <a href="javascript:void(0);" type="button" class="btn btn-info" data-toggle="modal" data-id="{{ $dataInfo->Id }}" data-target="#oneModal" data-backdrop="static">
                                    详情
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td></td>
                            <td colspan="7">{{ $notData or 'null' }}</td>
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

