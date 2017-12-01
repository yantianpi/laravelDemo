@extends('layout.index')
@section('custom-css', '')
@section('pageContentDetail')
    <form class="form-horizontal" method="post" action="{{ $requestPath or '' }}">
        {{ csrf_field() }}
        <div class="form-group">
            <label class="col-xs-4 control-label">Id</label>
            <div class="col-xs-20">
                {{ $attributeObject->Id or '' }}
            </div>
        </div>
        <div class="form-group">
            <label for="attributeCategory" class="col-xs-4 control-label">Category</label>
            <div class="col-xs-20">
                <select class="form-control" id="attributeCategory" name="formData[attributeCategory]">
                    @foreach($categoryCollection as $categoryInfo)
                        <option value="{{ $categoryInfo->Id }}" @if(isset($attributeObject->CategoryId) && $attributeObject->CategoryId == $categoryInfo->Id) selected @endif>
                            {{ $categoryInfo->Alias }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="attributeName" class="col-xs-4 control-label">Name</label>
            <div class="col-xs-20">
                <input type="text" class="form-control" id="attributeName" name="formData[attributeName]" value="{{ $attributeObject->Name or '' }}" />
            </div>
        </div>
        <div class="form-group">
            <label for="attributeAlias" class="col-xs-4 control-label">Alias</label>
            <div class="col-xs-20">
                <input type="text" class="form-control" id="attributeAlias" name="formData[attributeAlias]" value="{{ $attributeObject->Alias or '' }}" />
            </div>
        </div>
        <div class="form-group">
            <label for="attributeContentType" class="col-xs-4 control-label">ContentType</label>
            <div class="col-xs-20">
                <select class="form-control" id="attributeContentType" name="formData[attributeContentType]">
                    @foreach($contentTypeArray as $key => $value)
                        <option value="{{ $key }}" @if(isset($attributeObject->ContentType) && $attributeObject->ContentType == $key) selected @endif>
                            {{ $value }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="attributeDefaultMessage" class="col-xs-4 control-label">DefaultMessage</label>
            <div class="col-xs-20">
                <input type="text" class="form-control" id="attributeDefaultMessage" name="formData[attributeDefaultMessage]" value="{{ $attributeObject->DefaultMessage or '' }}" />
            </div>
        </div>
        <div class="form-group">
            <label for="attributeStatus" class="col-xs-4 control-label">Status</label>
            <div class="col-xs-20">
                <select class="form-control" id="attributeStatus" name="formData[attributeStatus]">
                    @foreach($statusArray as $key => $value)
                        <option value="{{ $key }}" @if(isset($attributeObject->Status) && $attributeObject->Status == $key) selected @endif>
                            {{ $value }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group">
            <div class="col-xs-offset-4 col-xs-20">
                <button type="submit" class="btn btn-info">Submit</button>
            </div>
        </div>
    </form>
@endsection

