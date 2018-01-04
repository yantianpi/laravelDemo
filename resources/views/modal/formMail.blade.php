<div class="form-group">
    <label for="tastNotifyTitle" class="col-xs-2">Title</label>
    <div class="col-xs-22">
        <input type="text" class="form-control" id="tastNotifyTitle" name="formData[notify][Title]" value="{{ $nofityInfo['Title'] or '' }}" />
    </div>
</div>
<div class="form-group">
    <label for="tastNotifyBody" class="col-xs-2">Body</label>
    <div class="col-xs-22">
        <textarea name="formData[notify][Body]" id="tastNotifyBody" rows="4">{{ $nofityInfo['Body'] or '' }}</textarea>
    </div>
</div>
<div class="form-group">
    <div class="col-xs-12">
        <div class="bold">To</div>
        @foreach($mailCollection as $mailInfo)
            <div class="checkbox">
                <label>
                    <input type="checkbox" value="{{ $mailInfo->Id }}" name="formData[notify][To][]" @if(isset($nofityInfo['To']) && in_array($mailInfo->Id, $nofityInfo['To'])) checked @endif/>
                    {{ $mailInfo->Name }}({{ $mailInfo->Mail }})
                </label>
            </div>
        @endforeach
    </div>
    <div class="col-xs-12">
        <div class="bold">Cc</div>
        @foreach($mailCollection as $mailInfo)
            <div class="checkbox">
                <label>
                    <input type="checkbox" value="{{ $mailInfo->Id }}" name="formData[notify][Cc][]" @if(isset($nofityInfo['Cc']) && in_array($mailInfo->Id, $nofityInfo['Cc'])) checked @endif/>
                    {{ $mailInfo->Name }}({{ $mailInfo->Mail }})
                </label>
            </div>
        @endforeach
    </div>
</div>