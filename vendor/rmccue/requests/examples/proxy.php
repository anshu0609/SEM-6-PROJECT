<?php

// First, include the Requests Autoloader.
require_once dirname(__DIR__) . '/src/Autoload.php';

// Next, make sure Requests can load internal classes.
WpOrg\Requests\Autoload::register();

// Now let's make a request via a proxy.
$options = [
	'proxy' => '127.0.0.1:8080', // syntax: host:port, eg 12.13.14.14:8080 or someproxy.com:3128
	// If you need to authenticate, use the following syntax:
	// 'proxy' => array( '127.0.0.1:8080', 'username', 'password' ),
];
$request = WpOrg\Requests\Requests::get('http://httpbin.org/ip', [], $options);

// See result
var_dump($request->body);
