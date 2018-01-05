@extends('layout.index')
@section('custom-css')
    <link href="/css/taskDetail.css" type="text/css" rel="stylesheet" />
@endsection
@section('custom-js')
    <script src="/js/taskDetail.js"></script>
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
            <label class="col-xs-4 control-label">CurrentStatus</label>
            <div class="col-xs-20">
                {{ $dataObject->CurrentStatus or '' }}
            </div>
        </div>
        <div class="form-group">
            <label for="taskProject" class="col-xs-4 control-label">Project</label>
            <div class="col-xs-20">
                <select class="form-control" id="taskProject" name="formData[taskProject]">
                    @foreach($projectCollection as $projectInfo)
                        <option value="{{ $projectInfo->Id }}" @if(!empty(old('formData.taskProject'))) @if(old('formData.taskProject') == $projectInfo->Id) selected @endif @elseif(isset($dataObject->ProjectId)) @if($dataObject->ProjectId == $projectInfo->Id) selected @endif @endif>
                            {{ $projectInfo->Name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="taskName" class="col-xs-4 control-label">
                Name<span class="red">*</span>
            </label>
            <div class="col-xs-20 has-feedback">
                <input type="text" class="form-control" id="taskName" name="formData[taskName]" value="@if(isset($dataObject->Name)){{ old('formData.taskName', $dataObject->Name) }}@else{{ old('formData.taskName', '') }}@endif" />
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
            </div>
        </div>
        <div class="form-group">
            <label for="taskDescription" class="col-xs-4 control-label">
                Description
            </label>
            <div class="col-xs-20">
                <textarea name="formData[taskDescription]" id="taskDescription" rows="4">@if(isset($dataObject->Description)){{ old('formData.taskDescription', $dataObject->Description) }}@else{{ old('formData.taskDescription', '') }}@endif</textarea>
            </div>
        </div>

        <div class="form-group">
            <label for="taskCronTime" class="col-xs-4 control-label">
                CronTime<span class="red">*</span>
            </label>
            <div class="col-xs-5 has-feedback">
                <input type="text" class="form-control" id="taskCronTime" name="formData[taskCronTime]" value="@if(isset($dataObject->CronTime)){{ old('formData.taskCronTime', $dataObject->CronTime) }}@else{{ old('formData.taskCronTime', '') }}@endif" @if(isset($dataObject->Batch) && $dataObject->Batch != 0) readonly @endif />
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
            </div>
            <div class="col-xs-offset-1 col-xs-4">
                <select class="form-control" id="Batch" name="formData[Batch]">
                    <option value="0">exclusive</option>
                    @foreach($batchCollection as $batchInfo)
                        <option value="{{ $batchInfo->Id }}" @if(!empty(old('formData.Batch'))) @if(old('formData.Batch') == $batchInfo->Id) selected @endif @elseif(isset($dataObject->Batch)) @if($dataObject->Batch == $batchInfo->Id) selected @endif @endif>
                            {{ $batchInfo->Alias }}({{ $batchInfo->Throughput }})
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="taskCategory" class="col-xs-4 control-label">Category</label>
            <div class="col-xs-20">
                <select class="form-control" id="taskCategory" name="formData[taskCategory]">
                    @foreach($categoryCollection as $categoryInfo)
                        <option value="{{ $categoryInfo->Id }}" @if(!empty(old('formData.taskCategory'))) @if(old('formData.taskCategory') == $categoryInfo->Id) selected @endif @elseif(isset($dataObject->CategoryId)) @if($dataObject->CategoryId == $categoryInfo->Id) selected @endif @endif>
                            {{ $categoryInfo->Alias }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-xs-4 control-label">Content</label>
            <div class="col-xs-20 tastContent">

            </div>
        </div>
        <div class="form-group">
            <label for="taskAlertLimit" class="col-xs-4 control-label">
                AlertLimit<span class="red">*</span>
            </label>
            <div class="col-xs-20 has-feedback">
                <input type="number" class="form-control" id="taskAlertLimit" name="formData[taskAlertLimit]" value="@if(isset($dataObject->AlertLimit)){{ old('formData.taskAlertLimit', $dataObject->AlertLimit) }}@else{{ old('formData.taskAlertLimit', '') }}@endif" />
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
            </div>
        </div>
        <div class="form-group">
            <label for="taskNotifyType" class="col-xs-4 control-label">NotifyType</label>
            <div class="col-xs-20">
                <select class="form-control" id="taskNotifyType" name="formData[taskNotifyType]">
                    @foreach($notifyTypeArray as $key => $value)
                        <option value="{{ $key }}" @if(!empty(old('formData.taskNotifyType'))) @if(old('formData.taskNotifyType') == $key) selected @endif @elseif(isset($dataObject->NotifyType)) @if($dataObject->NotifyType == $key) selected @endif @endif>
                            {{ $value }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-xs-4 control-label">NotifyContent</label>
            <div class="col-xs-20 tastNotifyContent"></div>
        </div>

        <div class="form-group">
            <label for="taskStatus" class="col-xs-4 control-label">Status</label>
            <div class="col-xs-20">
                <select class="form-control" id="taskStatus" name="formData[taskStatus]">
                    @foreach($statusArray as $key => $value)
                        <option value="{{ $key }}" @if(!empty(old('formData.taskStatus'))) @if(old('formData.taskStatus') == $key) selected @endif @elseif(isset($dataObject->Status)) @if($dataObject->Status == $key) selected @endif @endif>
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

