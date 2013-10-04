<?php
    //==================================================================================//
    // Configuration
    //==================================================================================//

	$configs = array(
		'development' => array(
			'debug' => true,
			'url' => '',
			'path' => '',
			'ssl' => false,
			'http_only' => true,
			'session_name' => '',
			'session_secret' => '',
			'cookie_domain' => '',
			'salt' => '',
			'mysql_host' => '',
			'mysql_dbname' => '',
			'mysql_user' => '',
			'mysql_password' => '',
			'twilio_sid' => '',
			'twilio_token' => ''
		),
		'production' => array(
			'debug' => false,
			'url' => '',
			'path' => '',
			'ssl' => true,
			'http_only' => false,
			'session_name' => '',
			'session_secret' => '',
			'cookie_domain' => '',
			'salt' => '',
			'mysql_host' => '',
			'mysql_dbname' => '',
			'mysql_user' => '',
			'mysql_password' => ''
	));
	
/* Don't edit below here. */
$host_r = explode('.', @$_SERVER['HTTP_HOST']);
if(is_array($host_r) && !empty($host_r)) {
	if(count($host_r)>2)
		while(count($host_r)>2) array_shift($host_r);
	$main_host = implode('.', $host_r);
}
foreach($configs as $config) {
	if($main_host==$config['url']) {
		$conf = $config;
		continue;
	}
}

// ini_set("display_errors",0);