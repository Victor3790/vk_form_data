<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

/*
** The key parameter is a string that
** represents an array key in $_POST 
*/

final class KeyTest extends TestCase
{
    //A key in $_POST must be passed
    public function testAPostKeyParameterMustBePassed(): void
    {
        $this->expectException('Exception');

        $input = new vk_form_input\Input();

        $input->get_string();
    }

    //The key will be tested with empty() (It must not be empty)
    public function testANonEmptyPostKeyParameterMustBePassed(): void
    {
        $this->expectException('Exception');

        $input = new vk_form_input\Input();

        $input->get_string(0, 0);
    }

    //The key can't be a number or a numeric string
    public function testThePostKeyParameterMustBeAString(): void
    {
        $this->expectException('Exception');

        $input = new vk_form_input\Input();

        $input->get_string(2, 0);
    }

    //The key can't be a number or a numeric string
    public function testThePostKeyParameterCannotBeANumericString(): void
    {
        $this->expectException('Exception');

        $input = new vk_form_input\Input();

        $input->get_string('2', 0);
    }
}