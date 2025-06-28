#--- MAKEFILE HAPPYVISIO -----------#
#-----------------------------------#

#------------ VARIABLES ------------#
#--- DOCKER ---#
DOCKER = docker
DOCKER_RUN = $(DOCKER) run
DOCKER_COMPOSE = docker compose
DOCKER_COMPOSE_UP = $(DOCKER_COMPOSE) up -d
DOCKER_COMPOSE_STOP = $(DOCKER_COMPOSE) stop

#--- SYMFONY ---#
SYMFONY = symfony
SYMFONY_CONSOLE = $(SYMFONY) console
SYMFONY_LINT = $(SYMFONY_CONSOLE) lint:

#--- COMPOSER ---#
COMPOSER = composer
COMPOSER_INSTALL = $(COMPOSER) install
COMPOSER_UPDATE = $(COMPOSER) update

#--- YARN ---#
YARN = yarn
YARN_INSTALL = $(YARN) install
YARN_UPDATE = $(YARN) update
YARN_BUILD = $(YARN) build
YARN_DEV = $(YARN) dev
YARN_WATCH = $(YARN) watch

#--- PHP TOOLS ---#
PHPUNIT = APP_ENV=test $(SYMFONY) php bin/phpunit
PHPCSFIXER = ./php-cs-fixer
PHPSTAN = vendor/bin/phpstan
PHPCS = vendor/bin/phpcs
PHPCBF = vendor/bin/phpcbf
PHPCPD = php phpcpd.phar
PHPMETRICS = php ./vendor/bin/phpmetrics

## === 🆘  AIDE ==================================================
help: ## Affiche cette aide.
	@echo "MAKEFILE HappyVisio"
	@echo "---------------------------"
	@echo "Usage: make [cible]"
	@echo ""
	@echo "Cibles :"
	@grep -E '(^[a-zA-Z0-9_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}{printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'
#---------------------------------------------#

## === 🐋  DOCKER ================================================
docker-up: ## Lance les conteneurs Docker.
	$(DOCKER_COMPOSE_UP)
.PHONY: docker-up

docker-stop: ## Arrête les conteneurs Docker.
	$(DOCKER_COMPOSE_STOP)
.PHONY: docker-stop
#---------------------------------------------#

## === 🎛️  SYMFONY ===============================================
sf: ## Liste et utilise toutes les commandes Symfony (make sf command="commande-name").
	$(SYMFONY_CONSOLE) $(command)
.PHONY: sf

sf-cc: ## Vide le cache Symfony.
	$(SYMFONY_CONSOLE) cache:clear
.PHONY: sf-cc

sf-su: ## Mise à jour du schéma de la base de données.
	$(SYMFONY_CONSOLE) doctrine:schema:update --force
.PHONY: sf-su

sf-mm: ## Créé les migrations.
	$(SYMFONY_CONSOLE) make:migration
.PHONY: sf-mm

sf-dmm: ## Lance les migrations.
	$(SYMFONY_CONSOLE) doctrine:migrations:migrate --no-interaction
.PHONY: sf-dmm

sf-dmm-test: ## Lance les migrations.
	$(SYMFONY_CONSOLE) doctrine:migrations:migrate --no-interaction --env=test
.PHONY: sf-dmm-test

sf-fixtures: ## Charge les fixtures.
	$(SYMFONY_CONSOLE) doctrine:fixtures:load --no-interaction --purge-with-truncate
.PHONY: sf-fixtures

sf-fixtures-test: ## Charge les fixtures.
	$(SYMFONY_CONSOLE) doctrine:fixtures:load --no-interaction --purge-with-truncate --env=test
.PHONY: sf-fixtures-test

sf-me: ## Créé une nouvelle entité
	$(SYMFONY_CONSOLE) make:entity
.PHONY: sf-me

sf-mc: ## Créé un nouveau controller
	$(SYMFONY_CONSOLE) make:controller
.PHONY: sf-mc

sf-mf: ## Créé un nouveau formulaire
	$(SYMFONY_CONSOLE) make:form
.PHONY: sf-mf

sf-perm: ## Règle les permissions.
	chmod -R 777 var
.PHONY: sf-perm

sf-sudo-perm: ## Règle les permissions avec sudo.
	sudo chmod -R 777 var
.PHONY: sf-sudo-perm

sf-dump-routes: ## Affiche les routes.
	$(SYMFONY_CONSOLE) debug:router
.PHONY: sf-dump-routes

sf-check-requirements: ## Vérifie les pré-requis.
	$(SYMFONY) check:requirements
.PHONY: sf-check-requirements
#---------------------------------------------#

## === 📦  COMPOSER ==============================================
composer-install: ## Installe les dépendances Composer.
	$(COMPOSER_INSTALL)
.PHONY: composer-install

composer-update: ## Mise à jour des dépendances Composer.
	$(COMPOSER_UPDATE)
.PHONY: composer-update

composer-validate: ## Valide le fichier composer.json.
	$(COMPOSER) validate
.PHONY: composer-validate

composer-validate-deep: ## Valide les fichiers composer.json et composer.lock en mode strict.
	$(COMPOSER) validate --strict --check-lock
.PHONY: composer-validate-deep
#---------------------------------------------#

## === 📦  YARN ===================================================
yarn-install: ## Installe les dépendances YARN.
	$(YARN_INSTALL)
.PHONY: yarn-install

yarn-update: ## Mise à jour des dépendances YARN.
	$(YARN_UPDATE)
.PHONY: yarn-update

yarn-build: ## Construit les assets.
	$(YARN_BUILD)
.PHONY: yarn-build

yarn-dev: ## Construit les assets en mode dev.
	$(YARN_DEV)
.PHONY: yarn-dev

yarn-watch: ## Construit les assets en mode watch.
	$(YARN_WATCH)
.PHONY: yarn-watch
#---------------------------------------------#

## === 🐛  QA =================================================
qa-cs-fixer-dry-run: ## Lance php-cs-fixer en mode dry-run.
	$(PHPCSFIXER) fix ./src --rules=@Symfony --verbose --dry-run
.PHONY: qa-cs-fixer-dry-run

qa-cs-fixer: ## Lance php-cs-fixer.
	$(PHPCSFIXER) fix ./src --rules=@Symfony --verbose
.PHONY: qa-cs-fixer

qa-phpstan: ## Lance phpstan.
	$(PHPSTAN) analyse ./src --configuration phpstan.neon
.PHONY: qa-phpstan

qa-phpcs: ## Lance phpcs sur le répertoire src
	$(PHPCS) --standard=PSR12 ./src
.PHONY: qa-phpcs

qa-phpcbf: ## Lance phpcbf sur le répertoire src
	$(PHPCBF) --standard=PSR12 ./src
.PHONY: qa-phpcbf

qa-security-checker: ## Lance security-checker de Symfony.
	$(SYMFONY) security:check
.PHONY: qa-security-checker

qa-phpcpd: ## Lance phpcpd (Détéction de copier/coller).
	$(PHPCPD) ./src --exclude=./src/Entity
.PHONY: qa-phpcpd

qa-php-metrics: ## Lance php-metrics.
	$(PHPMETRICS) --report-html=var/phpmetrics ./src
.PHONY: qa-php-metrics

qa-lint-twigs: ## Lint les fichiers twig.
	$(SYMFONY_LINT)twig ./templates
.PHONY: qa-lint-twigs

qa-lint-yaml: ## Lint les fichiers yaml.
	$(SYMFONY_LINT)yaml ./config
.PHONY: qa-lint-yaml

qa-lint-container: ## Lint les containers.
	$(SYMFONY_LINT)container
.PHONY: qa-lint-container

qa-lint-schema: ## Lint le schéma Doctrine.
	$(SYMFONY_CONSOLE) doctrine:schema:validate -vvv --no-interaction
.PHONY: qa-lint-schema

qa-audit: ## Lance l'audit Composer.
	$(COMPOSER) audit
.PHONY: qa-audit
#---------------------------------------------#

## === 🔎  TESTS =================================================
tests: ## Lance les tests.
	$(PHPUNIT) --testdox
.PHONY: tests

tests-coverage: ## Lance les tests avec rapport de couverture.
	$(PHPUNIT) --coverage-html var/coverage
.PHONY: tests-coverage
#---------------------------------------------#

## === ⭐  OTHERS =================================================
before-commit: qa-phpstan qa-phpcs qa-phpcbf qa-security-checker qa-lint-twigs qa-lint-yaml qa-lint-container qa-lint-schema tests ## A lancer avant de commiter.
.PHONY: before-commit

first-install: composer-install yarn-install yarn-build sf-perm sf-dmm ## Première installation du projet.
.PHONY: first-install

start: docker-up ## Lance le projet.
.PHONY: start

stop: docker-stop ## Arrête le projet.
.PHONY: stop

deploy: composer-install sf-dmm sf-cc yarn-install yarn-build ## Lance le déploiement du projet
.PHONY: deploy
#---------------------------------------------#