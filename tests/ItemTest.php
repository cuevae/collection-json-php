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
        $output = $this->item->output();
        $this->assertEquals( 'http://test.com/api/', $output->href );
        $this->assertTrue( is_array( $output->data ) );
        $this->assertTrue( is_array( $output->links ) );
    }

    public function testAddDataObject()
    {
        $obj1 = new DataObject( 'testName1', 'testValue1', 'This is pair 1' );
        $obj2 = new DataObject( 'testName2', 'testValue2', 'This is pair 2' );
        $data = $this->item->addData( 'testName1', 'testValue1', 'This is pair 1' )
                           ->addData( 'testName2', 'testValue2', 'This is pair 2' )
                           ->getData();
        $this->assertNotEmpty( $data );
        $this->assertCount( 2, $data );
        $this->assertEquals( $obj1, $data[0] );
        $this->assertEquals( $obj2, $data[1] );
    }

    public function testAddLink()
    {
        $link1 = new Link(
            new Href( 'http://test.com/api/' ),
            'test'
        );
        $link2 = new Link(
            new Href( 'http://test.com/api/' ),
            'test'
        );

        $links = $this->item->addLink( $link1 )->addLink( $link2 )->getLinks();
        $this->assertNotEmpty( $links );
        $this->assertCount( 2, $links );
        $this->assertEquals( $link1, $links[0] );
        $this->assertEquals( $link2, $links[1] );
    }

    public function testGettersAndSetters()
    {
        $this->item->addData( 'testName1', 'testValue1', 'This is pair 1' )
                   ->addData( 'testName2', 'testValue2', 'This is pair 2' )
                   ->addData( 'test_name3', 'test_value3', 'This is pair 3' );

        $this->assertEquals('testValue1', $this->item->getTestName1());
        $this->assertEquals('testValue2', $this->item->getTestName2());
        $this->assertEquals('test_value3', $this->item->getTest_name3());

        $this->item->setTestName1('testValue3', 'This is pair 3');
        $this->item->setTestName2('testValue4', 'This is pair 4');
        $this->item->setTest_name3('testValue5', 'This is pair 5');

        $this->assertEquals('testValue3', $this->item->getTestName1());
        $this->assertEquals('testValue4', $this->item->getTestName2());
        $this->assertEquals('testValue5', $this->item->getTest_name3());
    }
}
