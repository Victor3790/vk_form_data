<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

/*
** Input name should have the name attribute
** of the input element in the html form
*/

final class InputNameTest extends TestCase
{
    //"Input_name" must be passed
    public function testInputNameMustBePassed(): void
    {
        $this->expectExceptionCode(206);

        $form_data = new vk_form_data\Data( new vk_form_data\input\Input );

        $options = [
            [
                'input' => 1
            ]
        ];

        $form_data->set_options( $options, 'get' );

        $form_data->get();
    }

    //"Input_name" must be a string
    public function testInputNameMustBeString(): void
    {
        $this->expectExceptionCode(206);

        $form_data = new vk_form_data\Data( new vk_form_data\input\Input );

        $options = [
            [
                'input_name' => 1
            ]
        ];

        $form_data->set_options( $options, 'get' );

        $form_data->get();
    }

    //"Input_name" can not be a numeric string
    public function testInputNameCanNotBeANumericString(): void
    {
        $this->expectExceptionCode(206);

        $form_data = new vk_form_data\Data( new vk_form_data\input\Input );

        $options = [
            [
                'input_name' => '10'
            ]
        ];

        $form_data->set_options( $options, 'get' );

        $form_data->get();
    }
}