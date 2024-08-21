@vite(\Nwidart\Modules\Module::getAssets())
<div class="cloud">
	<div class="content-block dark:bg-gray-800 shadow sm:rounded-lg mt-8">
		<h1 class="dark:text-gray-300">@lang('dashboard.manage_modules'):</h1>
		@if(!empty(isset($modules)))
			<ul>
				@foreach($modules as $module)
					<li class="mb-3 d-flex align-items-center justify-content-between module_line">
						<h4 class="dark:text-gray-300 module-header" title="{{ $module->getName() }}">{{ $module->getName() }}</h4>
						<label class="switch">
							<input type="checkbox"
								   onchange="toggleModule('{{ $module->getName() }}', this.checked ? 'enable' : 'disable')"
								{{ $module->isEnabled() ? 'checked' : '' }}>
							<span class="slider"></span>
						</label>
					</li>
				@endforeach
			</ul>
		@endif
	</div>
</div>
<meta name="csrf-token" content="{{ csrf_token() }}">
