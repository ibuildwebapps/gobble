# gobble

composer require ibuildwebapps/gobble:dev-master

Simplified curl wrapper.  This was built as a much simpler alternative to Guzzle.

GET example: 

            $uri = "https://www.google.com" ;
            $gobble = new Gobble($uri) ;
            //$gobble->setMethod('GET'); /* This is implied */
            $gobble->send() ;
            $body = $gobble->getResponseBody() ;
            $code = $gobble->getResponseCode() ;
            echo 'Response body: ' . $body . "\n";
            echo 'Response code: ' . $code . "\n";


POST example: 

            $uri = "https://www.google.com" ;
            $gobble = new Gobble($uri) ;
            $gobble->setMethod('POST');
            $gobble->setData([$param => $value]);
            $gobble->send() ;
            $body = $gobble->getResponseBody() ;
            $code = $gobble->getResponseCode() ;
            echo 'Response body: ' . $body . "\n";
            echo 'Response code: ' . $code . "\n"; 
