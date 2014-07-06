<?php

class HrefTest extends PHPUnit_Framework_TestCase
{

    /** @var  \CollectionPlusJson\Util\Href */
    protected $href;

    public function setUp()
    {
        $this->href = new \CollectionPlusJson\Util\Href( 'http://test.com/api/' );
    }

    public function testOutput()
    {
        $this->assertEquals( 'http://test.com/api/', $this->href->_output() );
    }

} 