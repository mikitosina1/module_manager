@php
    use Nwidart\Modules\Module;
    use Modules\ModuleManager\App\Services\ModuleAdminActionRegistrar;

    $assets = Module::getAssets();
    $moduleAssets = array_filter($assets, function ($asset) {
        return str_contains($asset, 'Modules/ModuleManager');
    });
@endphp

@foreach ($moduleAssets as $asset)
    @vite($asset)
@endforeach

<div class="cloud">
    <div class="dark:bg-gray-900 shadow sm:rounded-lg mt-8 module-manager-block">
        <h1 class="dark:text-gray-300 header">@lang('modulemanager::module_manager_lang.manage_modules'):</h1>
        @if(!empty(isset($modules)))
            <div class="modules-container">
                @foreach($modules as $module)
                    @php
                        $moduleName = $module->getName();
                        $moduleActions = $adminActions[$moduleName] ?? $module->get('admin_actions', []);
                    @endphp
                    @if($moduleName != 'ModuleManager')
                        <div class="module-item">
                            <div class="module-row-main">
                                <h4 class="dark:text-gray-300 module-header"
                                    title="{{ $moduleName }}">{{ $moduleName }}
                                </h4>
                                <label class="switch">
                                    <input type="checkbox"
                                           onchange="toggleModule('{{ $moduleName }}',
                                            this.checked ? 'enable' : 'disable')"
                                        {{ $module->isEnabled() ? 'checked' : '' }}>
                                    <span class="slider"></span>
                                </label>
                            </div>
                            <div class="module-row-actions">
                                @if(!empty($moduleActions))
                                    <div class="dropdown">
                                        <button class="dropdown-toggle dark:text-gray-300">
                                            @lang('modulemanager::module_manager_lang.admin_actions')
                                        </button>
                                        <div class="dropdown-menu">
                                            @foreach($moduleActions as $action)
                                                <a href="{{ route($action['route']) }}"
                                                   class="dropdown-item dark:text-gray-300">
                                                    {!! $action['icon'] ?? '' !!} @lang($action['label'])
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                                <a href="javascript:void(0);" class="delete-module dark:text-gray-300"
                                   data-module-name="{{ $moduleName }}">
                                    @lang('modulemanager::module_manager_lang.delete_module_btn')
                                </a>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        @endif
    </div>
</div>
<meta name="csrf-token" content="{{ csrf_token() }}">
