<?php
date_default_timezone_set("Asia/Bangkok");
$config['version'] = '1.0';
$base_folder = '@' . str_replace(APP_DIR . '/' . WEBROOT_DIR . '/' . 'index.php', '', $_SERVER['PHP_SELF']);
$base_folder = str_replace('@/', '', $base_folder);
define('BASE_URL', Router::url('/', true) . $base_folder);
define('BASE_PATH', dirname(dirname(dirname(__FILE__))) . '/');
define('APP_PATH', BASE_PATH . 'app/');
define('VENDOR_PATH', APP_PATH . 'Vendor/');
define('MODEL_PATH', APP_PATH . 'Model/');
define('VIEW_PATH', APP_PATH . 'View/');
define('LIB_PATH', APP_PATH . 'Lib/');
define('PLUGIN_PATH', APP_PATH . 'Plugin/');
define('CONFIG_PATH', dirname(__FILE__) . '/');
define('WEBROOT_PATH', getcwd() . '/');
define('LANG_PATH', LIB_PATH . 'lang/');
define('LOG_PATH', APP_PATH . 'log/');
define('DIR_NAME', basename(BASE_PATH));

//if (strrpos(__FILE__, "/Applications/XAMPP") !== false) {
    define('SYSTEM_ENVIRONMENT', 'localhost');
//} else {
//    define('SYSTEM_ENVIRONMENT', 'production');
//}
// Load app/Lib files
// if ($handle = opendir(LIB_PATH)) {
//     while (false !== ($entry = readdir($handle))) {
//         if (preg_match("/^(?:[a-zA-Z0-9_]+)(?:\\.php)?$/", $entry, $matches)) {
//             $lib = str_replace('.php', '', $entry);
//             App::import('Lib', $lib);
//         }
//     }
//     closedir($handle);
// }
App::uses('Linklib', 'Lib/linklib');
App::import('Lib', 'Lib/GetTime.php');
function is_localhost() {
    return SYSTEM_ENVIRONMENT == 'localhost';
}

function is_production() {
    return SYSTEM_ENVIRONMENT == 'production';
}

define('SERVER_NAME', isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : '');
define('HTTP_PROTOCOL', isset($_SERVER['HTTPS']) ? 'https' : 'http');

// Database setting
if (is_localhost()) { // localhost    
    define('DB_HOSTNAME', 'localhost');
    define('DB_USERNAME', 'admin');
    define('DB_PASSWORD', '12345678');
    define('DB_DATABASE', 'smart_house');
} else { // production    
    define('DB_HOSTNAME', 'localhost');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', 'password');
    define('DB_DATABASE', 'database');
}

// URL settings
if (is_localhost()) { // localhost   
    // Define root url
    $tmp = explode(DIRECTORY_SEPARATOR, WEBROOT_PATH);
    $tmp = $tmp[count($tmp) - 3];
    define('ROOT_URL', HTTP_PROTOCOL . "://" . SERVER_NAME . "/{$tmp}/");

    // define web root url
    define('ADMIN_HOME_URL', HTTP_PROTOCOL . '://' . SERVER_NAME . '/' . DIR_NAME . '/apix/test');
    define('ADMIN_ROOT_URL', HTTP_PROTOCOL . '://' . SERVER_NAME . '/' . DIR_NAME . '/');
} else { // production   
    // Define root url
    define('ROOT_URL', HTTP_PROTOCOL . "://" . SERVER_NAME . "/");

    // define web root url
    define('ADMIN_HOME_URL', HTTP_PROTOCOL . '://' . SERVER_NAME . '/apix/test');
    define('ADMIN_ROOT_URL', HTTP_PROTOCOL . '://' . SERVER_NAME . '/');
}

define('RETURN_URL', ROOT_URL . (isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : ''));
define('ADMIN_DEFAULT_URL', ADMIN_HOME_URL);
/* API (LinkLib) */
define('LINKLIB_SECRET_KEY', 'K34eJjEt');
define('API_SECRET_KEY', LINKLIB_SECRET_KEY);
define('TIMEOUT_REQUEST_API',5);

$config['title'] = array(
    'device' => array(
        'index' => 'Danh sách thiết bị di động đã đăng ký',
        'request' => 'Danh sách thiết bị đăng ký'
    ),
    'admin' => array(
        'index' => 'Danh sách quản lý',
        'add' => 'Thêm người quản lý',
        'edit' => 'Cập nhật thông tin',
        'show' => 'Thông tin cá nhân'
    ),
    'electronic' => array(
        'index' => 'Danh sách thiết bị điện',
        'show' => 'Nhật ký hoạt động của thiết bị ',
        'add' => "Thêm thiết bị điện"
    ),
);
$config['image_dir'] = WWW_ROOT . 'uploads/images/';
$config['image_url'] = BASE_URL . 'uploads/images/';
$config['user_icon_url'] = BASE_URL . 'assets/images/img/user-icon.png';
$config['unit'] = "kW·h";
$config['type'] = array(
    'light' => 1,
    'term' => 2,
);
$config['module_wifi_ip'] = '192.168.43.9:333';
$config['day_week'] = array(
    'Mon' => "Thứ 2",
    'Tue' => "Thứ 3",
    'Wed' => "Thứ 4",
    'Thu' => "Thứ 5",
    'Fri' => "Thứ 6",
    'Sat' => "Thứ 7",
    'Sun' => "Chủ nhật"
);
error_reporting(E_ALL ^ E_STRICT);
