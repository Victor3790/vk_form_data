<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

/*
** The Form_Data class gets data from
** html forms through the Input class
*/

final class SetOptionsTest extends TestCase
{
    //An "options" parameter must be passed
    public function testAnOptionsParameterMustBePassed(): void
    {
        $this->expectExceptionCode(200);

        $form_data = new vk_form_data\Data( new vk_form_data\input\Input );

        $form_data->set_options();
    }

    //"options" parameter must be an array
    public function testOptionsMustBeAnArray(): void
    {
        $this->expectExceptionCode(201);
        
        $form_data = new vk_form_data\Data( new vk_form_data\input\Input );

        $options = 100;

        $form_data->set_options( $options );
    }

    //A "request" parameter must be passed
    public function testARequestParameterMustBePassed(): void
    {
        $this->expectExceptionCode(202);

        $form_data = new vk_form_data\Data( new vk_form_data\input\Input );

        $options = [
            'key' => 'value'
        ];

        $form_data->set_options( $options );
    }

    //"request" parameter must be an array
    public function testRequestMustBeAString(): void
    {
        $this->expectExceptionCode(203);
        
        $form_data = new vk_form_data\Data( new vk_form_data\input\Input );

        $options = [
            'key' => 'value'
        ];

        $form_data->set_options( $options, 2 );
    }

    //An "options" parameter was correctly passed
    public function testGetOptionsFunctionWorks(): void
    {
        $form_data = new vk_form_data\Data( new vk_form_data\input\Input );

        $options = [
            'key' => 'value'
        ];

        $form_data->set_options( $options, 'post' );

        $get_options = $form_data->get_options();

        $this->assertIsArray( $get_options );
    }

    //A "request" parameter was correctly passed
    public function testGetRequestFunctionWorks(): void
    {
        $form_data = new vk_form_data\Data( new vk_form_data\input\Input );

        $options = [
            'key' => 'value'
        ];

        $form_data->set_options( $options, 'post' );

        $request = $form_data->get_request();

        $this->assertEquals( 'post', $request );
    }
}