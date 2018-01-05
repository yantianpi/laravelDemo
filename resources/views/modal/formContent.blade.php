@foreach($dataCollection as $dataInfo)
    <div class="form-group">
        <label for="content{{ $dataInfo->Name }}Content" class="col-xs-4">{{ $dataInfo->Alias }}</label>
        <div class="col-xs-10">
            <input @if(in_array($dataInfo->ContentType, ['INT', ['FLOAT']])) type="number" @else type="text" @endif class="form-control" id="content{{ $dataInfo->Name }}Content" name="formData[content][{{ $dataInfo->Name }}][content]" value="{{ $contentInfo[$dataInfo->Name]['content'] or '' }}" />
        </div>
        <label for="content{{ $dataInfo->Name }}Message" class="col-xs-2">Msg</label>
        <div class="col-xs-8">
            <input type="text" class="form-control" id="content{{ $dataInfo->Name }}Message" name="formData[content][{{ $dataInfo->Name }}][message]" value="{{ $contentInfo[$dataInfo->Name]['message'] or $dataInfo->DefaultMessage }}" />
        </div>
    </div>
@endforeach