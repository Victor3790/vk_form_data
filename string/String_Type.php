<?php
/*
** This function processes all the requests that
** for strings and validates them.
*/
namespace vk_form_data\string_type;

class String_Type
{
    public function get_valid_string( $input_options, $raw_value )
    {
        $validation = $input_options['validation'];
        $array_validation_length = count( $validation );

        if( is_int( $validation[0] ) ) {

            $valid_string = $this->get_string_int_validation( $validation, $input_options, $raw_value );
            return $valid_string;

        }

        if( is_string( $validation[0] ) ) {

            $valid_string = $this->get_string_string_validation( $validation, $input_options, $raw_value );
            return $valid_string;

        }

        throw new \Exception("VK_data: Items in the \"validation\" array must be integer or string", 216);
    }

    private function get_string_int_validation( $validation, $input_options, $raw_value )
    {
        if( $validation[0] <= 0 )
            throw new \Exception("VK_data: Length value must be positive", 210);

        $array_validation_length = count( $validation );

        if( $array_validation_length === 1 ) {

            $value_length = strlen( $raw_value );

            if( $value_length === $validation[0] )
                return $raw_value;
            else    
                throw new \Exception("VK_data: Length error", 212);

        }

        if( $array_validation_length > 1 ) {

            if( !is_int( $validation[1] ) || $validation[1] <= 0 )
                throw new \Exception("VK_data: Length value must be positive", 211);

            $value_length = strlen( $raw_value );

            if( $value_length >= $validation[0] && $value_length <= $validation[1] )
                return $raw_value;
            else    
                throw new \Exception("VK_data: Length error", 213);
        }
    }

    private function get_string_string_validation( $validation, $input_options, $raw_value )
    {
        foreach ($validation as $item) {
                
            if( !is_string( $item ) )
                throw new \Exception("vk_data: All items must be strings", 214);

        }

        if( $input_options['type'] === 'date_time' )
            return $raw_value;

        $in_array = in_array( $raw_value, $validation, true );

        if( $in_array )
            return $raw_value;
        else    
            throw new \Exception("VK_data: Comparison error", 215);
    }
}
