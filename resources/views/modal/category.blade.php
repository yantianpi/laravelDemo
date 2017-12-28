<ul class="list-group">
    <li class="list-group-item">
        <span class="badge">
            Id
        </span>
        {{ $dataObject->Id or '' }}
    </li>
    <li class="list-group-item">
        <span class="badge">
            Name
        </span>
        {{ $dataObject->Name or '' }}
    </li>
    <li class="list-group-item">
        <span class="badge">
            Alias
        </span>
        {{ $dataObject->Alias or '' }}
    </li>
    <li class="list-group-item">
        <span class="badge">
            Script
        </span>
        {{ $dataObject->Script or '' }}
    </li>
    <li class="list-group-item">
        <span class="badge">
            Status
        </span>
        {{ $dataObject->Status or '' }}
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