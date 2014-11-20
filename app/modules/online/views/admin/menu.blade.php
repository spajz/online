<li class="submenu">
    <a href="{{ route("admin.{$moduleAdminRoute}.index") }}">
        <i class="fa fa-star-o"></i>
        <span>{{ $moduleUpper }}</span>
        <i class="arrow fa fa-chevron-right"></i>
    </a>
    <ul>
        <li><a href="{{ route("admin.{$moduleAdminRoute}.index") }}">List</a></li>
        <li><a href="{{ route("admin.{$moduleAdminRoute}.create") }}">Create</a></li>
    </ul>
</li>
<?php
$subModules = Config::get("{$moduleLower}::subModules.category");
?>
<li class="submenu">
    <a href="{{ route("admin.{$subModules['moduleAdminRoute']}.index") }}">
        <i class="fa fa-star-o"></i>
        <span>{{ $subModules['moduleTitle'] }}</span>
        <i class="arrow fa fa-chevron-right"></i>
    </a>
    <ul>
        <li><a href="{{ route("admin.{$subModules['moduleAdminRoute']}.index") }}">List</a></li>
        <li><a href="{{ route("admin.{$subModules['moduleAdminRoute']}.create") }}">Create</a></li>
        <li><a href="{{ route("admin.{$subModules['moduleAdminRoute']}.order") }}">Order</a></li>
    </ul>
</li>
