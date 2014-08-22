<?php

class QueryTest extends PHPUnit_Framework_TestCase
{

    /** @var  \CollectionPlusJson\Query */
    protected $query;

    public function setUp()
    {
        $this->query = new \CollectionPlusJson\Query(
            new \CollectionPlusJson\Util\Href( 'http://test.com/api/' ),
            'test',
            'This is a test Query',
            array()
        );
    }

    public function testOutput()
    {
        $output = $this->query->output();
        $this->assertEquals( 'http://test.com/api/', $output->href );
        $this->assertEquals( 'test', $output->rel );
        $this->assertEquals( 'This is a test Query', $output->prompt );
        $this->assertTrue( is_array( $output->data ) );
        $this->assertEmpty( $output->data );
    }

    public function testAddData()
    {
        $pair1 = new \CollectionPlusJson\DataObject( 'testName', 'testValue' );
        $data = $this->query->addData( 'testName', 'testValue' )->getData();
        $this->assertTrue( is_array( $data ) );
        $this->assertCount( 1, $data );
        $this->assertEquals( $pair1, $data[0] );
    }
}