<ul class="list-group">
    @foreach($dataObject as $item)
        <li class="list-group-item">
            <span class="badge">
                <a target="_blank" href="{{ route('attributepage') . "?formData[Id]=" . $item->Id }}">go</a>
            </span>
            {{ $item->Name or '' }} - {{ $item->Alias or '' }} ({{ $item->Id or '' }})
        </li>
    @endforeach
</ul>