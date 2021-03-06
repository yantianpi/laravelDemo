@extends('layout.index')
@section('custom-css')
    <link href="/css/attributeDetail.css" type="text/css" rel="stylesheet" />
@endsection
@section('custom-js')
    <script src="/js/attributeDetail.js"></script>
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
            <label for="attributeCategory" class="col-xs-4 control-label">Category</label>
            <div class="col-xs-20">
                <select class="form-control" id="attributeCategory" name="formData[attributeCategory]">
                    @foreach($categoryCollection as $categoryInfo)
                        <option value="{{ $categoryInfo->Id }}" @if(!empty(old('formData.attributeCategory'))) @if(old('formData.attributeCategory') == $categoryInfo->Id) selected @endif @elseif(isset($dataObject->CategoryId)) @if($dataObject->CategoryId == $categoryInfo->Id) selected @endif @endif>
                            {{ $categoryInfo->Alias }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="attributeName" class="col-xs-4 control-label">
                Name<span class="red">*</span>
            </label>
            <div class="col-xs-20 has-feedback">
                <input type="text" class="form-control" id="attributeName" name="formData[attributeName]" value="@if(isset($dataObject->Name)){{ old('formData.attributeName', $dataObject->Name) }}@else{{ old('formData.attributeName', '') }}@endif" data-id="{{ $dataObject->Id or '' }}" />
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
            </div>
        </div>
        <div class="form-group">
            <label for="attributeAlias" class="col-xs-4 control-label">Alias</label>
            <div class="col-xs-20">
                <input type="text" class="form-control" id="attributeAlias" name="formData[attributeAlias]" value="@if(isset($dataObject->Alias)){{ old('formData.attributeAlias', $dataObject->Alias) }}@else{{ old('formData.attributeAlias', '') }}@endif" />
            </div>
        </div>
        <div class="form-group">
            <label for="attributeContentType" class="col-xs-4 control-label">ContentType</label>
            <div class="col-xs-20">
                <select class="form-control" id="attributeContentType" name="formData[attributeContentType]">
                    @foreach($contentTypeArray as $key => $value)
                        <option value="{{ $key }}" @if(!empty(old('formData.attributeContentType'))) @if(old('formData.attributeContentType') == $key) selected @endif @elseif(isset($dataObject->ContentType)) @if($dataObject->ContentType == $key) selected @endif @endif>
                            {{ $value }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="attributeDefaultMessage" class="col-xs-4 control-label">DefaultMessage</label>
            <div class="col-xs-20">
                <input type="text" class="form-control" id="attributeDefaultMessage" name="formData[attributeDefaultMessage]" value="@if(isset($dataObject->DefaultMessage)){{ old('formData.attributeDefaultMessage', $dataObject->DefaultMessage) }} @else {{ old('formData.attributeDefaultMessage', '') }}@endif" />
            </div>
        </div>
        <div class="form-group">
            <label for="attributeStatus" class="col-xs-4 control-label">Status</label>
            <div class="col-xs-20">
                <select class="form-control" id="attributeStatus" name="formData[attributeStatus]">
                    @foreach($statusArray as $key => $value)
                        <option value="{{ $key }}" @if(!empty(old('formData.attributeStatus'))) @if(old('formData.attributeStatus') == $key) selected @endif @elseif(isset($dataObject->Status)) @if($dataObject->Status == $key) selected @endif @endif>
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

