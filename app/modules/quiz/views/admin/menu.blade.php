<li class="submenu">
    <a href="{{ route("admin.{$moduleLower}.index") }}">
        <i class="fa fa-question-circle"></i>
        <span>{{ $moduleUpper }}</span>
        <i class="arrow fa fa-chevron-right"></i>
    </a>
    <ul>
        <li><a href="{{ route("admin.{$moduleLower}.index") }}">List</a></li>
        <li><a href="{{ route("admin.{$moduleLower}.create") }}">Create</a></li>
    </ul>
</li>
