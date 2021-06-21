System Helper
===

Helper for system operation.


[![Latest Stable Version](https://poser.pugx.org/marshung/structure/v/stable)](https://packagist.org/packages/marshung/io) [![Total Downloads](https://poser.pugx.org/marshung/structure/downloads)](https://packagist.org/packages/marshung/io) [![Latest Unstable Version](https://poser.pugx.org/marshung/structure/v/unstable)](https://packagist.org/packages/marshung/io) [![License](https://poser.pugx.org/marshung/structure/license)](https://packagist.org/packages/marshung/io)

<img alt="plastic" src="https://shields.io/badge/style-plastic-green?style=plastic">

# 1. Outline
<!-- TOC -->

- [System Helper](#system-helper)
- [1. Outline](#1-outline)
- [2. Description](#2-description)
- [3. Installation](#3-installation)
  - [3.1. composer install](#31-composer-install)
- [4. Dependency](#4-dependency)
- [5. Usage](#5-usage)
  - [5.1. Cookie](#51-cookie)
    - [5.1.1. Setting](#511-setting)
    - [5.1.2. Cookie Default Option - Single](#512-cookie-default-option---single)
      - [5.1.2.1. Description](#5121-description)
      - [5.1.2.2. Parameters](#5122-parameters)
      - [5.1.2.3. Return Values](#5123-return-values)
      - [5.1.2.4. Example](#5124-example)
    - [5.1.3. Set Cookie Default Option - Multiple](#513-set-cookie-default-option---multiple)
      - [5.1.3.1. Description](#5131-description)
      - [5.1.3.2. Parameters](#5132-parameters)
      - [5.1.3.3. Return Values](#5133-return-values)
      - [5.1.3.4. Example](#5134-example)
    - [5.1.4. Set Cookie](#514-set-cookie)
      - [5.1.4.1. Description](#5141-description)
      - [5.1.4.2. Parameters](#5142-parameters)
      - [5.1.4.3. Return Values](#5143-return-values)
      - [5.1.4.4. Example](#5144-example)
    - [5.1.5. Set Cookie on root domain](#515-set-cookie-on-root-domain)
      - [5.1.5.1. Description](#5151-description)
    - [5.1.6. Get Cookie](#516-get-cookie)
      - [5.1.6.1. Description](#5161-description)
    - [5.1.7. Delete Cookie](#517-delete-cookie)
      - [5.1.7.1. Description](#5171-description)
    - [5.1.8. Delete Cookie on root domain](#518-delete-cookie-on-root-domain)
      - [5.1.8.1. Description](#5181-description)
- [6. Example](#6-example)
- [7. Contributing](#7-contributing)

<!-- /TOC -->


# 2. [Description](#outline)


# 3. [Installation](#outline)
## 3.1. composer install

```bash
$ composer require marsapp/system-helper
```

# 4. [Dependency](#outline)
- PHP7

# 5. [Usage](#outline)
## 5.1. Cookie
- library for Cookie operating
- Wrap the PHP native function/variable setcookie()/$_COOKIE to enrich the function and simplify the usage method.
- Extra features:
  - Support Cookie prefix packaging
  - Support default values: expires, path, domain, secure, httponly
  - Dedicated function: Root domain access

### 5.1.1. Setting
- 使用前設定
```php
// 引入Composer autoload
include('../vendor/autoload.php');

// 宣告使用 SystemHelper
use marsapp\helper\system\SystemHelper;

// 常數設定 - 需設 Cookie前綴、過期時間、預設路徑、根網域
define('COOKIE_DEFAULT_PREFIX', 'dev_');
define('COOKIE_DEFAULT_EXPIRES', 0);
define('COOKIE_DEFAULT_PATH', '/');
define('COOKIE_ROOT_DOMAIN', 'dev.local');
```

### 5.1.2. Cookie Default Option - Single
#### 5.1.2.1. Description
    cookieOption(string $param, string $value = null) : string|null

#### 5.1.2.2. Parameters 
- $param : string
  - The target parameter of the cookie default options.
- $value : string
  - New data.

> - When $param does not exist, return null
> - When there is $param but no $value(null), get the current value of $param
> - When there is $param and $value, after updating the data, the updated value will be returned


#### 5.1.2.3. Return Values
string|null

#### 5.1.2.4. Example
```php
// 取得Cookie預設參數值
$httponly = SystemHelper::cookieOption('httponly');

// 設定Cookie預設參數-單筆
$httponly = SystemHelper::cookieOption('httponly', false);
```

### 5.1.3. Set Cookie Default Option - Multiple
#### 5.1.3.1. Description
    cookieOptions(array $options = []) : array

#### 5.1.3.2. Parameters 
- $options : array
  - batch update cookie default options.

#### 5.1.3.3. Return Values
array, return complete cookie default options. 

#### 5.1.3.4. Example
```php
// 變數設定
$options = [
    // 存放路徑
    'path' => '/tmp/',
    // 是否只能通過HTTP協議訪問
    'httponly' => false,
];

// 回傳完整Cookie預設參數
$cookieOptions = SystemHelper::cookieOptions();

// 設定Cookie預設參數-多筆
$cookieOptions = SystemHelper::cookieOptions($options);
```

### 5.1.4. Set Cookie
#### 5.1.4.1. Description
    cookieSet(string $name, string $value = "", array $options = []) : bool

> Set Cookie, Wrap the PHP native function setcookie() to simplify usage.

#### 5.1.4.2. Parameters 
- $name : string
  - The name of the cookie.
- $value : string
  - The value of the cookie.
- $options : array
  - 'prefix' => '',           // Cookie前綴，預設無前綴
  - 'expires' => time()+3600, // 過期時間，預設無期限
  - 'path' => '/',            // 存放路徑
  - 'domain' => "",           // 所屬網域
  - 'secure' => true,         // 是否只在https生效
  - 'httponly' => false,      // 是否只能通過HTTP協議訪問

#### 5.1.4.3. Return Values
bool, like PHP function setcookie()

#### 5.1.4.4. Example
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
>   - 'prefix' => '',           // Cookie前綴，預設無前綴
>   - 'expires' => time()+3600, // 過期時間，預設無期限
>   - 'path' => '/',            // 存放路徑
>   - 'domain' => "",           // 所屬網域
>   - 'secure' => true,         // 是否只在https生效
>   - 'httponly' => false,      // 是否只能通過HTTP協議訪問


### 5.1.5. Set Cookie on root domain
#### 5.1.5.1. Description
    cookieSetRoot(string $name, string $value = "", array $options = []) : bool

> Like `cookieSet()`, but domain fixed on root domain.

### 5.1.6. Get Cookie
#### 5.1.6.1. Description
    cookieGet(string $name) : mixed

> 取得目標Cookie值

### 5.1.7. Delete Cookie
#### 5.1.7.1. Description
    cookieExpired(string $name, array $options = []) : bool

> Delete target cookie.

### 5.1.8. Delete Cookie on root domain
#### 5.1.8.1. Description
    cookieExpiredRoot(string $name, array $options = []) : bool

> Like `cookieExpired()`, but domain fixed on root domain.

# 6. [Example](#outline)
see: example/example-cookie.php

# 7. [Contributing](#outline)
- 20210424: MarsHung Build repo & development
- 20210621: MarsHung Add function cookieOption(), cookieOptions(), COOKIE_DEFAULT_PREFIX
