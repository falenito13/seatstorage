<ul class="sidebar-nav">

    <li class="sidebar-header">
        <span class="sidebar-header-options clearfix"><a href="javascript:void(0)" data-toggle="tooltip" title="" data-original-title="Filter"></a></span>
        <span class="sidebar-header-title">Tools</span>
    </li>
    <!-- Show text module menu, if user can show this. -->
    @can ( getPermissionKey('text', 'create', true))
        <li
            {!! strpos(request()->route()->getName(), 'admin.text.') !== false ? ' class="active"' : '' !!}>
            <a href="{{route('admin.text.index')}}"><i class="el-icon-scissors sidebar-nav-icon"></i>
                <span class="sidebar-nav-mini-hide">@lang('admin.text.menu')</span></a>
        </li>

    @endif

    @can ( getPermissionKey('user', 'create', true))
        <li
            {!! strpos(request()->route()->getName(), 'admin.user.') !== false ? ' class="active"' : '' !!}>
            <a href="{{route('admin.user.index')}}"><i class="el-icon-user sidebar-nav-icon"></i>
                <span class="sidebar-nav-mini-hide">@lang('admin.user.menu')</span></a>
        </li>

    @endif

    @can ( getPermissionKey('role', 'create', true))
        <li
            {!! strpos(request()->route()->getName(), 'admin.role.') !== false ? ' class="active"' : '' !!}>
            <a href="{{route('admin.role.index')}}"><i class="el-icon-thumb sidebar-nav-icon"></i>
                <span class="sidebar-nav-mini-hide">@lang('admin.role.menu')</span></a>
        </li>

    @endif


</ul>
