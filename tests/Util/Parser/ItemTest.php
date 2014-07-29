<?php

namespace Tests\Util\Parser;

use CollectionPlusJson\Util\Href;
use \CollectionPlusJson\Util\Parser\Item as ItemParser;

class ItemMock extends ItemParser
{
    const HREF_KEY = 'test_href';
    const DATA_KEY = 'test_data';
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
        $input = array( 'href' => 'http://test.io/' );

        /** @var \CollectionPlusJson\Util\Parser\Item $mock */
        $mock = $this->getMock('\CollectionPlusJson\Util\Parser\Item',
                               array( 'itemInit', 'hasRequiredKeys' )
        );

        $mock->expects($this->once())
             ->method('hasRequiredKeys')
             ->with($input)
             ->willReturn(true);

        $mock->expects($this->once())
             ->method('itemInit')
             ->with($input)
             ->willReturn(new \CollectionPlusJson\Item(new Href('http://test.io')));

        $this->assertInstanceOf('\CollectionPlusJson\Item', $mock->parseOneFromArray($input));
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
            array( array( 'data' => array( 'name' => '' ) ), true ),
            array( array( 'data' => array() ), false ),
            array( array( 'data' => array( 'foo' => 'bar' ) ), false ),
        );
    }

} 