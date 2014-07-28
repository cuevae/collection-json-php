<?php

class ErrorTest extends PHPUnit_Framework_TestCase
{

    /** @var  \CollectionPlusJson\Error */
    protected $error;

    public function setUp()
    {
        $this->error = new \CollectionPlusJson\Error( 'testError', 'testCode', 'This is a test error' );
    }

    public function testOutput()
    {
        $output = $this->error->output();
        $this->assertEquals( 'testError', $output->title );
        $this->assertEquals( 'testCode', $output->code );
        $this->assertEquals( 'This is a test error', $output->message );
    }

}