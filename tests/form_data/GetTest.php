<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

/*
** The Form_Data class gets data from
** html forms through the Input class
*/

final class GetTest extends TestCase
{
    //"Input options" must be passed
    public function testInputOptionsMustBePassed(): void
    {
        $this->expectExceptionCode(204);

        $form_data = new vk_form_data\Data( new vk_form_data\input\Input );

        $options = [
            null, 0
        ];

        $form_data->set_options( $options, 'get' );

        $form_data->get();
    }

    //"Input options" must be arrays
    public function testInputOptionsMustBeArrays(): void
    {
        $this->expectExceptionCode(205);

        $form_data = new vk_form_data\Data( new vk_form_data\input\Input );

        $options = [
            'key', 3
        ];

        $form_data->set_options( $options, 'get' );

        $form_data->get();
    }
}