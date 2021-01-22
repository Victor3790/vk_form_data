<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

/*
** The key parameter is a string that
** represents an array key in $_POST 
*/

final class FormatTest extends TestCase
{
    //A date time format must be passed
    public function testFormatParameterMustBePassed(): void
    {
        $this->expectExceptionCode(107);

        $input = new vk_form_data\input\Input();

        $input->get_date_time( 'key', 'post' );
    }

    //The format will be tested with empty() (It must not be empty)
    public function testANonEmptyFormatParameterMustBePassed(): void
    {
        $this->expectExceptionCode(107);

        $input = new vk_form_data\input\Input();

        $input->get_date_time('key', 'post', false);
    }

    //The format can't be a number or a numeric string
    public function testTheFormatParameterMustBeAString(): void
    {
        $this->expectExceptionCode(108);

        $input = new vk_form_data\input\Input();

        $input->get_date_time( 'key', 'post', 1 );
    }

    //The format can't be a number or a numeric string
    public function testTheFormatParameterCannotBeANumericString(): void
    {
        $this->expectExceptionCode(108);

        $input = new vk_form_data\input\Input();

        $input->get_date_time( 'key', 'post', '5' );
    }
}