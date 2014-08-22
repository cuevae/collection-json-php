<?php

use \CollectionPlusJson\Template;
use \CollectionPlusJson\DataObject;

class TemplateTest extends PHPUnit_Framework_TestCase
{

    /** @var  Template */
    protected $template;

    public function setUp()
    {
        $this->template = new Template();
    }

    public function testAddDataObject()
    {
        $obj1 = new DataObject( 'testName1', 'testValue1', 'This is pair 1' );
        $obj2 = new DataObject( 'testName2', 'testValue2', 'This is pair 2' );
        $data = $this->template->addData( 'testName1', 'testValue1', 'This is pair 1' )
                               ->addData( 'testName2', 'testValue2', 'This is pair 2' )
                               ->getData();
        $this->assertNotEmpty( $data );
        $this->assertCount( 2, $data );
        $this->assertEquals( $obj1, $data[0] );
        $this->assertEquals( $obj2, $data[1] );
    }

    public function testOutput()
    {
        $output = $this->template->addData( 'testName1', 'testValue1', 'This is pair 1' )
                                 ->addData( 'testName2', 'testValue2', 'This is pair 2' )
                                 ->output();
        $this->assertNotEmpty( $output );
        $this->assertCount( 2, $output );
    }
}