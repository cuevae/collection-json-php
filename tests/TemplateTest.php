<?php

use \CollectionPlusJson\Template;
use \CollectionPlusJson\DataObject;

class TemplateTest extends PHPUnit_Framework_TestCase
{

    /** @var  Template */
    protected $template;

    public function setUp()
    {
        $this->template = new Template();
    }

    public function testAddDataObject()
    {
        $obj1 = new DataObject( 'testName1', '', 'This is pair 1' );
        $obj2 = new DataObject( 'testName2', '', 'This is pair 2' );
        $data = $this->template->addData( 'testName1', 'This is pair 1' )
                               ->addData( 'testName2', 'This is pair 2' )
                               ->getData();
        $this->assertNotEmpty( $data );
        $this->assertCount( 2, $data );
        $this->assertEquals( $obj1, $data[0] );
        $this->assertEquals( $obj2, $data[1] );
    }

    public function testOutput()
    {
        $output = $this->template->addData( 'testName1', 'testValue1', 'This is pair 1' )
                                 ->addData( 'testName2', 'testValue2', 'This is pair 2' )
                                 ->output();
        $this->assertNotEmpty( $output );
        $this->assertNotEmpty( $output->data );
        $this->assertCount( 2, $output->data );
    }

    public function testQuery()
    {
        $output = $this->template->addData( 'testName1', 'testValue1', 'This is pair 1' )
                                 ->addData( 'testName2', 'testValue2', 'This is pair 2' )
                                 ->getQuery();
        $this->assertNotEmpty( $output );
    }

    public function testImportJson()
    {
        $version = "1.0.1";
        $json = <<<EOT
{ "template" : {
    "data" : [
      {"name" : "name", "value" : "W. Chandry"},
      {"name" : "email", "value" : "wchandry@example.org"},
      {"name" : "blog", "value" : "http://example.org/blogs/wchandry"},
      {"name" : "avatar", "value" : "http://example.org/images/wchandry"}
    ]
  }
}
EOT;
        $template = new \CollectionPlusJson\Template(json_decode($json, true));

        //test the links
        $this->assertEquals('W. Chandry', $template->getName());
        $this->assertEquals('wchandry@example.org', $template->getEmail());
        $this->assertEquals('http://example.org/blogs/wchandry', $template->getBlog());
        $this->assertEquals('http://example.org/images/wchandry', $template->getAvatar());
    }
}
