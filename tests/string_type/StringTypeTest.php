<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use Brain\Monkey;


/*
** Validations to consider when the 
** data to get is string
*/

final class StringTypeTest extends TestCase
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
                'input_name' => 'user_name',
                'type' => 'sting',
                'validation' => ['Male']
            ]
        ];

        $form_data->set_options( $options, 'get' );

        $form_data->get();
    }

    //Non sanitized string returned
    public function testGetNonSanitizedString(): void
    {
        $_GET = [ 'gender' => 'Male' ];

        $form_data = new vk_form_data\Data( new vk_form_input\Input );

        $options = [
            [
                'input_name' => 'gender',
                'type' => 'string',
                'validation' => ['Male']
            ]
        ];

        $form_data->set_options( $options, 'get' );

        $input_values = $form_data->get();

        $this->assertIsArray( $input_values );
        $this->assertEquals( 'Male', $input_values['gender'] );
    }

    //Sanitized string returned
    public function testGetSanitizedString(): void
    {
        Brain\Monkey\Functions\When( 'sanitize_text_field' )
                    ->returnArg();

        $_GET = [ 'gender' => 'Male' ];

        $form_data = new vk_form_data\Data( new vk_form_input\Input );

        $options = [
            [
                'input_name' => 'gender',
                'type' => 'string',
                'validation' => ['Male'],
                'sanitize' => true
            ]
        ];

        $form_data->set_options( $options, 'get' );

        $input_values = $form_data->get();

        $this->assertIsArray( $input_values );
        $this->assertEquals( 'Male', $input_values['gender'] );
    }

    //Non boolean value passed to "sanitize" option
    public function testNonBooleanValuePassedToSanitize(): void
    {
        $this->expectExceptionCode(105);

        $_GET = [ 'gender' => 'Male' ];

        $form_data = new vk_form_data\Data( new vk_form_input\Input );

        $options = [
            [
                'input_name' => 'gender',
                'type' => 'string',
                'validation' => ['Male'],
                'sanitize' => 1
            ]
        ];

        $form_data->set_options( $options, 'get' );

        $input_values = $form_data->get();
    }

    //Multiple non string values passed as validation
    public function testNonStringValuesPassedAsValidation(): void
    {
        $this->expectExceptionCode(214);

        $_GET = [ 'gender' => 'Male' ];

        $form_data = new vk_form_data\Data( new vk_form_input\Input );

        $options = [
            [
                'input_name' => 'gender',
                'type' => 'string',
                'validation' => ['Male', true, 1, 2]
            ]
        ];

        $form_data->set_options( $options, 'get' );

        $input_values = $form_data->get();
    }

    //Multiple numeric string values passed as validation
    public function testNumericStringValuesPassedAsValidation(): void
    {
        $this->expectExceptionCode(214);

        $_GET = [ 'gender' => 'Male' ];

        $form_data = new vk_form_data\Data( new vk_form_input\Input );

        $options = [
            [
                'input_name' => 'gender',
                'type' => 'string',
                'validation' => ['Male', '1', '2']
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

        $_GET = [ 'gender' => 'Gay' ];

        $form_data = new vk_form_data\Data( new vk_form_input\Input );

        $options = [
            [
                'input_name' => 'gender',
                'type' => 'string',
                'validation' => ['Male', 'Female', 'Non binary']
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

        $_GET = [ 'gender' => 'Male' ];

        $form_data = new vk_form_data\Data( new vk_form_input\Input );

        $options = [
            [
                'input_name' => 'gender',
                'type' => 'string',
                'validation' => ['Male', 'Female', 'Non binary'],
                'sanitize' => true
            ]
        ];

        $form_data->set_options( $options, 'get' );

        $input_values = $form_data->get();

        $this->assertIsArray( $input_values );
        $this->assertEquals( 'Male', $input_values['gender'] );
    }

    protected function tearDown() : void
    {
        Monkey\tearDown();

        parent::tearDown();
    }
}