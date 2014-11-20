<li class="submenu">
    <a href="{{ route("admin.{$moduleLower}.index") }}">
        <i class="fa fa-database"></i>
        <span>{{ $moduleUpper }}</span>
        <i class="arrow fa fa-chevron-right"></i>
    </a>
    <ul>
        <li><a href="{{ route("admin.{$moduleLower}.index") }}">List</a></li>
        <li><a href="#">Create</a></li>
    </ul>
</li>
