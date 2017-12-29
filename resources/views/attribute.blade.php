@extends('layout.index')
@section('custom-css')
    <link href="/css/attribute.css" type="text/css" rel="stylesheet" />
@endsection
@section('custom-js')
    <script src="/js/attribute.js"></script>
@endsection
@section('pageContent')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">
                Filter
            </h3>
        </div>
        <div class="panel-body">
            <form method="post" action="{{route('attributepage')}}" class="form-inline">
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
            @if(!$attributeCollection->isEmpty())
                <input type="number" class="pageInputLimit form-control" />
            @endif
            {{ $attributeCollection->links() }}
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
                        <td>Category</td>
                        <td>Name</td>
                        <td>Alias</td>
                        <td>ContentType</td>
                        <td>DefaultMessage</td>
                        <td>Status</td>
                        <td>Time</td>
                        <td>Operate</td>
                    </tr>
                </thead>
                <tbody>
                    @forelse($attributeCollection as $attributeInfo)
                        <tr class="info @if($attributeInfo->Status != 'ACTIVE') warning @endif">
                            <td>
                                <input class="processtatuscheckbox" id="a_{{ $attributeInfo->Id }}" type="checkbox" value="{{ $attributeInfo->Id }}" />
                            </td>
                            <td>{{ $attributeInfo->Id or '' }}</td>
                            <td>{{ $attributeInfo->category->Alias or '' }}</td>
                            <td>{{ $attributeInfo->Name or '' }}</td>
                            <td>{{ $attributeInfo->Alias or '' }}</td>
                            <td>{{ $attributeInfo->ContentType or '' }}</td>
                            <td>{{ $attributeInfo->DefaultMessage or '' }}</td>
                            <td>{{ $attributeInfo->Status or '' }}</td>
                            <td>
                                a:{{ $attributeInfo->AddTime or '' }}
                                <hr style="width: 90%"/>
                                u:{{ $attributeInfo->UpdateTime or '' }}
                                <hr style="width: 90%"/>
                                t:{{ $attributeInfo->Timestamp or '' }}
                            </td>
                            <td>
                                <a href="javascript:void(0);" type="button" class="btn btn-info" data-toggle="modal" data-id="{{ $attributeInfo->Id }}" data-target="#oneModal" data-backdrop="static">
                                    详情
                                </a>
                                <a type="button" target="_blank" class="btn btn-info" href="{{ url('/attribute/edit/' . $attributeInfo->Id) . '?action=edit' }}">
                                    编辑
                                </a>
                                <a type="button" target="_blank" class="btn btn-info" href="{{ url('/attribute/edit') }}">
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
            {{ $attributeCollection->links() }}
        </div>
    </div>
@endsection

