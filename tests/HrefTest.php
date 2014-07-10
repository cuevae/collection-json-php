<?php

use \CollectionPlusJson\Util\Href;

class HrefTest extends PHPUnit_Framework_TestCase
{

    /** @var  \CollectionPlusJson\Util\Href */
    protected $href;

    public function setUp()
    {
        $this->href = new Href( 'http://test.com/api/' );
    }

    /**
     * @param $uri
     *
     * @dataProvider validUris
     */
    public function testAcceptedUris($uri)
    {
        $href = new Href($uri);
        $this->assertInstanceOf('\CollectionPlusJson\Util\Href', $href);
    }

    /**
     * @param $uri
     *
     * @dataProvider invalidUris
     *
     * @expectedException Exception
     */
    public function testNonAcceptedUris($uri)
    {
        $href = new Href($uri);
    }

    public function testOutput()
    {
        $this->assertEquals( 'http://test.com/api/', $this->href->_output() );
    }

    public function validUris()
    {
        return array(
            array('http://api.estimate.local'),
            array('http://test.com/api/'),
            array('http://test.com/api/test/1'),
            array('http://test.com/api/1/test'),
            array('http://test.com/api/1/2'),
            array('http://test.com/api/1/2/test/'),
            array('test.com/api/1/2/test/'),
            array('/'),
            array('/test/1'),
            array('/1/2'),
            array('/1/test'),
        );
    }

    public function invalidUris()
    {
        return array(
            array('http://api.estimate.local.'),
            array('http://api.estimate.local._'),
            array('htp://api.estimate.local'),
            array('http//api.estimate.local'),
            array('http:/api.estimate.local'),
            array('http:api.estimate.local'),
            array('http://api..estimate.local'),
            array('http://api.estimate.local//'),
            array('http://api.estimate.local/test//1/'),
            array('http://api.estimate.local/test/1//'),
            array('.'),
            array('//'),
            array('..'),
            array('./'),
            array('./estimate.local'),
        );
    }

} 