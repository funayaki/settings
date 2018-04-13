# Settings plugin for CakePHP 3.x

CakePHP database driven settings plugin.

## Requirements

- CakePHP 3.x
- FriendsOfCake/search (see https://github.com/FriendsOfCake/search)
- ADmad/cakephp-sequence (see https://github.com/ADmad/cakephp-sequence)

```shell
composer require friendsofcake/search
composer require admad/cakephp-sequence
```

## Installation

_[Manual]_

* Download and unzip the repo (see the download button somewhere on this git page)
* Copy the resulting folder into `plugins`
* Rename the folder you just copied to `Settings`

_[GIT Submodule]_

In your `app` directory type:

```shell
git submodule add -b master git://github.com/funayaki/settings.git plugins/Settings
git submodule init
git submodule update
```

_[GIT Clone]_

In your `plugins` directory type:

```shell
git clone -b master git://github.com/funayaki/settings.git Settings
```

### Enable plugin

In 3.0 you need to enable the plugin your `config/bootstrap.php` file:

```php
Plugin::load('Settings', ['bootstrap' => true, 'routes' => true, 'autoload' => true]);
```

### Running migrations

```shell
./bin/cake migrations migrate --plugin Settings
```

### Inserting data (Optinal)

```shell
./bin/cake migrations seed --plugin Settings
```

## Visit settings using browser

Visit `/admin/settings/settings/` using browser.
