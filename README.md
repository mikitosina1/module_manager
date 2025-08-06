## Module Manager by <span style="color:#008066;">@mikitosina1</span>

#### Widget UI, to manage modules in Laravel 10<br><hr>

![image](https://github.com/user-attachments/assets/f640f944-bc35-4fe9-acc3-13a931be421e)

<hr>

#### <div style="color:#FFA500FF;"> Working now only with nwidart/laravel-modules & vite</div>

<div style="color: cadetblue"> To install and test:</div>
<ul>
	<li> download from git to your projects <b style="color: #FFA500FF">/Modules</b> folder. </li>
	<li> change/create file in root of project 'vite.config.js'

```js
	const allPaths = await collectModuleAssetsPaths(paths, 'Modules');

	return defineConfig({
		plugins: [
			laravel({
				input: allPaths,
				refresh: true,
			})
		]
	});
``` 

</li>
	<li> inside you will find Makefile — you have there 2 options:
		<ul>
			<li> If you work on <span style="color:#ADD8E6FF">local</span> with <b>ddev</b>, run <b style="color:#90EE90FF">make setup-ddev</b>  </li>
			<li> Another case, on <span style="color:#ADD8E6FF">server</span> <b style="color:#90EE90FF">make setup</b> </li>
		</ul>
	</li>
	<li>In case, if something will not work (suppose not, but) Run commands Manually:
		<ul>
			<li>Composers command in folder of module </li>
			<li>run: php artisan module:enable ModuleManager</li>
			<li>Vite's command in root folder </li>
		</ul>
	</li>
</ul>

## Full root vite.config.js example:

```js
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import collectModuleAssetsPaths from './vite-module-loader.js';

async function getConfig() {
	const paths = [
		// css
		'resources/css/app.css',
        //...

		// js
		'resources/js/app.js',
        //...
	];
	const allPaths = await collectModuleAssetsPaths(paths, 'Modules');

	return defineConfig({
		plugins: [
			laravel({
				input: allPaths,
				refresh: true,
			})
		]
	});
}

export default getConfig();

```
