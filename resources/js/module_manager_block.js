import axios from 'axios';
import $ from 'jquery';

window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.$ = $;

window.toggleModule = function (moduleName, action) {
	const url = action === 'enable' ? '/module/enable' : '/module/disable';
	console.log(url);

	fetch(url, {
		method: 'POST',
		headers: {
			'Content-Type': 'application/json',
			'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
		},
		body: JSON.stringify({module: moduleName})
	})
		.then(response => response.json())
		.then(data => {
			alert(data.message);
			location.reload();
		})
		.catch(error => console.error('Error:', error));
}

window.deleteModule = function (moduleName) {
	fetch('/module/delete', {
		method: 'POST',
		headers: {
			'Content-Type': 'application/json',
			'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
		},
		body: JSON.stringify({ module: moduleName })
	})
		.then(response => response.json())
		.then(data => {
			alert(data.message);
			location.reload();
		})
		.catch(error => console.error('Error:', error));
}

// event listener for delete
document.addEventListener('DOMContentLoaded', function () {
	document.querySelectorAll('.delete-module').forEach(button => {
		button.addEventListener('click', function (e) {
			e.preventDefault();
			const moduleName = this.getAttribute('data-module-name');
			window.deleteModule(moduleName);
		});
	});
});
