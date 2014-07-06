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
        $o1 = new DataObject( 'testName1', 'testValue1', 'This is pair 1' );
        $o2 = new DataObject( 'testName2', 'testValue2', 'This is pair 2' );
        $data = $this->template->addData( $o1 )->addData( $o2 )->getData();
        $this->assertNotEmpty( $data );
        $this->assertCount( 2, $data );
        $this->assertEquals( $o1, $data[0] );
        $this->assertEquals( $o2, $data[1] );
    }

    public function testOutput()
    {
        $o1 = new DataObject( 'testName1', 'testValue1', 'This is pair 1' );
        $o2 = new DataObject( 'testName2', 'testValue2', 'This is pair 2' );
        $output = $this->template->addData( $o1 )->addData( $o2 )->_output();
        $this->assertNotEmpty( $output );
        $this->assertCount( 2, $output );
    }

} 