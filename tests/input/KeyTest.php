<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use vk_form_data\input\Input;

/*
** The key parameter is a string that
** represents an array key in $_POST 
*/

final class KeyTest extends TestCase
{
    protected $input;

    protected function setUp() : void
    {
        $this->input = new Input();
    }

    //A key in $_POST must be passed
    public function testAPostKeyParameterMustBePassed(): void
    {
        $this->expectExceptionCode(100);

        $this->input->get_string();
    }

    //The key will be tested with empty() (It must not be empty)
    public function testANonEmptyPostKeyParameterMustBePassed(): void
    {
        $this->expectExceptionCode(100);

        $this->input->get_string(0, 0);
    }

    //The key can't be a number or a numeric string
    public function testThePostKeyParameterMustBeAString(): void
    {
        $this->expectExceptionCode(101);

        $this->input->get_string(2, 0);
    }

    //The key can't be a number or a numeric string
    public function testThePostKeyParameterCannotBeANumericString(): void
    {
        $this->expectExceptionCode(101);

        $this->input->get_string('2', 0);
    }
}
