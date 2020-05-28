<ul class="sidebar-nav">

    <!-- Show text module menu, if user can show this. -->
    @can ( getPermissionKey('text', 'create', true))
        <li
            {!! strpos(request()->route()->getName(), 'admin.text.') !== false ? ' class="active"' : '' !!}>
            <a href="{{route('admin.text.index')}}"><i class="fa fa-mountain sidebar-nav-icon"></i>
                <span class="sidebar-nav-mini-hide">@lang('admin.text.menu')</span></a>
        </li>

    @endif

    @can ( getPermissionKey('user', 'create', true))
        <li
            {!! strpos(request()->route()->getName(), 'admin.user.') !== false ? ' class="active"' : '' !!}>
            <a href="{{route('admin.user.index')}}"><i class="fa fa-mountain sidebar-nav-icon"></i>
                <span class="sidebar-nav-mini-hide">@lang('admin.user.menu')</span></a>
        </li>

    @endif

    @can ( getPermissionKey('role', 'create', true))
        <li
            {!! strpos(request()->route()->getName(), 'admin.role.') !== false ? ' class="active"' : '' !!}>
            <a href="{{route('admin.role.index')}}"><i class="fa fa-mountain sidebar-nav-icon"></i>
                <span class="sidebar-nav-mini-hide">@lang('admin.role.menu')</span></a>
        </li>

    @endif


</ul>
