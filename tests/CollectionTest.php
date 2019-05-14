<?php

use CollectionPlusJson\Template;
use CollectionPlusJson\Error;
use CollectionPlusJson\Link;
use CollectionPlusJson\Item;
use CollectionPlusJson\Query;
use CollectionPlusJson\Util\Href;

class CollectionTest extends PHPUnit_Framework_TestCase
{
    /** @var  string */
    protected $href = 'http://test.com/api/';

    /** @var  \CollectionPlusJson\Collection */
    protected $collection;

    public function setUp()
    {
        $this->assertEquals('http://test.com/api/', $this->href);
        $this->collection = new \CollectionPlusJson\Collection( $this->href );
    }

    public function testOutput()
    {
        $this->collection->setTemplate( new Template() )
            ->setError( new Error( 'testError', 'testCode', 'This is a test error object' ) );
        $wrapper = $this->collection->output();
        $collection = $wrapper->collection;
        $this->assertNotEmpty( $collection->version );
        $this->assertEquals( $this->href, $collection->href );
        //$this->assertTrue( is_array( $collection->links ) );
        //$this->assertTrue( is_array( $collection->items ) );
        //$this->assertTrue( is_array( $collection->queries ) );
        $this->assertNotNull( $collection->template );
        $this->assertNotNull( $collection->error );
    }

    public function testGetHref()
    {
        $href = $this->collection->getHref();
        $this->assertEquals($this->href, $href->getUrl());
    }

    public function testAddLink()
    {
        $link = new Link( new Href( $this->href ), 'test' );
        $links = $this->collection->addLink( $link )->getLinks();
        $this->assertCount( 1, $links );
        $this->assertEquals( $link, $links[0] );
    }

    public function testAddItem()
    {
        $item = new Item( new Href( $this->href ) );
        $items = $this->collection->addItem( $item )->getItems();
        $this->assertCount( 1, $items );
        $this->assertEquals( $item, $items[0] );
    }

    public function testGetFirstItem()
    {
        $item = new Item( new Href( $this->href ) );
        $this->collection->addItem( $item );
        $item = new Item( new Href('test') );
        $this->collection->addItem( $item );

        $item = $this->collection->getFirstItem();
        $this->assertTrue($item !== null);
        $this->assertEquals($item->getHref()->getUrl(), $this->href );
    }
    public function testAddQuery()
    {
        $query = new Query( new Href( $this->href ), 'test' );
        $queries = $this->collection->addQuery( $query )->getQueries();
        $this->assertCount( 1, $queries );
        $this->assertEquals( $query, $queries[0] );
    }

    public function testImportJson()
    {
        $version = "1.0.1";
        $json = <<<EOT
{
    "collection": {
        "version": "{$version}",
        "href": "{$this->href}",
        "links": [
            {
                "href": "{$this->href}test",
                "rel": "REL",
                "prompt": "PROMPT",
                "name": "NAME",
                "render": "RENDER"
            }
        ],
        "items": [
        {
                "href": "{$this->href}test/1",
                "data": [
                    {
                        "name": "VALUE1",
                        "value": "VALUE1",
                        "prompt": "VALUE1"
                    },
                    {
                        "name": "VALUE2",
                        "value": "VALUE2",
                        "prompt": "VALUE2"
                    }
                ],
                "links": [
                    {
                        "href": "{$this->href}test/link1",
                        "rel": "REL1",
                        "prompt": "PROMPT1",
                        "name": "NAME1",
                        "render": "RENDER1"
                    },
                    {
                        "href": "{$this->href}test/link2",
                        "rel": "REL2",
                        "prompt": "PROMPT2",
                        "name": "NAME2",
                        "render": "RENDER2"
                    }
                ]
            }
        ],
        "queries": [
            {
                "href": "{$this->href}test/search",
                "rel": "REL",
                "prompt": "SEARCH",
                "data": [
                    {
                        "name": "search",
                        "value": null,
                        "prompt": ""
                    }
                ]
            }
        ],
        "template": [
            {
                "name": "field1",
                "value": "",
                "prompt": "FIELD1"
            },
            {
                "name": "field2",
                "value": "",
                "prompt": "FIELD2"
            }
        ],
        "error": {
            "title": "ERROR_TITLE",
            "code": 404,
            "message": "ERROR MESSAGE"
        }
    }
}
EOT;
        $collection = new \CollectionPlusJson\Collection(json_decode($json, true));
        $href = $collection->getHref();
        $this->assertEquals($version, $collection->getVersion());
        $this->assertEquals($this->href, $collection->getHref()->getUrl());

        //test the links
        $link = $collection->getLinks()[0];
        $this->assertEquals('http://test.com/api/test', $link->getHref()->getUrl());
        $this->assertEquals('REL', $link->getRel());
        $this->assertEquals('PROMPT', $link->getPrompt());
        $this->assertEquals('NAME', $link->getName());
        $this->assertEquals('RENDER', $link->getRender());

        //test the items
        $item = $collection->getItems()[0];
        $data = $item->getData()[1];
        $this->assertEquals('http://test.com/api/test/1', $item->getHref()->getUrl());
        $this->assertEquals('VALUE2', $data->getName());

        //test the link items
        $itemLink = $item->getLinks()[0];
        $this->assertEquals('http://test.com/api/test/link1', $itemLink->getHref()->getUrl());

        //test the queries
        $query = $collection->getQueries()[0];
        $data = $query->getData()[0];
        $this->assertEquals('http://test.com/api/test/search', $query->getHref()->getUrl());
        $this->assertEquals('REL', $query->getRel());
        $this->assertEquals('search', $data->getName());

        //test the template
        $template = $collection->getTemplate();
        $item = $template->getData()[0];
        $this->assertEquals('field1', $item->getName());
        $this->assertEquals('FIELD1', $item->getPrompt());

        //test the error
        $error = $collection->getError();
        $this->assertEquals('ERROR_TITLE', $error->getTitle());
        $this->assertEquals(404, $error->getCode());
        $this->assertEquals('ERROR MESSAGE', $error->getMessage());
    }
}
