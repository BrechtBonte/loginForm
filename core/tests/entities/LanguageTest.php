<?php
namespace LoginForm\Tests\Entities\Enums;

use LoginForm\Enums\Language;

class LanguageTest extends \PHPUnit_Framework_TestCase {
    
    /** @group getters */
    public function testGetName() {
        $language = new Language('name', 'code');
        $this->assertEquals('name', $language->getName());
    }
    
    /** @group getters */
    public function testGetCode() {
        $language = new Language('name', 'code');
        $this->assertEquals('code', $language->getCode());
    }
    
    /** @test
     * @group faultyConstruct @group nullArgument */
    public function NullAsName() {
        $this->setExpectedException('Exception');
        $lang = new Language(null, 'code');
    // @codeCoverageIgnoreStart
    } // @codeCoverageIgnoreEnd
    
    /** @test
     * @group faultyConstruct @group nullArgument */
    public function NullAsCode() {
        $this->setExpectedException('Exception');
        $lang = new Language('name', null);
    // @codeCoverageIgnoreStart
    } // @codeCoverageIgnoreEnd
    
    /** @test
     * @group faultyConstruct @group emptyArgument */
    public function EmptyName() {
        $this->setExpectedException('Exception');
        $lang = new Language('', 'code');
    // @codeCoverageIgnoreStart
    } // @codeCoverageIgnoreEnd
    
    /** @test
     * @group faultyConstruct @group emptyArgument */
    public function EmptyCode() {
        $this->setExpectedException('Exception');
        $lang = new Language('name', '');
    // @codeCoverageIgnoreStart
    } // @codeCoverageIgnoreEnd
}