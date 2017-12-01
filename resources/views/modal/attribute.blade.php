<ul class="list-group">
    <li class="list-group-item">
        <span class="badge">
            Id
        </span>
        {{ $attributeObject->Id or '' }}
    </li>
    <li class="list-group-item">
        <span class="badge">
            Category
        </span>
        {{ $attributeObject->category->Alias or '' }}({{ $attributeObject->category->Id or '' }})
    </li>
    <li class="list-group-item">
        <span class="badge">
            Name
        </span>
        {{ $attributeObject->Name or '' }}
    </li>
    <li class="list-group-item">
        <span class="badge">
            Alias
        </span>
        {{ $attributeObject->Alias or '' }}
    </li>
    <li class="list-group-item">
        <span class="badge">
            ContentType
        </span>
        {{ $attributeObject->ContentType or '' }}
    </li>
    <li class="list-group-item">
        <span class="badge">
            DefaultMessage
        </span>
        {{ $attributeObject->DefaultMessage or '' }}
    </li>
    <li class="list-group-item">
        <span class="badge">
            Status
        </span>
        {{ $attributeObject->Status or '' }}
    </li>
    <li class="list-group-item">
        <span class="badge">
            AddTime
        </span>
        {{ $attributeObject->AddTime or '' }}
    </li>
    <li class="list-group-item">
        <span class="badge">
            UpdateTime
        </span>
        {{ $attributeObject->UpdateTime or '' }}
    </li>
</ul>