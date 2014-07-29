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
        $href = new \CollectionPlusJson\Util\Href( 'http://test.com/api/' );
        $this->collection = new \CollectionPlusJson\Collection( $href );
    }

    public function testOutput()
    {
        $this->collection->setTemplate( new Template() )
            ->setError( new Error( 'testError', 'testCode', 'This is a test error object' ) );
        $wrapper = $this->collection->output();
        $collection = $wrapper->collection;
        $this->assertEquals( '0.1.0', $collection->version );
        $this->assertEquals( 'http://test.com/api/', $collection->href );
        $this->assertTrue( is_array( $collection->links ) );
        $this->assertTrue( is_array( $collection->items ) );
        $this->assertTrue( is_array( $collection->queries ) );
        $this->assertNotNull( $collection->template );
        $this->assertNotNull( $collection->error );
    }

    public function testGetHref()
    {
        $href = $this->collection->getHref();
        $this->assertInstanceOf('\collectionPlusJson\Util\Href', $href);
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