@vite(\Nwidart\Modules\Module::getAssets()[0])
@vite(\Nwidart\Modules\Module::getAssets()[1])
<div class="cloud">
	<div class="dark:bg-gray-800 shadow sm:rounded-lg mt-8 module-manager-block">
		<h1 class="dark:text-gray-300 header">@lang('modulemanager::module_manager_lang.manage_modules'):</h1>
		@if(!empty(isset($modules)))
			<ul>
				@foreach($modules as $module)
					@if($module->getName() != 'ModuleManager')
						<li class="mb-3 d-flex align-items-center justify-content-between module_line">
							<h4 class="dark:text-gray-300 module-header" title="{{ $module->getName() }}">{{ $module->getName() }}</h4>
							<label class="switch">
								<input type="checkbox"
									   onchange="toggleModule('{{ $module->getName() }}', this.checked ? 'enable' : 'disable')"
									{{ $module->isEnabled() ? 'checked' : '' }}>
								<span class="slider"></span>
							</label>
							<a href="javascript:void(0);" class="delete-module dark:text-gray-300" data-module-name="{{ $module->getName() }}">@lang('modulemanager::module_manager_lang.delete_module_btn')</a>

						</li>
					@endif
				@endforeach
			</ul>
		@endif
	</div>
</div>
<meta name="csrf-token" content="{{ csrf_token() }}">
