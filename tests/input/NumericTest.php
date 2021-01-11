<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use Brain\Monkey;

/*
** The "get_numeric" function will
** either return a sanitized or 
** a non sanitized numeric string.
*/

final class NumericTest extends TestCase
{
    protected function setUp() : void
    {
        parent::setUp();
        Monkey\setUp();
        $_POST = array();
        $_GET = array();
    }

    //Returns a sanitized numeric
    public function testEscapedNumeric() : void
    {
        Brain\Monkey\Functions\When( 'sanitize_text_field' )
            ->justReturn('0123');

        $_POST = array( 'key'=>'123' );

        $input = new vk_form_input\Input();

        $value = $input->get_numeric( 'key', null, true, 'POST' );

        $this->assertEquals( '0123', $value );
    }

    //Returns a sanitized empty numeric
    public function testEmptyEscapedNumeric() : void
    {
        Brain\Monkey\Functions\When( 'sanitize_text_field' )
            ->justReturn('');

        $_GET = array( 'key'=>'123' );

        $input = new vk_form_input\Input();

        $value = $input->get_string( 'key', null, true, 'get'  );

        $this->assertEquals( '', $value );
    }

    //Returns a non sanitized numeric
    public function testNonEscapedNumeric() : void
    {
        Brain\Monkey\Functions\When( 'sanitize_text_field' )
            ->justReturn('0123');

        $_POST = array( 'key'=>'123' );

        $input = new vk_form_input\Input();

        $value = $input->get_string( 'key', null, (bool)0, 'POST'  );

        $this->assertEquals( '123', $value );
    }

    //A key points to a non numeric string
    public function testANonNumericStringWasReturned(): void
    {
        $this->expectException('Exception');

        $_GET = array( 'key'=>'123zabc' );

        $input = new vk_form_input\Input();

        $input->get_numeric( 'key', 0, false, 'get' );
    }

    protected function tearDown() : void
    {
        Monkey\tearDown();

        parent::tearDown();
    }
}