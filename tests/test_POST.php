<?php
	require_once __DIR__ . '/../vendor/autoload.php' ;

	use Gobble\Gobble;

	$gobble = new Gobble("https://www.google.com") ;
    $gobble->setMethod('POST');
    $gobble->setData(['a' => '1']);
	$gobble->send();
	echo 'CODE: ' . $gobble->getResponseCode() . "\n" ;
	echo 'BODY: ' . $gobble->getResponseBody() . "\n";
	echo $gobble->getSendHeaders() ;
