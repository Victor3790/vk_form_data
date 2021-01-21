<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use Brain\Monkey;

/*
** Validation for string types can be positive integer
** or string and the array can contain one or many items.
*/

final class ValidationStringTest extends TestCase
{
    protected function setUp() : void
    {
        parent::setUp();
        Monkey\setUp();
        $_POST = array();
        $_GET = array();
    }

    //string length one in validation must be a positive integer.
    public function testValidationOneMustBeAPositiveInteger(): void
    {
        $this->expectExceptionCode(210);

        $_GET = ['user_code' => '1A2B3C4D5E'];

        $form_data = new vk_form_data\Data( new vk_form_input\Input, new vk_form_string\String_Type );

        $options = [
            [
                'input_name' => 'user_code',
                'type' => 'string',
                'validation' =>  [-2]
            ]
        ];

        $form_data->set_options( $options, 'get' );

        $form_data->get();
    }

    /*"Validation" is an array of one int item, the 
    **string length must be equal to the value passed.*/

    //Incorrect one item validation string
    public function testInvalidOneItemValidationString(): void
    {
        $this->expectExceptionCode(212);

        $_GET = ['user_code' => '1A2B3C4D5E'];

        $form_data = new vk_form_data\Data( new vk_form_input\Input );

        $options = [
            [
                'input_name' => 'user_code',
                'type' => 'string',
                'validation' => [9]
            ]
        ];

        $form_data->set_options( $options, 'get' );

        $input_values = $form_data->get();
    }

    //Correct one item validation string
    public function testValidOneItemValidationString(): void
    {
        $_GET = ['user_code' => '1A2B3C4D5E'];

        $form_data = new vk_form_data\Data( new vk_form_input\Input, new vk_form_string\String_Type );

        $options = [
            [
                'input_name' => 'user_code',
                'type' => 'string',
                'validation' => [10]
            ]
        ];

        $form_data->set_options( $options, 'get' );

        $input_values = $form_data->get();

        $this->assertEquals( '1A2B3C4D5E', $input_values['user_code'] );
    }

    /*"Validation" is an array of multiple int items, the 
    **string length must be between the first two values passed.
    ** If more values are passed, they will be ignored.*/

    //string length two in validation must be a positive integer.
    public function testValidationTwoMustBeAnInteger(): void
    {
        $this->expectExceptionCode(211);

        $_GET = ['user_code' => '1A2B3C4D5E'];

        $form_data = new vk_form_data\Data( new vk_form_input\Input, new vk_form_string\String_Type );

        $options = [
            [
                'input_name' => 'user_code',
                'type' => 'string',
                'validation' =>  [2,'dos', true, 4, 'cinco']
            ]
        ];

        $form_data->set_options( $options, 'get' );

        $form_data->get();
    }

    //string length two in validation must be a positive integer.
    public function testValidationTwoMustBeAPositiveInteger(): void
    {
        $this->expectExceptionCode(211);

        $_GET = ['user_code' => '1A2B3C4D5E'];

        $form_data = new vk_form_data\Data( new vk_form_input\Input, new vk_form_string\String_Type );

        $options = [
            [
                'input_name' => 'user_code',
                'type' => 'string',
                'validation' =>  [2,-1]
            ]
        ];

        $form_data->set_options( $options, 'get' );

        $form_data->get();
    }

    //Incorrect multiple items validation string
    public function testInvalidMultipleItemValidationString(): void
    {
        $this->expectExceptionCode(213);

        $_GET = ['user_code' => '1A2B3C4D5E'];

        $form_data = new vk_form_data\Data( new vk_form_input\Input, new vk_form_string\String_Type );

        $options = [
            [
                'input_name' => 'user_code',
                'type' => 'string',
                'validation' => [11,2]
            ]
        ];

        $form_data->set_options( $options, 'get' );

        $input_values = $form_data->get();
    }

    //Correct multiple items validation string
    public function testValidMultipleItemValidationString(): void
    {
        $_GET = ['user_code' => '1A2B3C4D5E'];

        $form_data = new vk_form_data\Data( new vk_form_input\Input, new vk_form_string\String_Type );

        $options = [
            [
                'input_name' => 'user_code',
                'type' => 'string',
                'validation' => [1,15]
            ]
        ];

        $form_data->set_options( $options, 'get' );

        $input_values = $form_data->get();

        $this->assertEquals( '1A2B3C4D5E', $input_values['user_code'] );
    }

    protected function tearDown() : void
    {
        Monkey\tearDown();

        parent::tearDown();
    }
}