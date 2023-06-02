<?php

use CodeIgniter\Test\CIUnitTestCase;

use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\FeatureTestTrait;

/**
 * @internal
 */
class AuthTest extends CIUnitTestCase
{
    use DatabaseTestTrait;
    use FeatureTestTrait;

    public function testLoginSuccsess(){
        // $result = $this->call('post', '/auth/login', [
        //     'email' => 'user@gmail.com',
        //     'password' => 'orangbiasa'
        // ]);
    }
}
