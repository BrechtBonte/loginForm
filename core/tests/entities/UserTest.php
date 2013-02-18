<?php
namespace LoginForm\Tests\Entities\Users;

use LoginForm\Users\User;
use LoginForm\Groups\Group;
use LoginForm\Enums\Language;

class UserTest extends \PHPUnit_Framework_TestCase {
    
    /** @var User */
    protected $user;
    
    protected function setUp() {
        $this->user = new User('name', 'password', 'salt', new Language('name', 'code'));
    }
    
    /**
     * @test
     * @group getters
     */
    public function idIsZero() {
        $this->assertEquals(0, $this->user->getId());
    }
    
    /** @group getters */
    public function testGetName() {
        $this->assertEquals('name', $this->user->getName());
    }
    
    /** @group getters */
    public function testGetPassword() {
        $this->assertEquals('password', $this->user->getPassword());
    }
    
    /** @group getters */
    public function testGetSalt() {
        $this->assertEquals('salt', $this->user->getSalt());
    }
    
    /** @group getters */
    public function testGetLanguage() {
        $this->assertInstanceOf('LoginForm\Enums\Language', $this->user->getLanguage());
    }
    
    public function testSetLanguage() {
        $language = new Language('test', 'TST');
        $this->user->setLanguage($language);
        $this->assertSame($language, $this->user->getLanguage());
    }
    
    /** @test */
    public function UserAddsGroup() {
        $group = new Group('groupName');
        $this->user->addGroup($group);
        $this->assertContains($group, $this->user->getGroups());
        return $this->user;
    }
    
    /** @test */
    public function GroupAddsUser() {
        $group = new Group('groupName');
        $this->user->addGroup($group);
        $this->assertContains($this->user, $group->getUsers());
    }
    
    /** @depends UserAddsGroup */
    public function testAddGroupCount(User $usr) {
        $this->assertCount(1, $usr->getGroups());
    }
    
    /**
     * @test
     * @group faultyConstruct @group nullArgument
     */
    public function NullAsName() {
        $this->setExpectedException('Exception');
        $user = new User(null, 'password', 'salt', new Language('name', 'code'));
    // @codeCoverageIgnoreStart
    } // @codeCoverageIgnoreEnd
    
    /**
     * @test
     * @group faultyConstruct @group nullArgument
     */
    public function NullAsPassword() {
        $this->setExpectedException('Exception');
        $user = new User('name', null, 'salt', new Language('name', 'code'));
    // @codeCoverageIgnoreStart
    } // @codeCoverageIgnoreEnd
    
    /** @test
     * @group faultyConstruct @group nullArgument */
    public function NullAsSalt() {
        $this->setExpectedException('Exception');
        $user = new User('name', 'password', null, new Language('name', 'code'));
    // @codeCoverageIgnoreStart
    } // @codeCoverageIgnoreEnd
    
    /** @test
     * @group faultyConstruct @group emptyArgument */
    public function EmptyName() {
        $this->setExpectedException('Exception');
        $user = new User(null, 'password', 'salt', new Language('name', 'code'));
    // @codeCoverageIgnoreStart
    } // @codeCoverageIgnoreEnd
    
    /** @test
     * @group faultyConstruct @group emptyArgument */
    public function EmptyPassword() {
        $this->setExpectedException('Exception');
        $user = new User('name', null, 'salt', new Language('name', 'code'));
    // @codeCoverageIgnoreStart
    } // @codeCoverageIgnoreEnd
    
    /** @test
     * @group faultyConstruct @group emptyArgument */
    public function EmptyAsSalt() {
        $this->setExpectedException('Exception');
        $user = new User('name', 'password', null, new Language('name', 'code'));
    // @codeCoverageIgnoreStart
    } // @codeCoverageIgnoreEnd
    
    /** @test */
    public function NullAsLanguage() {
        $user = new User('name', 'password', 'salt', null);
    // @codeCoverageIgnoreStart
    } // @codeCoverageIgnoreEnd
    
    public function testLanugageType() {
        $this->setExpectedException('Exception');
        $user = new User('name', 'password', 'salt', 'test');
    // @codeCoverageIgnoreStart
    } // @codeCoverageIgnoreEnd
}