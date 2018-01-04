<div>basic</div>
<ul class="list-group">
    <li class="list-group-item">
        <span class="badge">
            Id
        </span>
        {{ $taskObject->Id or '' }}
    </li>
    <li class="list-group-item">
        <span class="badge">
            Name
        </span>
        {{ $taskObject->Name or '' }}
    </li>
    <li class="list-group-item">
        <span class="badge">
            Project
        </span>
        {{ $taskObject->project->Name or '' }}
    </li>
    <li class="list-group-item">
        <span class="badge">
            Category
        </span>
        {{ $taskObject->category->Alias or '' }}
    </li>
    <li class="list-group-item">
        <span class="badge">
            CurrentStatus
        </span>
        {{ $taskObject->CurrentStatus or '' }}
    </li>
    <li class="list-group-item">
        <span class="badge">
            Status
        </span>
        {{ $taskObject->Status or '' }}
    </li>
</ul>
<div>content</div>
<ul class="list-group">
    @if(!empty($taskObject->ContentArray))
        <li class="list-group-item">
            <ul class="list-group">
                @foreach($taskObject->ContentArray as $key => $item)
                    {{ $key }}
                    <li class="list-group-item">
                        <span class="badge">
                            Content
                        </span>
                        {{ $item['content'] or '' }}
                    </li>
                    <li class="list-group-item">
                        <span class="badge">
                            Msg
                        </span>
                        {{ $item['message'] or '' }}
                    </li>
                @endforeach
            </ul>
        </li>
    @else
        <li class="list-group-item"></li>
    @endif

</ul>
<div>notify</div>
<ul class="list-group">
    @if(!empty($taskObject->NotifyContentArray))
        @foreach($taskObject->NotifyContentArray as $key => $item)
            <li class="list-group-item">
                <span class="badge">
                    {{ $key }}
                </span>
                @if(is_array($item))
                    @foreach($item as $value)
                        {{ $value }},
                    @endforeach
                @else
                    {{ $item or '' }}
                @endif
            </li>
        @endforeach
    @else
        <li class="list-group-item"></li>
    @endif
</ul>