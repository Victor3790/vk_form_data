<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

final class InputTest extends TestCase
{
    protected function setUp() : void
    {
        parent::setUp();
        $_POST = array();
    }

    public function testAPostKeyParameterMustBePassed(): void
    {
        $this->expectException('Exception');

        $input = new vk_form_input\Input();

        $input->get_string_post();
    }

    public function testANonEmptyPostKeyParameterMustBePassed(): void
    {
        $this->expectException('Exception');

        $input = new vk_form_input\Input();

        $input->get_string_post(0, 0);
    }

    public function testThePostKeyParameterMustBeAString(): void
    {
        $this->expectException('Exception');

        $input = new vk_form_input\Input();

        $input->get_string_post(2, 0);
    }

    public function testThePostKeyParameterCannotBeANumericString(): void
    {
        $this->expectException('Exception');

        $input = new vk_form_input\Input();

        $input->get_string_post('2', 0);
    }

    public function testGetPostString(): void
    {
        $_POST = array( 'key'=>'value' );

        $input = new vk_form_input\Input();

        $value = $input->get_string_post('key', 'no data');

        $this->assertEquals( 'value', $value );
    }
}