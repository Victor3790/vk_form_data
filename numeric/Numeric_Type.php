<?php
/*
** This function processes all the requests
** for numeric values and validates them.
** numeric values can either be integer or 
** float values.
*/
namespace vk_form_data\numeric_type;

class Numeric_Type
{
    public function get_valid_numeric( $input_options, $raw_value )
    {
        $validation = $input_options['validation'];
        $array_validation_length = count( $validation );

        if( $array_validation_length < 2 )
            throw new \Exception("vk_data: 'validation' must have at least two items", 301);

        $items = array();

        $items['min'] = $validation[0];
        $items['max'] = $validation[1];

        foreach ($items as $item) {
                
            if( !is_numeric( $item ) )
                throw new \Exception("vk_data: All items must be positive integers", 302);

        }

        if( $raw_value >= $items['min'] && $raw_value <= $items['max'] )
            return $raw_value;
        else
            throw new \Exception("VK_data: The value is not in the range provided", 303);
    }
}
