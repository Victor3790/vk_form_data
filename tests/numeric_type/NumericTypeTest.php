<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use Brain\Monkey;


/*
** Validations to consider when the 
** data to get is numeric
*/

final class NumericTypeTest extends TestCase
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
                'input_name' => 'rooms',
                'type' => 'nmeric',
                'validation' => [ 2, 3 ]
            ]
        ];

        $form_data->set_options( $options, 'get' );

        $form_data->get();
    }

    //"Validation" must have two integers
    public function testValidationMustHaveTwoItems(): void
    {
        $this->expectExceptionCode(301);

        $_GET = [ 'rooms' => '3' ];

        $form_data = new vk_form_data\Data( new vk_form_input\Input );

        $options = [
            [
                'input_name' => 'rooms',
                'type' => 'numeric',
                'validation' => [ 'uno' ]
            ]
        ];

        $form_data->set_options( $options, 'get' );

        $form_data->get();
    }

    //"Validation" must have two integers
    public function testValidationMinItemMustBeAnInteger(): void
    {
        $this->expectExceptionCode(302);

        $_GET = [ 'rooms' => '3' ];

        $form_data = new vk_form_data\Data( new vk_form_input\Input );

        $options = [
            [
                'input_name' => 'rooms',
                'type' => 'numeric',
                'validation' => [ 'uno', true, 'cinco' ]
            ]
        ];

        $form_data->set_options( $options, 'get' );

        $form_data->get();
    }

    //"Validation" must have two integers
    public function testValidationMaxItemMustBeAnInteger(): void
    {
        $this->expectExceptionCode(302);

        $_GET = [ 'rooms' => '3' ];

        $form_data = new vk_form_data\Data( new vk_form_input\Input );

        $options = [
            [
                'input_name' => 'rooms',
                'type' => 'numeric',
                'validation' => [ 1, true, 'cinco' ]
            ]
        ];

        $form_data->set_options( $options, 'get' );

        $form_data->get();
    }

    //Value out of range
    public function testValueOutOfRange(): void
    {
        $this->expectExceptionCode(303);

        $_GET = [ 'month' => '120' ];

        $form_data = new vk_form_data\Data( new vk_form_input\Input );

        $options = [
            [
                'input_name' => 'month',
                'type' => 'numeric',
                'validation' => [ 1, 12, 'three' ]
            ]
        ];

        $form_data->set_options( $options, 'get' );

        $form_data->get();
    }

    //Value in range
    public function testValueInRange(): void
    {
        $form_data = new vk_form_data\Data( new vk_form_input\Input );

        $min = 1;
        $max = 12;

        for ( $i=$min; $i <= $max ; $i++ ) { 

            $_GET = [ 'month' => $i ];

            $options = [
                [
                    'input_name' => 'month',
                    'type' => 'numeric',
                    'validation' => [ $min, $max ]
                ]
            ];
    
            $form_data->set_options( $options, 'get' );
    
            $numeric = $form_data->get();
    
            $this->assertEquals( $i, $numeric['month'] );

        }
    }

    protected function tearDown() : void
    {
        Monkey\tearDown();

        parent::tearDown();
    }
}