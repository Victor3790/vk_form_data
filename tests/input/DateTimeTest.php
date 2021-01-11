<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use Brain\Monkey;

/*
** The "get_date_time" function will
** either return a sanitized or 
** a non sanitized date-time string
** in the specified format.
*/

final class DateTimeTest extends TestCase
{
    protected function setUp() : void
    {
        parent::setUp();
        Monkey\setUp();
        $_POST = array();
        $_GET = array();
    }

    //Date-time format not valid
    public function testNonValidDateTimeFormat() : void
    {
        $this->expectExceptionCode(109);

        $_GET = array( 'key' => '01/11/2021' );

        $input = new vk_form_input\Input();

        $value = $input->get_date_time( 'key', 'get', 'x-y-z' );
    }

    //Date-time value not valid
    public function testNonValidDateTimeValue() : void
    {
        $this->expectExceptionCode(109);

        $_GET = array( 'key' => 'hola' );

        $input = new vk_form_input\Input();

        $value = $input->get_date_time( 'key', 'get', 'd/m/Y' );
    }

    //Date-time value not valid
    public function testNonValidDayMonthValues() : void
    {
        $this->expectExceptionCode(110);

        $_GET = array( 'key' => '32/13/2020' );

        $input = new vk_form_input\Input();

        $value = $input->get_date_time( 'key', 'get', 'd/m/Y' );
    }

    //Returns a sanitized empty date time string
    public function testEmptyEscapedString() : void
    {
        Brain\Monkey\Functions\When( 'sanitize_text_field' )
            ->justReturn('');

        $this->expectExceptionCode(109);

        $_POST = array( 'key'=>'32/13/2020' );

        $input = new vk_form_input\Input();

        $value = $input->get_date_time( 'key', 'POST', 'd/m/Y', true );
    }

    //Returns a sanitized date string
    public function testEscapedDateString() : void
    {
        Brain\Monkey\Functions\When( 'sanitize_text_field' )
            ->returnArg();

        $_POST = array( 'key'=>'01/11/2021' );

        $input = new vk_form_input\Input();

        $value = $input->get_date_time( 'key', 'POST', 'd/m/Y', true );

        $this->assertEquals( '01/11/2021', $value );
    }

    //Returns a non sanitized date string
    public function testNonEscapedDateString() : void
    {
        Brain\Monkey\Functions\When( 'sanitize_text_field' )
            ->returnArg();

        $_POST = array( 'key'=>'01/11/2021' );

        $input = new vk_form_input\Input();

        $value = $input->get_date_time( 'key', 'POST', 'd/m/Y', false );

        $this->assertEquals( '01/11/2021', $value );
    }

    //Returns a sanitized time string
    public function testEscapedTimeString() : void
    {
        Brain\Monkey\Functions\When( 'sanitize_text_field' )
            ->returnArg();

        $_POST = array( 'key'=>'02:32 pm' );

        $input = new vk_form_input\Input();

        $value = $input->get_date_time( 'key', 'POST', 'h:i a', true );

        $this->assertEquals( '02:32 pm', $value );
    }

    //Returns a non sanitized time string
    public function testNonEscapedTimeString() : void
    {
        Brain\Monkey\Functions\When( 'sanitize_text_field' )
            ->returnArg();

        $_POST = array( 'key'=>'02:32 pm' );

        $input = new vk_form_input\Input();

        $value = $input->get_date_time( 'key', 'POST', 'h:i a', false );

        $this->assertEquals( '02:32 pm', $value );
    }

    protected function tearDown() : void
    {
        Monkey\tearDown();

        parent::tearDown();
    }
}