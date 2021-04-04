<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use vk_form_data\input\Input;

/*
** The "request" parameter should contain the
** type of http request the data is passed by.
*/

final class RequestTest extends TestCase
{
    protected $input;

    protected function setUp() : void
    {
        $_POST  = array( 'post_key' => 'post_value' );
        $_GET   = array( 'get_key' => 'get_value' );
        $this->input = new Input();
    }

    //An http request type must be passed
    public function testAnHttpRequestTypeMustBePassed(): void
    {
        $this->expectExceptionCode(102);

        $this->input->get_string( 'key' );
    }

    //The "request" parameter must be a string
    public function testRequestMustBeAString(): void
    {
        $this->expectExceptionCode(103);

        $this->input->get_string( 'key', 1 );
    }

    //The "request" parameter must be a non numeric string
    public function testRequestMustBeANonNumericString(): void
    {
        $this->expectExceptionCode(103);

        $this->input->get_string( 'key', '1' );
    }

    //The "request" parameter must be "POST" or "GET"
    public function testRequestMustBePostOrGet(): void
    {
        $this->expectExceptionCode(104);

        $this->input->get_string( 'key', 'request' );
    }

    //Request can be upper case
    public function testRequestCanBeUpperCase(): void
    {
        $value = $this->input->get_string( 'get_key', 'GET' );

        $this->assertEquals( 'get_value', $value );
    }

    //Request can be lower case
    public function testRequestCanBeLowerCase(): void
    {
        $value = $this->input->get_string( 'get_key', 'get' );

        $this->assertEquals( 'get_value', $value );
    }

    //Request can be upper and lower case
    public function testRequestCanBeUpperAndLowerCase(): void
    {
        $value = $this->input->get_string( 'post_key', 'PoSt' );

        $this->assertEquals( 'post_value', $value );
    }

}
