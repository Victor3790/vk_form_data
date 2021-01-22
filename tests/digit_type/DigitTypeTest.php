<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use Brain\Monkey;


/*
** Validations to consider when the 
** data to get is digit
*/

final class DigitTypeTest extends TestCase
{
    protected function setUp() : void
    {
        parent::setUp();
        Monkey\setUp();
        $_POST = array();
        $_GET = array();
    }

    //"Type" must be a valid option
    public function testNonValidDataType(): void
    {
        $this->expectExceptionCode(209);

        $form_data = new vk_form_data\Data( new vk_form_input\Input );

        $options = [
            [
                'input_name' => 'zip_code',
                'type' => 'dgit',
                'validation' => [5]
            ]
        ];

        $form_data->set_options( $options, 'get' );

        $form_data->get();
    }

    //Non sanitized string returned
    public function testGetNonSanitizedDigitString(): void
    {
        $_GET = [ 'zip_code' => '55060' ];

        $form_data = new vk_form_data\Data( new vk_form_input\Input );

        $options = [
            [
                'input_name' => 'zip_code',
                'type' => 'digit',
                'validation' => [5]
            ]
        ];

        $form_data->set_options( $options, 'get' );

        $input_values = $form_data->get();

        $this->assertIsArray( $input_values );
        $this->assertEquals( '55060', $input_values['zip_code'] );
    }

    //Sanitized string returned
    public function testGetSanitizedDigitString(): void
    {
        Brain\Monkey\Functions\When( 'sanitize_text_field' )
                    ->returnArg();

        $_GET = [ 'zip_code' => '55060' ];

        $form_data = new vk_form_data\Data( new vk_form_input\Input );

        $options = [
            [
                'input_name' => 'zip_code',
                'type' => 'digit',
                'validation' => [1,6],
                'sanitize' => true
            ]
        ];

        $form_data->set_options( $options, 'get' );

        $input_values = $form_data->get();

        $this->assertIsArray( $input_values );
        $this->assertEquals( '55060', $input_values['zip_code'] );
    }

    //Multiple non string values passed as validation
    public function testNonStringValuesPassedAsValidation(): void
    {
        $this->expectExceptionCode(214);

        $_GET = [ 'zip_code' => '55060' ];

        $form_data = new vk_form_data\Data( new vk_form_input\Input );

        $options = [
            [
                'input_name' => 'zip_code',
                'type' => 'digit',
                'validation' => ['55060', true, 1, 2]
            ]
        ];

        $form_data->set_options( $options, 'get' );

        $input_values = $form_data->get();
    }

    //The first item in "validation" value is not string or integer
    public function testIncorrectFirstItemPassedAsValidation(): void
    {
        $this->expectExceptionCode(216);

        $_GET = [ 'zip_code' => '55060' ];

        $form_data = new vk_form_data\Data( new vk_form_input\Input );

        $options = [
            [
                'input_name' => 'zip_code',
                'type' => 'digit',
                'validation' => [true, '1', '2']
            ]
        ];

        $form_data->set_options( $options, 'get' );

        $input_values = $form_data->get();

    }

    //Passed string is not in validation array
    public function testPassedStringIsNotInValidationArray(): void
    {
        Brain\Monkey\Functions\When( 'sanitize_text_field' )
                    ->returnArg();

        $this->expectExceptionCode(215);

        $_GET = [ 'zip_code' => '55060' ];

        $form_data = new vk_form_data\Data( new vk_form_input\Input );

        $options = [
            [
                'input_name' => 'zip_code',
                'type' => 'digit',
                'validation' => ['55100', '55200', '55300']
            ]
        ];

        $form_data->set_options( $options, 'get' );

        $input_values = $form_data->get();
    }

    //Passed string is in validation array
    public function testPassedStringIsInValidationArray(): void
    {
        Brain\Monkey\Functions\When( 'sanitize_text_field' )
                    ->returnArg();

        $_GET = [ 'zip_code' => '55060' ];

        $form_data = new vk_form_data\Data( new vk_form_input\Input );

        $options = [
            [
                'input_name' => 'zip_code',
                'type' => 'digit',
                'validation' => ['55060', '55100', '55200'],
                'sanitize' => true
            ]
        ];

        $form_data->set_options( $options, 'get' );

        $input_values = $form_data->get();

        $this->assertIsArray( $input_values );
        $this->assertEquals( '55060', $input_values['zip_code'] );
    }

    protected function tearDown() : void
    {
        Monkey\tearDown();

        parent::tearDown();
    }
}