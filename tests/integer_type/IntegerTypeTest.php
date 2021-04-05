<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use Brain\Monkey;


/*
** Validations to consider when the 
** data to get is numeric either int or float
*/

final class IntegerTypeTest extends TestCase
{
    protected $form_data;

    protected function setUp() : void
    {
        parent::setUp();
        Monkey\setUp();
        $_POST = array();
        $_GET = array();
        $this->form_data = new vk_form_data\Data( new vk_form_data\input\Input );
    }

    //"Type" must be a valid option
    public function testNonValidDataType(): void
    {
        $this->expectExceptionCode(209);

        $options = [
            [
                'input_name' => 'rooms',
                'type' => 'intgr',
                'validation' => [ 2, 3 ]
            ]
        ];

        $this->form_data->set_options( $options, 'get' );

        $this->form_data->get();
    }

    //"Validation" must have two integers
    public function testValidationMustHaveTwoItems(): void
    {
        $this->expectExceptionCode(501);

        $_GET = [ 'rooms' => '3' ];

        $options = [
            [
                'input_name' => 'rooms',
                'type' => 'integer',
                'validation' => [ 'uno' ]
            ]
        ];

        $this->form_data->set_options( $options, 'get' );

        $this->form_data->get();
    }

    //"Validation" must have two integers
    public function testValidationMinItemMustBeAnInteger(): void
    {
        $this->expectExceptionCode(502);

        $_GET = [ 'rooms' => '3' ];

        $options = [
            [
                'input_name' => 'rooms',
                'type' => 'integer',
                'validation' => [ 'uno', true, 'cinco' ]
            ]
        ];

        $this->form_data->set_options( $options, 'get' );

        $this->form_data->get();
    }

    //"Validation" must have two integers
    public function testValidationMaxItemMustBeAnInteger(): void
    {
        $this->expectExceptionCode(502);

        $_GET = [ 'rooms' => '3' ];

        $options = [
            [
                'input_name' => 'rooms',
                'type' => 'integer',
                'validation' => [ 1, true, 'cinco' ]
            ]
        ];

        $this->form_data->set_options( $options, 'get' );

        $this->form_data->get();
    }

    //Value out of range before
    public function testValueOutOfRangeBefore(): void
    {
        $this->expectExceptionCode(503);

        $_GET = [ 'month' => '-5' ];

        $options = [
            [
                'input_name' => 'month',
                'type' => 'integer',
                'validation' => [ 1, 12 ]
            ]
        ];

        $this->form_data->set_options( $options, 'get' );


        $integer = $this->form_data->get();
    }

    //Value out of range zero
    public function testValueOutOfRangeZero(): void
    {
        $this->expectExceptionCode(503);

        $_GET = [ 'month' => '0' ];

        $options = [
            [
                'input_name' => 'month',
                'type' => 'integer',
                'validation' => [ 1, 12 ]
            ]
        ];

        $this->form_data->set_options( $options, 'get' );


        $integer = $this->form_data->get();
    }

    //Value out of range after
    public function testValueOutOfRangeAfter(): void
    {
        $this->expectExceptionCode(503);

        $_GET = [ 'month' => '20' ];

        $options = [
            [
                'input_name' => 'month',
                'type' => 'integer',
                'validation' => [ 1, 12 ]
            ]
        ];

        $this->form_data->set_options( $options, 'get' );


        $integer = $this->form_data->get();
    }

    //Value in range int
    public function testValueInRangeInteger(): void
    {
        $min = 1;
        $max = 12;

        for ( $i=$min; $i <= $max ; $i++ ) { 

            $_GET = [ 'month' => (string)$i ];

            $options = [
                [
                    'input_name' => 'month',
                    'type' => 'integer',
                    'validation' => [ $min, $max ]
                ]
            ];
    
            $this->form_data->set_options( $options, 'get' );
    
            $numeric = $this->form_data->get();
    
            $this->assertEquals( $i, $numeric['month'] );

        }
    }

    //Value in range int negative
    public function testValueInRangeNegativeInteger(): void
    {
        $min = -12;
        $max = -1;

        for ( $i=$min; $i <= $max ; $i++ ) { 

            $_GET = [ 'signed_int' => (string)$i ];

            $options = [
                [
                    'input_name' => 'signed_int',
                    'type' => 'integer',
                    'validation' => [ $min, $max ]
                ]
            ];
    
            $this->form_data->set_options( $options, 'get' );
    
            $integer = $this->form_data->get();
    
            $this->assertEquals( $i, $integer['signed_int'] );

        }
    }

    protected function tearDown() : void
    {
        Monkey\tearDown();

        parent::tearDown();
    }
}