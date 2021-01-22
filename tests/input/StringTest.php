<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use Brain\Monkey;

/*
** The "get_string" function will
** either return a sanitized or 
** a non sanitized string.
*/

final class StringTest extends TestCase
{
    protected function setUp() : void
    {
        parent::setUp();
        Monkey\setUp();
        $_POST = array();
    }

    //Returns a sanitized string
    public function testEscapedString() : void
    {
        Brain\Monkey\Functions\When( 'sanitize_text_field' )
            ->justReturn('sanitized value');

        $_POST = array( 'key'=>'value' );

        $input = new vk_form_data\input\Input();

        $value = $input->get_string( 'key', 'POST', true );

        $this->assertEquals( 'sanitized value', $value );
    }

    //Returns a sanitized empty string
    public function testEmptyEscapedString() : void
    {
        Brain\Monkey\Functions\When( 'sanitize_text_field' )
            ->justReturn('');

        $_POST = array( 'key'=>'value' );

        $input = new vk_form_data\input\Input();

        $value = $input->get_string( 'key', 'POST', true );

        $this->assertEquals( '', $value );
    }

    //Returns a non sanitized string
    public function testNonEscapedString() : void
    {
        Brain\Monkey\Functions\When( 'sanitize_text_field' )
            ->justReturn('sanitized value');

        $_POST = array( 'key'=>'value' );

        $input = new vk_form_data\input\Input();

        $value = $input->get_string( 'key', 'POST', (bool)0  );

        $this->assertEquals( 'value', $value );
    }

    protected function tearDown() : void
    {
        Monkey\tearDown();

        parent::tearDown();
    }
}