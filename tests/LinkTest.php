<?php

class LinkTest extends PHPUnit_Framework_TestCase
{

    /** @var  \CollectionPlusJson\Link */
    protected $link;

    public function setUp()
    {
        $this->link = new \CollectionPlusJson\Link(
            new \CollectionPlusJson\Util\Href( 'http://test.com/api/' ),
            'test',
            'testLink',
            'testRender',
            'This is a test Link'
        );
    }

    public function testOutput()
    {
        $output = $this->link->_output();
        $this->assertEquals( 'http://test.com/api/', $output->href );
        $this->assertEquals( 'test', $output->rel );
        $this->assertEquals( 'testLink', $output->name );
        $this->assertEquals( 'testRender', $output->render );
        $this->assertEquals( 'This is a test Link', $output->prompt );
    }

} 