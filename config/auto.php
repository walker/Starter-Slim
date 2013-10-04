<?php
require_once(dirname(__FILE__).DS.'config.php');

$ssl_str = ($conf['ssl']) ? 's' : '';

if(!defined('COOKIE_DOMAIN'))
	define('COOKIE_DOMAIN', '.'.$conf['url']);

$host_r = explode('.', @$_SERVER['HTTP_HOST']);
if(count($host_r)==3)
	if(!defined('SUBDOMAIN'))
		define('SUBDOMAIN', $host_r[0]);
else
	if(!defined('SUBDOMAIN'))
		define('SUBDOMAIN', '');
	
if(!defined('REDIR_DOMAIN')) {
	if(is_array($host_r) && !empty($host_r)) {
		if(count($host_r)>3)
			while(count($host_r)>3) array_shift($host_r);
		define('REDIR_DOMAIN', implode('.', $host_r));
	}
}

if(!defined('APP_URL'))
	define('APP_URL', 'http'.$ssl_str.'://'.REDIR_DOMAIN);

if(!defined('SALT'))
	define('SALT', $conf['salt']);

if(!defined('APP'))
	define('APP', dirname(dirname(__FILE__)).DS);

if(!defined('TEMPLATE'))
	define('TEMPLATE', dirname(dirname(__FILE__)).DS.'templates'.DS);

if(!defined('VENDOR'))
	define('VENDOR', dirname(dirname(__FILE__)).DS.'vendor'.DS);

if(!defined('MODEL'))
	define('MODEL', dirname(dirname(__FILE__)).DS.'models'.DS);

if(!defined('ACTION'))
	define('ACTION', dirname(dirname(__FILE__)).DS.'actions'.DS);

if(!defined('LIB'))
	define('LIB', dirname(dirname(__FILE__)).DS.'libraries'.DS);

if(!defined('CONF'))
	define('CONF', dirname(dirname(__FILE__)).DS.'config'.DS);

if(!defined('WEBROOT'))
	define('WEBROOT', dirname(dirname(__FILE__)).DS.'content'.DS);

if(!defined('DEBUG'))
    define('DEBUG', $conf['debug']);

/* Exception & Error reporting. Meh. Slow. */
// require_once(LIB.'raygun.php');

//database connection configuration
ORM::configure('mysql:host='.$conf['mysql_host'].';dbname='.$conf['mysql_dbname']);
ORM::configure('username', $conf['mysql_user']);
ORM::configure('password', $conf['mysql_password']);

$app = new \Slim\Slim(array(
	'mode' => 'development',
	'templates.path' => '..'.DS.'templates',
	'log.level' => 4,
	'log.enabled' => true
));

// Create monolog logger and store logger in container as singleton 
// (Singleton resources retrieve the same log resource definition each time)
$app->container->singleton('log', function () {
    $log = new \Monolog\Logger('slim-skeleton');
    $log->pushHandler(new \Monolog\Handler\StreamHandler('../logs/app.log', \Psr\Log\LogLevel::DEBUG));
    return $log;
});
// $app->log->info("Slim-Skeleton '/' route");

$auth_config = array(
	'provider' => 'Paris',
	'auth.type' => 'form',
	'login.url' => '/login',
	'post.auth' => '/admin',
	'security.urls' => array(
		array('path' => '/admin/.+'),
	)
);

$app->add(new StrongAuth($auth_config));

// $app->add(new \Slim\Middleware\SessionCookie(array(
//     'expires' => '120 minutes',
//     'path' => '/',
//     'domain' => COOKIE_DOMAIN,
//     'secure' => $conf['ssl'],
//     'httponly' => $conf['http_only'],
//     'name' => $conf['session_name'],
//     'secret' => $conf['session_secret'],
//     'cipher' => MCRYPT_RIJNDAEL_256,
//     'cipher_mode' => MCRYPT_MODE_CBC
// )));

// Prepare view
$app->view(new \Slim\Views\Twig());
$app->view->parserOptions = array(
	'charset' => 'utf-8',
	'cache' => realpath(dirname(dirname(__FILE__)).DS.'templates'.DS.'cache'),
	'auto_reload' => true,
	'strict_variables' => false,
	'autoescape' => true
);
$app->view->parserExtensions = array(new \Slim\Views\TwigExtension());

require_once(LIB.'functions.php');
require_once(MODEL.'signatory.php');

// session_start();