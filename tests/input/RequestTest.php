<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

/*
** The "request" parameter should contain the
** type of http request the data is passed by.
*/

final class RequestTest extends TestCase
{
    protected function setUp() : void
    {
        parent::setUp();
        $_POST  = array();
        $_GET   = array();
    }

    //An http request type must be passed
    public function testAnHttpRequestTypeMustBePassed(): void
    {
        $this->expectException('Exception');

        $input = new vk_form_input\Input();

        $input->get_string( 'key', null, true );
    }

    //The "request" parameter must be a string
    public function testRequestMustBeAString(): void
    {
        $this->expectException('Exception');

        $input = new vk_form_input\Input();

        $input->get_string( 'key', null, true, 1 );
    }

    //The "request" parameter must be a non numeric string
    public function testRequestMustBeANonNumericString(): void
    {
        $this->expectException('Exception');

        $input = new vk_form_input\Input();

        $input->get_string( 'key', null, true, '1' );
    }

    //The "request" parameter must be "POST" or "GET"
    public function testRequestMustBePostOrGet(): void
    {
        $this->expectException('Exception');

        $input = new vk_form_input\Input();

        $input->get_string( 'key', null, true, 'request' );
    }

    //Request can be upper case
    public function testRequestCanBeUpperCase(): void
    {
        $_POST = array( 'post_key' => 'post_value' );
        $_GET  = array( 'get_key' => 'get_value' );

        $input = new vk_form_input\Input();

        $value = $input->get_string( 'get_key', null, false, 'GET' );

        $this->assertEquals( 'get_value', $value );
    }

    //Request can be lower case
    public function testRequestCanBeLowerCase(): void
    {
        $_POST = array( 'post_key' => 'post_value' );
        $_GET  = array( 'get_key' => 'get_value' );

        $input = new vk_form_input\Input();

        $value = $input->get_string( 'get_key', null, false, 'get' );

        $this->assertEquals( 'get_value', $value );
    }

    //Request can be upper and lower case
    public function testRequestCanBeUpperAndLowerCase(): void
    {
        $_POST = array( 'post_key' => 'post_value' );
        $_GET  = array( 'get_key' => 'get_value' );

        $input = new vk_form_input\Input();

        $value = $input->get_string( 'post_key', null, false, 'PoSt' );

        $this->assertEquals( 'post_value', $value );
    }

}