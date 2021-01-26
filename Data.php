<?php
/*
**
*/
namespace vk_form_data;

include_once 'input/Input.php';
include_once 'string/String_Type.php';
include_once 'numeric/Numeric_Type.php';
include_once 'array/Array_Type.php';

use vk_form_data\input;
use vk_form_data\string_type;
use vk_form_data\numeric_type;

class Data
{
    private $input;
    private $options;
    private $request;

    public function __construct( input\Input $input )
    {
        $this->input = $input;
    }

    public function set_options( $options = null, $request = null )
    {
        if( empty( $options ) )
            throw new \Exception("VK_data: Options array must be passed", 200);

        if( !is_array( $options ) )
            throw new \Exception("VK_data: Options must be an array", 201);

        if( empty( $request ) )
            throw new \Exception("VK_data: Options array must be passed", 202);

        if( !is_string( $request ) )
            throw new \Exception("VK_data: Options must be an array", 203);

        $this->options = $options;

        $this->request = $request;

        return;
    }

    public function get_options()
    {
        return $this->options;
    }

    public function get_request()
    {
        return $this->request;
    }

    public function get()
    {
        $input_values = array();

        foreach ($this->options as $input_options) {

            $this->check_input_options( $input_options );

            $type = strtolower( $input_options['type'] );

            $sanitize = isset( $input_options['sanitize'] ) ? $input_options['sanitize'] : false;

            switch ( $type ) {
                case 'string':
                    $string_type = new string_type\String_Type;

                    $raw_value = $this->input->get_string( 
                        $input_options['input_name'], 
                        $this->request,
                        $sanitize
                    );

                    if( is_null( $raw_value ) )
                        continue 2;

                    $valid = $string_type->get_valid_string( $input_options, $raw_value );
                    break;

                case 'numeric':
                    $numeric_type = new numeric_type\Numeric_Type;

                    $raw_value = $this->input->get_numeric( 
                        $input_options['input_name'], 
                        $this->request,
                        $sanitize
                    );

                    if( is_null( $raw_value ) )
                        continue 2;

                    $valid = $numeric_type->get_valid_numeric( $input_options, $raw_value );
                    break;

                case 'digit':
                    $digit_type = new string_type\String_Type;

                    $raw_value = $this->input->get_digit( 
                        $input_options['input_name'], 
                        $this->request,
                        $sanitize
                    );

                    if( is_null( $raw_value ) )
                        continue 2;

                    $valid = $digit_type->get_valid_string( $input_options, $raw_value );
                    break;

                case 'date_time':
                    $date_time_type = new string_type\String_Type;

                    $raw_value = $this->input->get_date_time( 
                        $input_options['input_name'], 
                        $this->request,
                        $input_options['validation'][0],
                        $sanitize
                    );

                    if( is_null( $raw_value ) )
                        continue 2;

                    $valid = $date_time_type->get_valid_string( $input_options, $raw_value );
                    break;

                case 'array':
                    $array_type = new array_type\Array_Type;

                    $raw_array = $this->input->get_array( 
                        $input_options['input_name'], 
                        $this->request,
                        $sanitize
                    );

                    if( is_null( $raw_array ) )
                        continue 2;

                    $valid = $array_type->get_valid_array( $input_options, $raw_array );
                    break;
                
                default:
                    throw new \Exception("VK_data: \"type\" is not a valid option.", 209);
                    break;
            }

            $input_values[ $input_options['input_name']] = $valid;
        }

        return $input_values;
    }

    private function check_input_options( $input_options )
    {
        if( empty( $input_options ) )
            throw new \Exception("VK_data: Input options must be passed", 204);

        if( !is_array( $input_options ) )
            throw new \Exception("VK_data: Input options must be arrays", 205);

        if( 
            !isset( $input_options['input_name'] ) || 
            !is_string( $input_options['input_name'] ) ||
            is_numeric( $input_options['input_name'] )
        )
            throw new \Exception("VK_data: \"input_name\" parameter must be passed and it must be a string", 
                                    206);

        if( 
            !isset( $input_options['type'] ) || 
            !is_string( $input_options['type'] ) ||
            is_numeric( $input_options['type'] )
        )
            throw new \Exception("VK_data: \"type\" parameter must be passed and it must be a string", 
                                    207);

        if( 
            !isset( $input_options['validation'] ) || 
            !is_array( $input_options['validation'] ) ||
            empty( $input_options['validation'] )
        )
            throw new \Exception("VK_data: \"Validation\" parameter must be passed and it must be an array", 
                                    208);

        return;
    }
}
