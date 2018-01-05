@extends('layout.index')
@section('custom-css')
    <link href="/css/categoryDetail.css" type="text/css" rel="stylesheet" />
@endsection
@section('custom-js')
    <script src="/js/categoryDetail.js"></script>
@endsection
@section('pageContentDetail')
    <form class="form-horizontal" method="post" action="{{ $requestPath or '' }}">
        {{ csrf_field() }}
        <div class="form-group">
            <label class="col-xs-4 control-label">Id</label>
            <div class="col-xs-20">
                {{ $dataObject->Id or '' }}
            </div>
        </div>
        <div class="form-group">
            <label for="categoryName" class="col-xs-4 control-label">
                Name<span class="red">*</span>
            </label>
            <div class="col-xs-20 has-feedback">
                <input type="text" class="form-control" id="categoryName" name="formData[categoryName]" value="@if(isset($dataObject->Name)){{ old('formData.categoryName', $dataObject->Name) }}@else{{ old('formData.categoryName', '') }}@endif" data-id="{{ $dataObject->Id or '' }}" />
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
            </div>
        </div>
        <div class="form-group">
            <label for="categoryAlias" class="col-xs-4 control-label">Alias</label>
            <div class="col-xs-20">
                <input type="text" class="form-control" id="categoryAlias" name="formData[categoryAlias]" value="@if(isset($dataObject->Alias)){{ old('formData.categoryAlias', $dataObject->Alias) }}@else{{ old('formData.categoryAlias', '') }}@endif" />
            </div>
        </div>
        <div class="form-group">
            <label for="categoryScript" class="col-xs-4 control-label">categoryScript</label>
            <div class="col-xs-20">
                <input type="text" class="form-control" id="categoryScript" name="formData[categoryScript]" value="@if(isset($dataObject->Script)){{ old('formData.categoryScript', $dataObject->Script) }} @else {{ old('formData.categoryScript', '') }}@endif" />
            </div>
        </div>
        <div class="form-group">
            <label for="categoryStatus" class="col-xs-4 control-label">Status</label>
            <div class="col-xs-20">
                <select class="form-control" id="categoryStatus" name="formData[categoryStatus]">
                    @foreach($statusArray as $key => $value)
                        <option value="{{ $key }}" @if(!empty(old('formData.categoryStatus'))) @if(old('formData.categoryStatus') == $key) selected @endif @elseif(isset($dataObject->Status)) @if($dataObject->Status == $key) selected @endif @endif>
                            {{ $value }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group">
            <div class="col-xs-offset-4 col-xs-4">
                <button type="submit" class="btn btn-info">Submit</button>
            </div>
            <div class="col-xs-offset-4 col-xs-12">
                <button type="reset" class="btn btn-info">Reset</button>
            </div>
        </div>
        <input type="hidden" name="action" value="{{ $action or '' }}" />
        <input type="hidden" name="id" value="{{ $dataObject->Id or '' }}" />
    </form>
@endsection

