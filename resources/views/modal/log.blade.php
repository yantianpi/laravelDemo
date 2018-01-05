<ul class="list-group">
    <li class="list-group-item">
        <span class="badge">
            Id
        </span>
        {{ $dataObject->Id or '' }}
    </li>
    <li class="list-group-item">
        <span class="badge">
            MapId
        </span>
        {{ $dataObject->MapId or '' }}
    </li>
    <li class="list-group-item">
        <span class="badge">
            LogType
        </span>
        {{ $dataObject->LogType or '' }}
    </li>
    <li class="list-group-item">
        <span class="badge">
            Program
        </span>
        {{ $dataObject->Program or '' }}
    </li>
    <li class="list-group-item">
        <span class="badge">
            Keyword
        </span>
        {{ $dataObject->Keyword or '' }}
    </li>
    <li class="list-group-item">
        <span class="badge">
            Content
        </span>
        {{ $dataObject->Content or '' }}
    </li>
    <li class="list-group-item">
        <span class="badge">
            HasAlert
        </span>
        {{ $dataObject->HasAlert or '' }}
    </li>
    <li class="list-group-item">
        <span class="badge">
            AddTime
        </span>
        {{ $dataObject->AddTime or '' }}
    </li>
    <li class="list-group-item">
        <span class="badge">
            UpdateTime
        </span>
        {{ $dataObject->UpdateTime or '' }}
    </li>
</ul>