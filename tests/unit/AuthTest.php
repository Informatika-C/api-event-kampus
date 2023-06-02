<?php

use CodeIgniter\Test\CIUnitTestCase;

use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\FeatureTestTrait;

use CodeIgniter\Shield\Entities\User;

/**
 * @internal
 */
class AuthTest extends CIUnitTestCase
{
    use DatabaseTestTrait;
    use FeatureTestTrait;

    // For Migrations
    protected $migrate     = true;
    protected $migrateOnce = false;
    protected $refresh     = true;
    protected $namespace   = 'Tests\Support';

    protected function setUp(): void
    {
        parent::setUp();

        $this->createDummyUser();
    }

    public function testLoginSuccsess(){
        $result = $this->call('post', '/auth/login', [
            'email' => 'user@gmail.com',
            'password' => 'orangbiasa'
        ]);

        $this->assertTrue(!$result->isOK());
    }

    private function createDummyUser(){
        $users = auth()->getProvider();

        $user = new User([
            'username' => 'user',
            'email'    => 'user@gmail.com',
            'password' => 'orangbiasa',
        ]);
        $users->save($user);

        $user = $users->findById($users->getInsertID());
        $user->addGroup('user');
    }
}
