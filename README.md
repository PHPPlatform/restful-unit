# PHP Platform RestFul APIs Unit Testing 
This package provides a utilities to unit test Restful Web Services from  [PHPPlatfrom/restful](https://github.com/PHPPlatform/restful)


## How to Use

* **Step 1**

refer to `resources/autoload.php` from this package in the phpunit.xml
```XML
<phpunit colors="true" bootstrap="vendor/php-platform/restful-unit/resources/autoload.php" >
</phpunit>
```

* **Step 2**

invoke setupMethodds of `PhpPlatform\Tests\RestfulUnit\ServiceTestCase` from the TestCase's setup methods

```PHP

class MyRestFulTest extends TestCase {
    static function setUpBeforeClass(){
        parent::setUpBeforeClass();
        \PhpPlatform\Tests\RestfulUnit\ServiceTestCase::setUpBeforeClass();
    }
    
    function setUp(){
        parent::setUp();
        \PhpPlatform\Tests\RestfulUnit\ServiceTestCase::setUp();
    }
    
    static function tearDownAfterClass(){
        parent::tearDownAfterClass();
        \PhpPlatform\Tests\RestfulUnit\ServiceTestCase::tearDownAfterClass();
    }
    
    function tearDown(){
        parent::tearDown();
        \PhpPlatform\Tests\RestfulUnit\ServiceTestCase::tearDown();
    }
}


```
 