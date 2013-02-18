<?php
namespace LoginForm\Tests\Entities\Groups;

use LoginForm\Users\User;
use LoginForm\Groups\Group;

class GroupTest extends \PHPUnit_Framework_TestCase {
    
    /**
     * @codeCoverageIgnore
     */
    public function nameProvider() {
        return array(
            array('name1'),
            array('other name'),
            array('this'),
            array('is just'),
            array('a test'),
            array('for providers')
        );
    }
    
    /** @group getters @dataProvider nameProvider */
    public function testGetName($name) {
        $group = new Group($name);
        $this->assertEquals($name, $group->getName());
    }
    
    /** @test */
    public function GroupAddsUser() {
        $group = new Group('groupName');
        $user = new User('name', 'password', 'salt');
        $group->addUser($user);
        $this->assertContains($user, $group->getUsers());
        return array($group, $user);
    }
    
    /**
     * @test
     * @depends GroupAddsUser
     */
    public function UserAddsGroup(array $pair) {
        $this->assertContains($pair[0], $pair[1]->getGroups());
    }
    
    /** @depends GroupAddsUser */
    public function testUserCount(array $pair) {
        $this->assertCount(1, $pair[0]->getUsers());
    }
    
    /** @test
     * @group faultyConstruct @group nullArgument */
    public function NullAsName() {
        $this->setExpectedException('Exception');
        $group = new Group(null);
    // @codeCoverageIgnoreStart
    } // @codeCoverageIgnoreEnd
    
    /** @test 
     * @group faultyConstruct @group emptyArgument */
    public function EmptyName() {
        $this->setExpectedException('Exception');
        $group = new Group('');
    // @codeCoverageIgnoreStart
    } // @codeCoverageIgnoreEnd
    
}
