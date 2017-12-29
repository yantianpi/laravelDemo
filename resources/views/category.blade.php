@extends('layout.index')
@section('custom-css')
    <link href="/css/category.css" type="text/css" rel="stylesheet" />
@endsection
@section('custom-js')
    <script src="/js/category.js"></script>
@endsection
@section('pageContent')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">
                Filter
            </h3>
        </div>
        <div class="panel-body">
            <form method="post" action="{{route('categorypage')}}" class="form-inline">
                {{ csrf_field() }}
                <div class="form-group">
                    <label>
                        Id
                        <input type="number" name="formData[Id]" class="form-control" placeholder="Id" value="{{ $formData['Id'] or '' }}" />
                    </label>

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
                        <td>Alias</td>
                        <td>Script</td>
                        <td>Status</td>
                        <td>Time</td>
                        <td>Operate</td>
                    </tr>
                </thead>
                <tbody>
                    @forelse($dataCollection as $dataInfo)
                        <tr class="info @if($dataInfo->Status != 'ACTIVE') warning @endif">
                            <td>
                                <input class="processtatuscheckbox" id="a_{{ $dataInfo->Id }}" type="checkbox" value="{{ $dataInfo->Id }}" />
                            </td>
                            <td>{{ $dataInfo->Id or '' }}</td>
                            <td>{{ $dataInfo->Name or '' }}</td>
                            <td>{{ $dataInfo->Alias or '' }}</td>
                            <td>{{ $dataInfo->Script or '' }}</td>
                            <td>{{ $dataInfo->Status or '' }}</td>
                            <td>
                                a:{{ $dataInfo->AddTime or '' }}
                                <hr style="width: 90%"/>
                                u:{{ $dataInfo->UpdateTime or '' }}
                                <hr style="width: 90%"/>
                                t:{{ $dataInfo->Timestamp or '' }}
                            </td>
                            <td>
                                <a href="javascript:void(0);" type="button" class="btn btn-info categoryDetail" data-id="{{ $dataInfo->Id }}">
                                    详情
                                </a>
                                <a href="javascript:void(0);" type="button" class="btn btn-info categoryAttributeList" data-alias="{{ $dataInfo->Alias or '' }}" data-id="{{ $dataInfo->Id }}">
                                    属性
                                </a>
                                <a type="button" target="_blank" class="btn btn-info" href="{{ url('/category/edit/' . $dataInfo->Id) . '?action=edit' }}">
                                    编辑
                                </a>
                                <a type="button" target="_blank" class="btn btn-info" href="{{ url('/category/edit') }}">
                                    添加
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

