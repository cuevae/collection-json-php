<?php

use \CollectionPlusJson\DataObject;

class DataObjectTest extends PHPUnit_Framework_TestCase
{

    /** @var  DataObject */
    protected $object;

    public function setUp()
    {
        $this->object = new DataObject( 'testObject', 'testValue', 'This is a test DataObject' );
    }

    public function testSetMethod()
    {
        $set = 'TEST';
        $this->object->setTestObject($set);
        $this->assertEquals( $set,  $this->object->getTestObject() );
    }

    public function testGetMethod()
    {
        $this->assertEquals( 'testValue', $this->object->getTestObject() );
    }

    public function testOutput()
    {
        $output = $this->object->output();
        $this->assertEquals( 'testObject', $output->name );
        $this->assertEquals( 'testValue', $output->value );
        $this->assertEquals( 'This is a test DataObject', $output->prompt );
    }
}
