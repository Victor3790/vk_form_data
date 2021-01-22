<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

/*
** Validation should have the parameters to
** consider to validate the data received.
*/

final class ValidationTest extends TestCase
{
    //"Validation" must be passed
    public function testValidationMustBePassed(): void
    {
        $this->expectExceptionCode(208);

        $form_data = new vk_form_data\Data( new vk_form_data\input\Input );

        $options = [
            [
                'input_name' => 'user_name',
                'type' => 'string'
            ]
        ];

        $form_data->set_options( $options, 'get' );

        $form_data->get();
    }

    //"Validation" must be an array
    public function testValidationMustBeAnArray(): void
    {
        $this->expectExceptionCode(208);

        $form_data = new vk_form_data\Data( new vk_form_data\input\Input );

        $options = [
            [
                'input_name' => 'user_name',
                'type' => 'string',
                'validation' => 4
            ]
        ];

        $form_data->set_options( $options, 'get' );

        $form_data->get();
    }

    //"Validation" can not be an empty array
    public function testValidationCanNotBeAnEmptyArray(): void
    {
        $this->expectExceptionCode(208);

        $form_data = new vk_form_data\Data( new vk_form_data\input\Input );

        $options = [
            [
                'input_name' => 'user_name',
                'type' => 'string',
                'validation' => array()
            ]
        ];

        $form_data->set_options( $options, 'get' );

        $form_data->get();
    }
}