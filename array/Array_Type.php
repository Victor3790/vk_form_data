<?php
/*
** This function processes all the requests
** for arrays and validates them.
*/
namespace vk_form_data\array_type;

class Array_Type
{
    public function get_valid_array( $input_options, $raw_array )
    {
        $validation_items = $input_options['validation'];

        foreach ($validation_items as $item) {
            
            if( !is_string( $item ) )
                throw new \Exception("VK_Array_Type: Items in the \"validation\" array must be string", 401);

        }

        foreach ($raw_array as $raw_item) {
            
            $in_array = in_array( $raw_item, $validation_items, true );
            if( !$in_array )
                throw new \Exception("VK_array : " . $raw_item . " is not in validation array ", 402);

        }

        return $raw_array;
    }
}
