<ul class="list-group">
    <li class="list-group-item">
        <span class="badge">
            Id
        </span>
        {{ $attributeInfo->Id or ''}}
    </li>
    <li class="list-group-item">
        <span class="badge">
            Category
        </span>
        {{ $attributeInfo->category->Alias or '' }}({{ $attributeInfo->category->Id or '' }})
    </li>
    <li class="list-group-item">
        <span class="badge">
            Name
        </span>
        {{ $attributeInfo->Name or '' }}
    </li>
    <li class="list-group-item">
        <span class="badge">
            Alias
        </span>
        {{ $attributeInfo->Alias or '' }}
    </li>
    <li class="list-group-item">
        <span class="badge">
            ContentType
        </span>
        {{ $attributeInfo->ContentType or '' }}
    </li>
    <li class="list-group-item">
        <span class="badge">
            DefaultMessage
        </span>
        {{ $attributeInfo->DefaultMessage or '' }}
    </li>
    <li class="list-group-item">
        <span class="badge">
            Status
        </span>
        {{ $attributeInfo->Status or '' }}
    </li>
    <li class="list-group-item">
        <span class="badge">
            AddTime
        </span>
        {{ $attributeInfo->AddTime or '' }}
    </li>
    <li class="list-group-item">
        <span class="badge">
            UpdateTime
        </span>
        {{ $attributeInfo->UpdateTime or '' }}
    </li>
</ul>