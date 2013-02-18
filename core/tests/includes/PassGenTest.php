<?php
namespace LoginForm\Tests\Includes;

use LoginForm\Includes\UserPasswordGenerator;
use LoginForm\Users\User;

class PassGenTest extends \PHPUnit_Framework_TestCase {
    
    /** @var LoginForm\Includes\UserPasswordGenerator */
    protected $gen;
    
    protected function setUp() {
        $this->gen = UserPasswordGenerator::getInstance();
    }
    
    public function testInstanceType() {
        $this->assertInstanceOf('LoginForm\Includes\UserPasswordGenerator', $this->gen);
    }
    
    public function testSameInstance() {
        $instance2 = UserPasswordGenerator::getInstance();
        $this->assertSame($this->gen, $instance2);
    }
    
    public function testPassLength() {
        list($pass, $salt) = $this->gen->encrypt('test');
        $this->assertEquals(32, strlen($pass));
    }
    
    public function testSaltLength() {
        list($pass, $salt) = $this->gen->encrypt('test');
        $this->assertEquals(32, strlen($salt));
    }
    
    public function testPassCheck() {
        list($pass1, $salt1) = $this->gen->encrypt('test');
        list($pass2, $salt2) = $this->gen->encrypt('test', $salt1);
        $this->assertEquals($pass1, $pass2);
    }
    
    public function testUserPass() {
        list($pass, $salt) = $this->gen->encrypt('test');
        $user = new User('name', $pass, $salt);
        $this->assertTrue($this->gen->checkPass($user, 'test'));
    }
}