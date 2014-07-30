<?php

namespace Tests\Util\Parser;

use CollectionPlusJson\Util\Href;
use \CollectionPlusJson\Util\Parser\Item as ItemParser;

class ItemMock extends ItemParser
{
    const HREF_KEY = 'test_href';
}

class ItemTest extends \PHPUnit_Framework_TestCase
{

    /** @var  ItemParser */
    protected $parser;

    public function setUp()
    {
        $this->parser = new ItemMock();
    }

    /**
     * @expectedException \Exception
     */
    public function testParseFromArrayException()
    {
        $this->parser->parseOneFromArray(array());
    }

    /**
     *
     */
    public function testParseOneFromArray()
    {
        $itemHref = 'http://test.io/item/1';

        $input = array(
            'href' => $itemHref,
            'data' => array(
                array( 'id', 1, 'This is the item id' ),
                array( 'name', 'bar', 'This is the item name' ),
                array( 'value', 'foo', 'This is the item value' ),
                array( 'timestamp', 1608897600 ),
            )
        );

        $controlItem = new \CollectionPlusJson\Item(new Href($itemHref));
        $controlItem->addData('id', 1, 'This is the item id');
        $controlItem->addData('name', 'bar', 'This is the item name');
        $controlItem->addData('value', 'foo', 'This is the item value');
        $controlItem->addData('timestamp', 1608897600);

        /** @var \CollectionPlusJson\Util\Parser\Item $mock */
        $mock = $this->getMock('\CollectionPlusJson\Util\Parser\Item',
                               array( 'itemInit',
                                      'hasRequiredKeys',
                                      'isValidDataArray'
                               )
        );

        $mock->expects($this->once())
             ->method('hasRequiredKeys')
             ->with($input)
             ->willReturn(true);

        $mock->expects($this->once())
             ->method('itemInit')
             ->with($input)
             ->willReturn(new \CollectionPlusJson\Item(new Href($itemHref)));

        $mock->expects($this->once())
             ->method('isValidDataArray')
             ->with($input['data'])
             ->willReturn(true);

        $result = $mock->parseOneFromArray($input);
        $this->assertInstanceOf('\CollectionPlusJson\Item', $result);
        $this->assertEquals($controlItem, $result);
    }

    /**
     *
     */
    public function testParseManyFromArray()
    {
        $input = array(
            array(
                'href' => 'http://test.io/item/1',
                'data' => array(
                    array( 'id', 1, 'This is the item id' ),
                    array( 'name', 'bar', 'This is the item name' ),
                    array( 'value', 'foo', 'This is the item value' ),
                    array( 'timestamp', 1608897600 )
                )
            ),
            array(
                'href' => 'http://test.io/item/2',
                'data' => array(
                    array( 'id', 2, 'This is the item id' ),
                    array( 'name', 'den', 'This is the item name' ),
                    array( 'value', 'tas', 'This is the item value' ),
                    array( 'timestamp', 1608897600 ),
                )
            )
        );

        $controlItem1 = new \CollectionPlusJson\Item(new Href('http://test.io/item/1'));
        $controlItem1->addData('id', 1, 'This is the item id');
        $controlItem1->addData('name', 'bar', 'This is the item name');
        $controlItem1->addData('value', 'foo', 'This is the item value');
        $controlItem1->addData('timestamp', 1608897600);

        $controlItem2 = new \CollectionPlusJson\Item(new Href('http://test.io/item/2'));
        $controlItem2->addData('id', 2, 'This is the item id');
        $controlItem2->addData('name', 'den', 'This is the item name');
        $controlItem2->addData('value', 'tas', 'This is the item value');
        $controlItem2->addData('timestamp', 1608897600);

        $controlItems = array(
            $controlItem1,
            $controlItem2
        );

        /** @var \CollectionPlusJson\Util\Parser\Item $mock */
        $mock = $this->getMock('\CollectionPlusJson\Util\Parser\Item',
                               array( 'hasRequiredKeys',
                                      'isValidDataArray' )
        );

        $mock->expects($this->exactly(count($controlItems)))
             ->method('hasRequiredKeys')
             ->willReturn(true);

        $mock->expects($this->exactly(count($controlItems)))
             ->method('isValidDataArray')
             ->willReturn(true);

        $result = $mock->parseManyFromArray($input);
        $this->assertEquals($controlItems, $result);
    }


    /**
     * @dataProvider requiredKeysProvider
     */
    public function testHasRequiredKeys($input, $expected)
    {
        $this->assertEquals($expected, $this->parser->hasRequiredKeys($input));
    }

    /**
     * @param $input
     * @param $expected
     *
     * @dataProvider isValidDataArrayProvider
     */
    public function testIsValidDataArray($input, $expected)
    {
        $this->assertEquals($expected, $this->parser->isValidDataArray($input));
    }

    public function requiredKeysProvider()
    {
        return array(
            array( array( ItemMock::HREF_KEY => '' ), true ),
            array( array( 'foo' => '' ), array( ItemMock::HREF_KEY ) ),
            array( array(), array( ItemMock::HREF_KEY ) )
        );
    }

    public function isValidDataArrayProvider()
    {
        return array(

            //Valid data
            array( array( 'data' => array( 'name', 'value' ) ), true ),
            array( array( 'data' => array( 'name' => 'name', 'value' => 'value' ) ), true ),
            array( array( 'data' => array( 'name', '' ) ), true ),
            array( array( 'data' => array( 'name', 1 ) ), true ),
            array( array( 'data' => array( 'name', 1.0 ) ), true ),
            array( array( 'data' => array( 'name', array() ) ), true ),
            array( array( 'data' => array( 'name', true ) ), true ),
            array( array( 'data' => array( 'name', null ) ), true ),
            array( array( 'data' => array( 'name', new \StdClass() ) ), true ),

            //Invalid data
            array( array( 'data' => array( '', '' ) ), false ),
            array( array( 'data' => array( '', 'value' ) ), false ),
            array( array( 'data' => array() ), false ),
            array( array( 'data' => array( 'foo' => 'bar' ) ), false ),
            array( array( 'data' => array( 'name' => '', 'value' => '' ) ), false ),
        );
    }

} 