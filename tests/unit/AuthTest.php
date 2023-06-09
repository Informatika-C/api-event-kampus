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
    protected $namespace   = ['App','Tests\Support'];

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

        $this->assertTrue($result->isOK());
    }

    public function testLoginFailed(){
        $result = $this->call('post', '/auth/login', [
            'email' => 'user212@gmail.com',
            'password' => 'orangbiasa'
        ]);

        $result->assertStatus(401);
    }

    public function testRegisterSuccsess(){
        $result = $this->call('post', '/auth/register', [
            'username' => 'user2',
            'email' => 'user2@gmail.com',
            'password' => 'orangbiasa',
            'password_confirm' => 'orangbiasa'
        ]);

        $this->assertTrue($result->isOK());
    }

    public function testRegisterFailed(){
        $result = $this->call('post', '/auth/register', [
            'username' => 'user2@',
            'email' => 'user',
            'password' => 'orangbiasa',
            'confirmPassword' => 'orangbiasa'
        ]);

        $result->assertStatus(401);
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
