<?php

use \CollectionPlusJson\Item;
use \CollectionPlusJson\Util\Href;
use \CollectionPlusJson\DataObject;
use \CollectionPlusJson\Link;

class ItemTest extends PHPUnit_Framework_TestCase
{

    /** @var  Item */
    protected $item;

    public function setUp()
    {
        $this->item = new Item( new Href( 'http://test.com/api/' ) );
    }

    public function testOutput()
    {
        $output = $this->item->_output();
        $this->assertEquals( 'http://test.com/api/', $output->href );
        $this->assertTrue( is_array( $output->data ) );
        $this->assertTrue( is_array( $output->links ) );
    }

    public function testAddDataObject()
    {
        $o1 = new DataObject( 'testName1', 'testValue1', 'This is pair 1' );
        $o2 = new DataObject( 'testName2', 'testValue2', 'This is pair 2' );
        $data = $this->item->addData( $o1 )->addData( $o2 )->getData();
        $this->assertNotEmpty( $data );
        $this->assertCount( 2, $data );
        $this->assertEquals( $o1, $data[0] );
        $this->assertEquals( $o2, $data[1] );
    }

    public function testAddLink()
    {
        $l1 = new Link(
            new Href( 'http://test.com/api/' ),
            'test'
        );
        $l2 = new Link(
            new Href( 'http://test.com/api/' ),
            'test'
        );

        $links = $this->item->addLink( $l1 )->addLink( $l2 )->getLinks();
        $this->assertNotEmpty( $links );
        $this->assertCount( 2, $links );
        $this->assertEquals( $l1, $links[0] );
        $this->assertEquals( $l2, $links[1] );
    }

} 