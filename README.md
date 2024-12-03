<p align="center">
  <a href="https://roots.io/bedrock/">
    <img alt="Bedrock" src="https://cdn.roots.io/app/uploads/logo-bedrock.svg" height="100">
  </a>
</p>

<p align="center">
  <a href="https://packagist.org/packages/roots/bedrock">
    <img alt="Packagist Installs" src="https://img.shields.io/packagist/dt/roots/bedrock?label=projects%20created&colorB=2b3072&colorA=525ddc&style=flat-square">
  </a>

  <a href="https://packagist.org/packages/roots/wordpress">
    <img alt="roots/wordpress Packagist Downloads" src="https://img.shields.io/packagist/dt/roots/wordpress?label=roots%2Fwordpress%20downloads&logo=roots&logoColor=white&colorB=2b3072&colorA=525ddc&style=flat-square">
  </a>
  
  <img src="https://img.shields.io/badge/dynamic/json.svg?url=https://raw.githubusercontent.com/roots/bedrock/master/composer.json&label=wordpress&logo=roots&logoColor=white&query=$.require[%22roots/wordpress%22]&colorB=2b3072&colorA=525ddc&style=flat-square">

  <a href="https://github.com/roots/bedrock/actions/workflows/ci.yml">
    <img alt="Build Status" src="https://img.shields.io/github/actions/workflow/status/roots/bedrock/ci.yml?branch=master&logo=github&label=CI&style=flat-square">
  </a>

  <a href="https://twitter.com/rootswp">
    <img alt="Follow Roots" src="https://img.shields.io/badge/follow%20@rootswp-1da1f2?logo=twitter&logoColor=ffffff&message=&style=flat-square">
  </a>
</p>

<p align="center">WordPress boilerplate with Composer, easier configuration, and an improved folder structure</p>

<p align="center">
  <a href="https://roots.io/bedrock/">Website</a> &nbsp;&nbsp; <a href="https://roots.io/bedrock/docs/installation/">Documentation</a> &nbsp;&nbsp; <a href="https://github.com/roots/bedrock/releases">Releases</a> &nbsp;&nbsp; <a href="https://discourse.roots.io/">Community</a>
</p>

## Sponsors

Bedrock is an open source project and completely free to use. If you've benefited from our projects and would like to support our future endeavors, please consider [sponsoring Roots](https://github.com/sponsors/roots).

<div align="center">
<a href="https://k-m.com/"><img src="https://cdn.roots.io/app/uploads/km-digital.svg" alt="KM Digital" width="120" height="90"></a> <a href="https://carrot.com/"><img src="https://cdn.roots.io/app/uploads/carrot.svg" alt="Carrot" width="120" height="90"></a> <a href="https://wordpress.com/"><img src="https://cdn.roots.io/app/uploads/wordpress.svg" alt="WordPress.com" width="120" height="90"></a> <a href="https://worksitesafety.ca/careers/"><img src="https://cdn.roots.io/app/uploads/worksite-safety.svg" alt="Worksite Safety" width="120" height="90"></a> <a href="https://www.copiadigital.com/"><img src="https://cdn.roots.io/app/uploads/copia-digital.svg" alt="Copia Digital" width="120" height="90"></a> <a href="https://www.freave.com/"><img src="https://cdn.roots.io/app/uploads/freave.svg" alt="Freave" width="120" height="90"></a>
</div>

## Overview

Bedrock is a WordPress boilerplate for developers that want to manage their projects with Git and Composer. Much of the philosophy behind Bedrock is inspired by the [Twelve-Factor App](http://12factor.net/) methodology, including the [WordPress specific version](https://roots.io/twelve-factor-wordpress/).

- Better folder structure
- Dependency management with [Composer](https://getcomposer.org)
- Easy WordPress configuration with environment specific files
- Environment variables with [Dotenv](https://github.com/vlucas/phpdotenv)
- Autoloader for mu-plugins (use regular plugins as mu-plugins)
- Enhanced security (separated web root and secure passwords with [wp-password-bcrypt](https://github.com/roots/wp-password-bcrypt))

## Getting Started

**Предварительные требования:**

* Установленный PHP версии 8.2.

* Установленный глобально composer.

**Последовательность действий:**

Создаем папку для проекта

Открываем ее в любом удобном терминале

Создаем проект командой:

```
composer create-project vyatka-it/vyatka-wp .
```

>Внимание! Точка в конце команду важна, так как нужно развернуть проект в корень папки.


Устанавливаем зависимости, для этого, в корне папки проекта запускаем команду:

```
composer install
```

Переходим в папку web/resources (здесь лежит gulp)

```
cd web/resources
```

Устанавливаем зависимости для сборщика gulp.

```
npm install
```

>После установки можно проверить и запустить из этой папки Gulp

Переходим в папку с темой web/app/themes/vyatka-it-wp-theme

```
cd ../app/themes/vyatka-it-wp-theme
```

и запускаем

```
composer install
```

Создаем базу данных для проекта любым удобным образом.

Возвращаемся в корень проекта создаем файл .env из файла .env.example путем копирования

```
cd ../../../../
```

```
cp .env.example .env
```

Открываем файл в любом удобном редакторе

Например VS code
```
code -r .env
```


Или nano.

```
nano .env
```

>После внесения изменений сохранить CTRL\+S и выход CTRL\+X

Вносим в файл .env данные для подключения к базе данных и имя сайта

Добавляем в OpenServer домен с именем как в переменной WP_HOME, но путь указываем до папки web

Открываем сайт и прогружаем wordpress следуя визарду как обычно.

Заходим в админку сайта.

Переходим в закладку плагины и активируем все плагины.

Переходим в Внешний вид -\> Темы и активируем тему.

>Внимание! Если в проекте планируется использовать Woocommerce, то в первую очередь нужно установить и активировать плагин woocommerce на стандартной теме wordpress. И только после этого активировать кастомную тему. В противном случае, вероятнее всего, woocommerce активируется на английском языке и переключить его не получиться.

Переходим в страницы и создаем Главную страницу с уже существующим шаблоном Главная страница.

Переходим в Настройки –\> Чтение и устанавливаем статическую страницу – Главная страница.

Поздравляю!

Сайт готов к разработке и к использованию git.

Ссылки на технологии, использованные в сборке, там есть документация:

​[Twig](https://twig.symfony.com/).

​[Timber](https://timber.github.io/docs/v2/).

​[Bedrock](https://roots.io/bedrock/).

​[Wordpress API](https://developer.wordpress.org/rest-api/).

​[Репозиторий проекта(для Pull Request)](https://github.com/Snooper7/bedrock_timber_vyatka_it).

Пакет на [packagist](https://packagist.org/packages/snooper7/perfectwp).


