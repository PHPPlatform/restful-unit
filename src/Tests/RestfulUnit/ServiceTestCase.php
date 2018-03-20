<?php

namespace PhpPlatform\Tests\RestfulUnit;

use PhpPlatform\Mock\Config\MockSettings;
use PhpPlatform\Session\Factory;

/**
 * This class provides utility methods to be called from a TestCase setupMethods to enable a TestCase for testing a service
 *
 */
class ServiceTestCase {
    
    static function setUpBeforeClass(){
        
    }
    
    static function setUp(){
        // clear session if any
        $session = Factory::getSession();
        $session->clear();
        MockSettings::setSettings("php-platform/session", "session.class", 'PhpPlatform\WebSession\Session');
    }
    
    static function tearDownAfterClass(){
        
    }
    
    static function tearDown(){
        
    }
    
}