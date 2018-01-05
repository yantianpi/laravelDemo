@extends('layout.index')
@section('custom-css')
    <link href="/css/batchDetail.css" type="text/css" rel="stylesheet" />
@endsection
@section('custom-js')
    <script src="/js/batchDetail.js"></script>
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
            <label for="batchName" class="col-xs-4 control-label">
                Name<span class="red">*</span>
            </label>
            <div class="col-xs-20 has-feedback">
                <input type="text" class="form-control" id="batchName" name="formData[batchName]" value="@if(isset($dataObject->Name)){{ old('formData.batchName', $dataObject->Name) }}@else{{ old('formData.batchName', '') }}@endif" data-id="{{ $dataObject->Id or '' }}" />
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
            </div>
        </div>
        <div class="form-group">
            <label for="batchAlias" class="col-xs-4 control-label">
                Alias
            </label>
            <div class="col-xs-20">
                <input type="text" class="form-control" id="batchAlias" name="formData[batchAlias]" value="@if(isset($dataObject->Alias)){{ old('formData.batchAlias', $dataObject->Alias) }}@else{{ old('formData.batchAlias', '') }}@endif" />
            </div>
        </div>
        <div class="form-group">
            <label for="batchCrontime" class="col-xs-4 control-label">
                Crontime<span class="red">*</span>
            </label>
            <div class="col-xs-20 has-feedback">
                <input type="text" class="form-control" id="batchCrontime" name="formData[batchCrontime]" value="@if(isset($dataObject->Crontime)){{ old('formData.batchCrontime', $dataObject->Crontime) }}@else{{ old('formData.batchCrontime', '') }}@endif" />
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
            </div>
        </div>
        <div class="form-group">
            <label for="batchThroughput" class="col-xs-4 control-label">
                Throughput<span class="red">*</span>
            </label>
            <div class="col-xs-20">
                <input type="number" class="form-control" id="batchThroughput" name="formData[batchThroughput]" value="@if(isset($dataObject->Throughput)){{ old('formData.batchThroughput', $dataObject->Throughput) }}@else{{ old('formData.batchThroughput', '') }}@endif" />
            </div>
        </div>
        <div class="form-group">
            <label for="batchStatus" class="col-xs-4 control-label">Status</label>
            <div class="col-xs-20">
                <select class="form-control" id="batchStatus" name="formData[batchStatus]">
                    @foreach($statusArray as $key => $value)
                        <option value="{{ $key }}" @if(!empty(old('formData.batchStatus'))) @if(old('formData.batchStatus') == $key) selected @endif @elseif(isset($dataObject->Status)) @if($dataObject->Status == $key) selected @endif @endif>
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

