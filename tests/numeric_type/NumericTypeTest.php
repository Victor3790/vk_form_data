<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use Brain\Monkey;


/*
** Validations to consider when the 
** data to get is numeric either int or float
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

        $form_data = new vk_form_data\Data( new vk_form_data\input\Input );

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

        $form_data = new vk_form_data\Data( new vk_form_data\input\Input );

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

        $form_data = new vk_form_data\Data( new vk_form_data\input\Input );

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

        $form_data = new vk_form_data\Data( new vk_form_data\input\Input );

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

    //Value out of range before
    public function testValueOutOfRangeBefore(): void
    {
        $form_data = new vk_form_data\Data( new vk_form_data\input\Input );

        $this->expectExceptionCode(303);

        $_GET = [ 'month' => '-5' ];

        $options = [
            [
                'input_name' => 'month',
                'type' => 'numeric',
                'validation' => [ 1, 12 ]
            ]
        ];

        $form_data->set_options( $options, 'get' );


        $numeric = $form_data->get();
    }

    //Value out of range zero
    public function testValueOutOfRangeZero(): void
    {
        $form_data = new vk_form_data\Data( new vk_form_data\input\Input );

        $this->expectExceptionCode(303);

        $_GET = [ 'month' => '0' ];

        $options = [
            [
                'input_name' => 'month',
                'type' => 'numeric',
                'validation' => [ 1, 12 ]
            ]
        ];

        $form_data->set_options( $options, 'get' );


        $numeric = $form_data->get();
    }

    //Value out of range after
    public function testValueOutOfRangeAfter(): void
    {
        $form_data = new vk_form_data\Data( new vk_form_data\input\Input );

        $this->expectExceptionCode(303);

        $_GET = [ 'month' => '20' ];

        $options = [
            [
                'input_name' => 'month',
                'type' => 'numeric',
                'validation' => [ 1, 12 ]
            ]
        ];

        $form_data->set_options( $options, 'get' );


        $numeric = $form_data->get();
    }

    //Value in range int
    public function testValueInRangeInteger(): void
    {
        $form_data = new vk_form_data\Data( new vk_form_data\input\Input );

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

            //echo $numeric['month'] . ' ';

        }
    }

    //Value in range float
    public function testValueInRangeFloat(): void
    {
        $form_data = new vk_form_data\Data( new vk_form_data\input\Input );

        $min = 36.1;
        $max = 37.4;

        for ( $i=$min; $i <= $max ; $i += 0.1 ) { 

            $_GET = [ 'temp' => (string)$i ];

            $options = [
                [
                    'input_name' => 'temp',
                    'type' => 'numeric',
                    'validation' => [ $min, $max ]
                ]
            ];
    
            $form_data->set_options( $options, 'get' );
    
            $numeric = $form_data->get();
    
            //echo $numeric['temp'] . ' ';

            $this->assertEquals( $i, $numeric['temp'] );

        }
    }

    protected function tearDown() : void
    {
        Monkey\tearDown();

        parent::tearDown();
    }
}