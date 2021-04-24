System Helper
===

Helper for system operation.


[![Latest Stable Version](https://poser.pugx.org/marshung/structure/v/stable)](https://packagist.org/packages/marshung/io) [![Total Downloads](https://poser.pugx.org/marshung/structure/downloads)](https://packagist.org/packages/marshung/io) [![Latest Unstable Version](https://poser.pugx.org/marshung/structure/v/unstable)](https://packagist.org/packages/marshung/io) [![License](https://poser.pugx.org/marshung/structure/license)](https://packagist.org/packages/marshung/io)

<img alt="plastic" src="https://shields.io/badge/style-plastic-green?style=plastic">

# Outline
<!-- TOC -->

- [System Helper](#system-helper)
- [Outline](#outline)
- [Description](#description)
- [Installation](#installation)
  - [composer install](#composer-install)
- [Dependency](#dependency)
- [Usage](#usage)
  - [Cookie](#cookie)
    - [Setting](#setting)
    - [Set Cookie](#set-cookie)
      - [Description](#description-1)
      - [Parameters](#parameters)
      - [Return Values](#return-values)
      - [Example](#example)
    - [Set Cookie on root domain](#set-cookie-on-root-domain)
      - [Description](#description-2)
    - [Get Cookie](#get-cookie)
      - [Description](#description-3)
    - [Delete Cookie](#delete-cookie)
      - [Description](#description-4)
    - [Delete Cookie on root domain](#delete-cookie-on-root-domain)
      - [Description](#description-5)
- [Example](#example-1)
- [Contributing](#contributing)

<!-- /TOC -->


# [Description](#outline)


# [Installation](#outline)
## composer install

```bash
$ composer require marsapp/system-helper
```

# [Dependency](#outline)
- PHP7

# [Usage](#outline)
## Cookie
library for Cookie operating

### Setting
- 使用前設定
```php
// 引入Composer autoload
include('../vendor/autoload.php');

// 宣告使用 SystemHelper
use marsapp\helper\system\SystemHelper;

// 常數設定 - 需設過期時間、預設路徑、根網域
define('COOKIE_DEFAULT_EXPIRES', 0);
define('COOKIE_DEFAULT_PATH', '/');
define('COOKIE_ROOT_DOMAIN', 'dev.local');
```

### Set Cookie
#### Description
    cookieSet(string $name, string $value = "", array $options = []) : bool

#### Parameters 
- $name : string
  - The name of the cookie.
- $value : string
  - The value of the cookie.
- $options : array
  - 'expires' => time()+3600, // 過期時間，預設無期限
  - 'path' => '/',            // 存放路徑
  - 'domain' => "",           // 所屬網域
  - 'secure' => true,         // 是否只在https生效
  - 'httponly' => false,      // 是否只能通過HTTP協議訪問

#### Return Values
bool, like PHP function setcookie()

#### Example
```php
// 變數設定
$name = 'testCookie';
$value = "test-" . mt_rand(1111, 9999);
$options = [
    // 存放路徑
    'path' => '/',
    // 是否只能通過HTTP協議訪問
    'httponly' => true,
];

// 設定Cookie
SystemHelper::cookieSet($name, $value, $options);
```
> - $options可用參數
>   - 'expires' => time()+3600, // 過期時間，預設無期限
>   - 'path' => '/',            // 存放路徑
>   - 'domain' => "",           // 所屬網域
>   - 'secure' => true,         // 是否只在https生效
>   - 'httponly' => false,      // 是否只能通過HTTP協議訪問


### Set Cookie on root domain
#### Description
    cookieSetRoot(string $name, string $value = "", array $options = []) : bool


### Get Cookie
#### Description
    cookieGet(string $name) : mixed


### Delete Cookie
#### Description
    cookieExpired(string $name, array $options = []) : bool


### Delete Cookie on root domain
#### Description
    cookieExpiredRoot(string $name, array $options = []) : bool


# [Example](#outline)
see: example/example-cookie.php

# [Contributing](#outline)
- 20210424: MarsHung Build repo & development

