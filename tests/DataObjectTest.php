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

    public function testOutput()
    {
        $output = $this->object->_output();
        $this->assertEquals( 'testObject', $output->name );
        $this->assertEquals( 'testValue', $output->value );
        $this->assertEquals( 'This is a test DataObject', $output->prompt );
    }

} 