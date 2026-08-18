{{-- Add this block into resources/views/admin/layouts/header.blade.php,
     right after the existing "All Enquiries" <li> block (around line 193). --}}

@if($roleId == config('constants.roles.admin'))
<li class="sidebar-menu__item {{ Request::is('admin/agents*') ? 'activePage' : '' }}">
    <a href="{{ route('agents.index') }}" class="sidebar-menu__link">
        <span class="icon"><i class="ph ph-users-three"></i></span>
        <span class="text">Agents</span>
    </a>
</li>
@endif
