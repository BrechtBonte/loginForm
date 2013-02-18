<?php
namespace LoginForm\Tests\Includes;

use LoginForm\Includes\UserPasswordGenerator;

class PassGenTest extends \PHPUnit_Framework_TestCase {
    
    /** @var LoginForm\Includes\UserPasswordGenerator */
    protected $gen;
    
    protected function setUp() {
        $this->gen = UserPasswordGenerator::getInstance();
    }
    
    public function testInstanceType() {
        $this->assertInstanceOf('LoginForm\Includes\UserPasswordGenerator', $gen);
    }
    
    public function testSameInstance() {
        $instance2 = UserPasswordGenerator::getInstance();
        $this->assertSame($this->gen, $instance2);
    }
    
    public function testPassLength() {
        list($pass, $salt) = $this->gen->encrypt('test');
        $this->assertCount(32, $pass);
    }
    
    public function testSaltLength() {
        list($pass, $salt) = $this->gen->encrypt('test');
        $this->assertCount(32, $salt);
    }
    
    public function testPassCheck() {
        list($pass1, $salt1) = $this->gen->encrypt('test');
 //       list($pass2, $salt2)
    }
}