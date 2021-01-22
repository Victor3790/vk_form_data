<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

/*
** Type should have the type of data
** to be retrieved.
*/

final class TypeTest extends TestCase
{
    //"Type" must be passed
    public function testTypeMustBePassed(): void
    {
        $this->expectExceptionCode(207);

        $form_data = new vk_form_data\Data( new vk_form_data\input\Input );

        $options = [
            [
                'input_name' => 'user_name'
            ]
        ];

        $form_data->set_options( $options, 'get' );

        $form_data->get();
    }

    //"Type" must be a string
    public function testTypeMustBeString(): void
    {
        $this->expectExceptionCode(207);

        $form_data = new vk_form_data\Data( new vk_form_data\input\Input );

        $options = [
            [
                'input_name' => 'user_name',
                'type' => 5
            ]
        ];

        $form_data->set_options( $options, 'get' );

        $form_data->get();
    }

    //"Type" can not be a numeric string
    public function testTypeCanNotBeANumericString(): void
    {
        $this->expectExceptionCode(207);

        $form_data = new vk_form_data\Data( new vk_form_data\input\Input );

        $options = [
            [
                'input_name' => 'user_name',
                'type' => '5'
            ]
        ];

        $form_data->set_options( $options, 'get' );

        $form_data->get();
    }
}