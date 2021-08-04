<?php
/**
 * 測試Cookie設定 - 不使用PHPUnit
 */

// 引入Composer autoload
include('../vendor/autoload.php');

// 宣告使用 SystemHelper
use marsapp\helper\system\SystemHelper;

// 常數設定
define('COOKIE_DEFAULT_PREFIX', 'dev_');
define('COOKIE_DEFAULT_EXPIRES', 0);
define('COOKIE_DEFAULT_PATH', '/');
// define('COOKIE_DEFAULT_DOMAIN', $_SERVER['SERVER_NAME']);
define('COOKIE_DEFAULT_DOMAIN', '');
define('COOKIE_ROOT_DOMAIN', 'dev.local');

// 變數設定
$name = 'testCookie';
$value = "test-" . mt_rand(1111, 9999);
$options = [
    // Cookie前綴，預設無前綴
    'prefix' => '',
    // 過期時間，預設無期限
    'expires' => time()+3600,
    // 存放路徑
    'path' => '/',
    // 所屬網域
    'domain' => "",
    // 是否只在https生效
    'secure' => true,
    // 是否只能通過HTTP協議訪問
    'httponly' => false,
];

// Cookie預設參數處理-單筆
$param = 'prefix';
$pValue = 'test_';
SystemHelper::cookieOption($param, $pValue);

// 設定Cookie
SystemHelper::cookieSet($name, $value, $options);

// 設定Cookie 存放於 Root Domain 中
SystemHelper::cookieSetRoot($name, $value . '-Root', $options);

// 取得Cookie
echo SystemHelper::cookieGet($name);

// 移除Cookie
// SystemHelper::cookieExpired($name, $options);

// 移除Cookie - 存放於 Root Domain 中
// SystemHelper::cookieExpiredRoot($name, $options);



