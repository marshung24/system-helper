<?php
namespace marsapp\helper\system;

/**
 * System Helper
 *
 * - 常數
 * - - 過期時間，預設優先序: COOKIE_DEFAULT_EXPIRES => 無期限
 * - - 存放路徑，預設優先序: COOKIE_DEFAULT_PATH => 當前路徑
 * - - 所屬網域，優先序: COOKIE_ROOT_DOMAIN => 當前網域
 * 
 * @author Mars.Hung
 *        
 */
class SystemHelper
{

    /**
     * 設定Cookie
     *
     * - 為簡化系統開發與統一管理Cookie選項預設值，因此開發本函式
     * - 可設定常數 COOKIE_DEFAULT_EXPIRES , COOKIE_DEFAULT_PATH
     * - 格式
     * $options = [
     *      // 過期時間，預設優先序: COOKIE_DEFAULT_EXPIRES => 無期限
     *      'expires' => 0,
     *      // 存放路徑，預設優先序: COOKIE_DEFAULT_PATH => 當前路徑
     *      'path' => "",
     *      // 所屬網域
     *      'domain' => "",
     *      // 是否只在https生效
     *      'secure' => true,
     *      // 是否只能通過HTTP協議訪問
     *      'httponly' => false,
     * ];
     *
     * $_COOKIE特性
     * - 使用setcookie設定Cookie內容時，無法馬上從$_COOKIE取得值
     * - 使用setcookie設定Cookie過期時，$_COOKIE內的資料不會馬上消失
     * - 使用unset變更/刪除$_COOKIE內某個Cookie時，並不會真的變動
     *
     * @param  string  $name    Cookie Name
     * @param  string  $value   Cookie Value
     * @param  array   $options Cookie setting parameters
     * @return void
     */
    public static function cookieSet(string $name, string $value = "", array $options = [])
    {
        /**
         * 預設參數
         */
        static $defaultOptions = [
            // 過期時間，預設無期限
            'expires' => COOKIE_DEFAULT_EXPIRES ?? 0,
            // 存放路徑
            'path' => COOKIE_DEFAULT_PATH ?? '',
            // 所屬網域
            'domain' => "",
            // 是否只在https生效
            'secure' => true,
            // 是否只能通過HTTP協議訪問
            'httponly' => false,
        ];

        // 取得設定參數
        $op = $options + $defaultOptions;

        return setcookie($name, $value, $op['expires'], $op['path'], $op['domain'], $op['secure'], $op['httponly']);
    }

    /**
     * 設定Cookie - 存放於 Root Domain 中
     *
     * - 需設定常數 COOKIE_ROOT_DOMAIN，如沒設定則為當前網域
     * - 本函式為指定 domain 參數的 cookieSet() 函式
     * - 目前網域與根網域有同名稱變數時，優先讀取目前網域資料
     *
     * @param  string  $name    Cookie Name
     * @param  string  $value   Cookie Value
     * @param  array   $options Cookie setting parameters
     * @return void
     */
    public static function cookieSetRoot(string $name, string $value = "", array $options = [])
    {
        // 覆蓋所屬網域，優先序: COOKIE_ROOT_DOMAIN => 當前網域
        $options['domain'] = defined('COOKIE_ROOT_DOMAIN') ? COOKIE_ROOT_DOMAIN : '';

        return self::cookieSet($name, $value, $options);
    }

    /**
     * 取得Cookie
     * 
     * - 目前網域與根網域有同名稱變數時，優先讀取目前網域資料
     * 
     * @param  string   $name Cookie Name
     * @return string
     */
    public static function cookieGet(string $name)
    {
        return $_COOKIE[$name] ?? '';
    }

    /**
     * 移除Cookie
     *
     * @param  string $name Cookie Name
     * @param  array   $options Cookie setting parameters
     * @return bool
     */
    public static function cookieExpired(string $name, array $options = [])
    {
        unset($_COOKIE[$name]);
        $options['expires'] = -1;
        return self::cookieSet($name, '', $options);
    }

    /**
     * 移除Cookie - 存放於 Root Domain 中
     *
     * @param  string $name Cookie Name
     * @param  array   $options Cookie setting parameters
     * @return bool
     */
    public static function cookieExpiredRoot(string $name, array $options = [])
    {
        unset($_COOKIE[$name]);
        $options['expires'] = -1;
        return self::cookieSetRoot($name, '', $options);
    }

}
