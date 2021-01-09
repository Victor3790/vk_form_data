<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use Brain\Monkey;

/*
** The "escape" param must be boolean, 
** it defines if the string will be
** sanitized or not. Its default value
** is false. 
*/

final class EscapeTest extends TestCase
{
    protected function setUp() : void
    {
        parent::setUp();
        Monkey\setUp();
        $_POST = array();
    }

    //A non boolean value is passed as "escape"
    public function testEscapeMustBeBooleanNotInt() : void
    {
        $this->expectException('Exception');

        $_POST = array( 'key'=>'value' );

        $input = new vk_form_input\Input();

        $input->get_string( 'key', null, 1 );
    }

    //A non boolean value is passed as "escape"
    public function testEscapeMustBeBooleanNotString() : void
    {
        $this->expectException('Exception');

        $_POST = array( 'key'=>'value' );

        $input = new vk_form_input\Input();

        $input->get_string( 'key', null, 'falso' );
    }

    protected function tearDown() : void
    {
        Monkey\tearDown();

        parent::tearDown();
    }
}