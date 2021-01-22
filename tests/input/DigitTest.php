<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use Brain\Monkey;

/*
** The "get_digit" function will
** either return a sanitized or 
** a non sanitized digit string.
*/

final class DigitTest extends TestCase
{
    protected function setUp() : void
    {
        parent::setUp();
        Monkey\setUp();
        $_POST = array();
        $_GET = array();
    }

    //Returns a sanitized numeric
    public function testEscapedDigit() : void
    {
        Brain\Monkey\Functions\When( 'sanitize_text_field' )
            ->justReturn('0123');

        $_POST = array( 'key'=>'123' );

        $input = new vk_form_input\Input();

        $value = $input->get_digit( 'key', 'POST', true );

        $this->assertEquals( '0123', $value );
    }

    //Returns a sanitized empty numeric
    public function testEmptyEscapedDigit() : void
    {
        Brain\Monkey\Functions\When( 'sanitize_text_field' )
            ->justReturn('');

        $_GET = array( 'key'=>'123' );

        $input = new vk_form_input\Input();

        $value = $input->get_digit( 'key', 'get', true );

        $this->assertEquals( '', $value );
    }

    //Returns a non sanitized numeric
    public function testNonEscapedDigit() : void
    {
        Brain\Monkey\Functions\When( 'sanitize_text_field' )
            ->justReturn('0123');

        $_POST = array( 'key'=>'123' );

        $input = new vk_form_input\Input();

        $value = $input->get_digit( 'key', 'POST', (bool)0 );

        $this->assertEquals( '123', $value );
    }

    //A key points to a non numeric string
    public function testANonDigitStringWasReturned(): void
    {
        $this->expectExceptionCode(111);

        $_GET = array( 'key'=>'123zabc' );

        $input = new vk_form_input\Input();

        $input->get_digit( 'key', 'get', false );
    }

    protected function tearDown() : void
    {
        Monkey\tearDown();

        parent::tearDown();
    }
}