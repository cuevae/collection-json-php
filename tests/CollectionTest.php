<?php

use CollectionPlusJson\Template;
use CollectionPlusJson\Error;
use CollectionPlusJson\Link;
use CollectionPlusJson\Item;
use CollectionPlusJson\Query;
use CollectionPlusJson\Util\Href;

class CollectionTest extends PHPUnit_Framework_TestCase
{

    /** @var  \CollectionPlusJson\Collection */
    protected $collection;

    public function setUp()
    {
        $version = '0.0.1';
        $href = new \CollectionPlusJson\Util\Href( 'http://test.com/api/' );
        $this->collection = new \CollectionPlusJson\Collection( $version, $href );
    }

    public function testOutput()
    {
        $this->collection->setTemplate( new Template() )->setError( new Error( 'testError', 'testCode', 'This is a test error object' ) );
        $output = $this->collection->_output();
        $this->assertEquals( '0.0.1', $output->version );
        $this->assertEquals( 'http://test.com/api/', $output->href );
        $this->assertTrue( is_array( $output->links ) );
        $this->assertTrue( is_array( $output->items ) );
        $this->assertTrue( is_array( $output->queries ) );
        $this->assertNotNull( $output->template );
        $this->assertNotNull( $output->error );
    }

    public function testAddLink()
    {
        $link = new Link( new Href( 'http://test.com/api/' ), 'test' );
        $links = $this->collection->addLink( $link )->getLinks();
        $this->assertCount( 1, $links );
        $this->assertEquals( $link, $links[0] );
    }

    public function testAddItem()
    {
        $item = new Item( new Href( 'http://test.com/api/' ) );
        $items = $this->collection->addItem( $item )->getItems();
        $this->assertCount( 1, $items );
        $this->assertEquals( $item, $items[0] );
    }

    public function testAddQuery()
    {
        $query = new Query( new Href( 'http://test.com/api/' ), 'test' );
        $queries = $this->collection->addQuery( $query )->getQueries();
        $this->assertCount( 1, $queries );
        $this->assertEquals( $query, $queries[0] );
    }

} 