<?php

namespace marsapp\helper\system;

/**
 * System Helper
 *
 * # Cookie Helper 部份
 * - 包裝PHP原生函式/變數 setcookie()/$_COOKIE ，以豐富作用方式之餘，簡化使用方法.
 * - 額外功能：
 *   - 支援Cookie前綴包裝
 *   - 支援預設值: expires, path, domain, secure, httponly
 *   - 專用函式: Root domain存取
 * - 常數
 *   - Cookie前綴，預設優先序: COOKIE_DEFAULT_PREFIX => '' (空字串)
 *   - 過期時間，預設優先序: COOKIE_DEFAULT_EXPIRES => 無期限
 *   - 存放路徑，預設優先序: COOKIE_DEFAULT_PATH => 當前路徑
 *   - 所屬網域，優先序: COOKIE_ROOT_DOMAIN => 當前網域
 * 
 * @author Mars.Hung
 *        
 */
class SystemHelper
{

    /**
     * Cookie預設參數
     */
    static $cookieDefaultOptions = [
        // Cookie前綴，預設無前綴
        'prefix' => COOKIE_DEFAULT_PREFIX ?? '',
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

    /**
     * Cookie預設參數處理-單筆
     *
     * - 當目標參數不存在，回傳null
     * - 當有目標參數，但沒待處理值，取得現在目標參數的值
     * - 當有目標參數，且有待處理值，更新資料後回傳更新後的值
     * 
     * @param string $param 目標參數
     * @param mixed $value 待處理值
     * @return mixed
     */
    public static function cookieOption(string $param, $value = null)
    {
        // 存在才處理
        if (isset(self::$cookieDefaultOptions[$param])) {
            // 有待處理值時才更新
            if (!is_null($value)) {
                self::$cookieDefaultOptions[$param] = $value;
            }

            // 回傳目標參數儲存的值
            return self::$cookieDefaultOptions[$param];
        }

        // 目標參數不存在，回傳NULL
        return null;
    }

    /**
     * 設定Cookie預設參數-多筆
     *
     * - 差異處理更新後回傳完整Cookie預設參數
     * - 當傳入空陣列時，不會處理更新，只會回傳完整Cookie預設參數
     * 
     * @param array $options 參數
     * @return array
     */
    public static function cookieOptions(array $options = [])
    {
        // 有傳入資料時才處理更新
        if (count($options)) {
            self::$cookieDefaultOptions = array_merge(self::$cookieDefaultOptions, array_intersect_key($options, self::$cookieDefaultOptions));
        }

        // 回傳完整Cookie預設參數
        return self::$cookieDefaultOptions;
    }

    /**
     * 設定Cookie
     *
     * - 為簡化系統開發與統一管理Cookie選項預設值，因此開發本函式
     * - 可設定常數 COOKIE_DEFAULT_PREFIX , COOKIE_DEFAULT_EXPIRES , COOKIE_DEFAULT_PATH
     * - 格式
     * $options = [
     *      // Cookie前綴，預設優先序: COOKIE_DEFAULT_PREFIX => '' (無前綴)
     *      'prefix' => '',
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
        // 取得設定參數
        $op = $options + self::$cookieDefaultOptions;

        $name = $op['prefix'] . $name;

        // 更新資料
        $_COOKIE[$name] = $value;
        return setcookie($name, $value, $op['expires'], $op['path'], $op['domain'], $op['secure'], $op['httponly']);
    }

    /**
     * 設定Cookie - 存放於 Root Domain 中
     *
     * - 需設定常數 COOKIE_ROOT_DOMAIN，如沒設定則為當前網域
     * - 本函式為指定 domain 參數的 cookieSet() 函式
     * - 目前網域與根網域有同名稱變數時，優先讀取先設定的資料(chrome,20210506,PHP7)
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
     * - 目前網域與根網域有同名稱變數時，優先讀取先設定的資料(chrome,20210506,PHP7)
     * 
     * @param  string   $name Cookie Name
     * @param  array    $options Cookie setting parameters
     * @return string
     */
    public static function cookieGet(string $name, array $options = [])
    {
        // 取得設定參數
        $op = $options + self::$cookieDefaultOptions;

        $name = $op['prefix'] . $name;

        return $_COOKIE[$name] ?? '';
    }

    /**
     * 移除Cookie
     *
     * - 因使用setcookie()移除cookie後要下一輪才會生效，所以需同步移除$_COOKIE中的值
     * 
     * @param  string $name Cookie Name
     * @param  array   $options Cookie setting parameters
     * @return bool
     */
    public static function cookieExpired(string $name, array $options = [])
    {
        // 移除Cookie
        $options['expires'] = -1;
        $opt = self::cookieSet($name, '', $options);

        // 取得設定參數
        $op = $options + self::$cookieDefaultOptions;
        $name = $op['prefix'] . $name;

        // 同步移除 $_COOKIE 中的資料
        unset($_COOKIE[$name]);
        return $opt;
    }

    /**
     * 移除Cookie - 存放於 Root Domain 中
     *
     * - 因使用setcookie()移除cookie後要下一輪才會生效，所以需同步移除$_COOKIE中的值
     *
     * @param  string $name Cookie Name
     * @param  array   $options Cookie setting parameters
     * @return bool
     */
    public static function cookieExpiredRoot(string $name, array $options = [])
    {
        // 移除Cookie
        $options['expires'] = -1;
        $opt =  self::cookieSetRoot($name, '', $options);

        // 取得設定參數
        $op = $options + self::$cookieDefaultOptions;
        $name = $op['prefix'] . $name;

        // 同步移除 $_COOKIE 中的資料
        unset($_COOKIE[$name]);
        return $opt;
    }
}
