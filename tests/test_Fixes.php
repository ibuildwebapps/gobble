<?php

    //This is a test to confirm the fix for issue #1 on github (trailing '?')

	require_once __DIR__ . '/../vendor/autoload.php' ;

	use Gobble\Gobble;

	$gobble = new Gobble("https://www.google.com") ;
    $gobble->setData(['b' => 2, 'c' => 3]) ;
	$gobble->send();
	echo 'CODE: ' . $gobble->getResponseCode() . "\n" ;
	echo 'BODY: ' . $gobble->getResponseBody() . "\n";
	echo $gobble->getSendHeaders() ;

    echo var_export($gobble->debug(), true) ;