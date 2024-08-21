.PHONY: setup composer clean setup-ddev composer-ddev vite-ddev
setup: composer vite
setup-ddev: composer-ddev vite-ddev

composer: ## Run composer dependencies
	composer dumpautoload

vite: ## Compile js, css
	npm run build

composer-ddev: ## Composer stuff with using ddev on local
	ddev exec composer dumpautoload

vite-ddev: ## Compile js, css with using ddev
	ddev exec npm run build
