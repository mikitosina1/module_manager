<div class="nav-link-div">
    <x-nav-link :href="route('module.index')" :active="request()->routeIs('module.index')">
        @lang('modulemanager::module_manager_lang.manage_modules')
    </x-nav-link>
</div>
