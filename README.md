# Laravel Activity Logger

[![Latest Stable Version](https://poser.pugx.org/novay/log-module/v/stable)](https://packagist.org/packages/novay/log-module)
[![Total Downloads](https://poser.pugx.org/novay/log-module/downloads)](https://packagist.org/packages/novay/log-module)
[![Travis-CI Build](https://travis-ci.org/novay/log-module.svg?branch=master)](https://travis-ci.org/novay/log-module)
<a href="https://styleci.io/repos/109630720">
    <img src="https://styleci.io/repos/109630720/shield?branch=master" alt="StyleCI" style="border-radius: 3px;">
</a>
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)

Table of contents:
- [About](#about)
- [Requirements](#requirements)
- [Installation Instructions](#installation-instructions)
- [Usage](#usage)
- [Features](#features)
- [Screenshots](#screenshots)
- [License](#license)

### About
[This module](https://packagist.org/packages/novay/log-module) is an activity event logger for your Laravel application. It comes out the box with ready to use with dashboard to view your activity. Laravel logger can be added as a middleware or called through a trait. Easily have an Activity Log. This package is easily configurable and customizable. Supports Laravel 5.3, 5.4, 5.5, 5.6, 5.7, 5.8 and 6+.

### Requirements
* [Laravel 5.2, 5.3, 5.4, 5.5, 5.6, 5.7, 5.8, 6+](https://laravel.com/docs/installation)
* [Modules by nwidart](https://github.com/nwidart/laravel-modules)
* [Modules Installer by joshbrw](https://github.com/joshbrw/laravel-module-installer)

### Installation Instructions
1. Install Package Via Composer

```
composer require novay/log-module
```

2. Migrate

```
php artisan module:migrate Log
```

3. Configuration (Next Step)

> This file config can be found on `Module\Config\config.php`. You can enable/disable this module directly from there.

### Usage

##### Middleware Usage
Events for laravel authentication scaffolding are listened for as providers and are enabled via middleware.
You can add events to your routes and controllers via the middleware:

```php
activity
```

Example to start recording page views using middlware in `web.php`:

```php
Route::group(['middleware' => ['web', 'activity']], function () {
    Route::get('/', 'WelcomeController@welcome')->name('welcome');
});
```

> This middlware can be enabled/disabled in the configuration settings.

##### Trait Usage
Events can be recorded directly by using the trait.
When using the trait you can customize the event description.

To use the trait:
1. Include the call in the head of your class file:

```php
<?php

namespace ...

use ActivityLogger;

class ...
```

2. Include the trait call in the opening of your class:

```php
<?php

class ExampleController extends Controller {
    use ActivityLogger;
    
    ...
}
```

3. You can record the activity by calling the traits method:

```
    ActivityLogger::activity("Logging this activity.");
```

### Features

| Log Activity Features  |
| :------------ |
|Logs login page visits|
|Logs user logins|
|Logs user logouts|
|Routing Events can recording using middleware|
|Records activity timestamps|
|Records activity description|
|Records activity user type with crawler detection.|
|Records activity Method|
|Records activity Route|
|Records activity Ip Address|
|Records activity User Agent|
|Records activity Browser Language|
|Records activity referrer|
|Activity panel dashboard|
|Individual activity drilldown report dashboard|
|Activity Drilldown looks up Id Address meta information|
|Activity Drilldown shows user roles if enabled|
|Activity Drilldown shows associated user events|
|Activity log can be cleared, restored, and destroyed using eloquent softdeletes|
|Cleared activity logs can be viewed and have drilldown ability|
|Uses font awesome & cdn assets online|
|Uses [Geoplugin API](http://www.geoplugin.com/) for drilldown IP meta information|
|Uses Language localization files|
|Lots of [configuration](#configuration) options|

### Screenshots
![dashboard](https://s3-us-west-2.amazonaws.com/github-project-images/laravel-logger/1-dashboard.jpg)
![drilldown](https://s3-us-west-2.amazonaws.com/github-project-images/laravel-logger/2-drilldown.jpg)
![confirm-clear](https://s3-us-west-2.amazonaws.com/github-project-images/laravel-logger/3-confirm-clear.jpg)
![log-cleared-msg](https://s3-us-west-2.amazonaws.com/github-project-images/laravel-logger/4-log-cleared-msg.jpg)
![cleared-log](https://s3-us-west-2.amazonaws.com/github-project-images/laravel-logger/5-cleared-log.jpg)
![confirm-restore](https://s3-us-west-2.amazonaws.com/github-project-images/laravel-logger/5-confirm-restore.jpg)
![confirm-destroy](https://s3-us-west-2.amazonaws.com/github-project-images/laravel-logger/6-confirm-destroy.jpg)
![success-destroy](https://s3-us-west-2.amazonaws.com/github-project-images/laravel-logger/7-success-destroy.jpg)
![success-restored](https://s3-us-west-2.amazonaws.com/github-project-images/laravel-logger/8-success-restored.jpg)
![cleared-drilldown](https://s3-us-west-2.amazonaws.com/github-project-images/laravel-logger/9-cleared-drilldown.jpg)

### License
Log Activity Module is licensed under the MIT license and originaly owned by [Jeremy Kenedy](https://github.com/jeremykenedy) for both personal and commercial products. Enjoy!

##### Tested & running smoothly on Laravel 6+
