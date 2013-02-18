<?php
namespace LoginForm\Tests\Includes;

use LoginForm\Includes\Page;

class PageTest extends \PHPUnit_Framework_TestCase {
    
    public function testSelf() {
        $page = new Page('test/self');
        $this->assertEquals($_SERVER['PHP_SELF'], $page->render());
    }
    
    public function testVar() {
        $page = new Page('test/var');
        $page->setVar('var', 'testVar');
        $this->assertEquals('testVar', $page->render());
    }
    
    public function testVars() {
        $page = new Page('test/vars');
        $page->setVars(array('var1' => 'this is ', 'var2' => 'a test'));
        $this->assertEquals('this is a test', $page->render());
    }
}
