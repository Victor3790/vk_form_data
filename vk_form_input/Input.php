<?php
/*
**  This class handles data sent using http requests (POST and GET).
**  It should be used to get data from html forms.
*/

namespace vk_form_input;

class Input
{
    public function get_string( $key = null, $default = null, $escape = false )
    {
        $string = $this->get_post_data( $key, $default, $escape );

        return $this->escape_text_field( $string, $escape );
    }

    public function get_numeric( $key = null, $default = null, $escape = false )
    {
        $raw_numeric = $this->get_post_data( $key, $default, $escape );

        $numeric =  $this->escape_text_field( $raw_numeric, $escape );

        if( !is_numeric( $numeric ) )
            throw new \Exception("VK_input: The value is not numeric", 1);

        return $numeric;
    }

    private function get_post_data( $key = null, $default = null )
    {
        if( empty( $key ) )
            throw new \Exception("VK_input: No key passed or the key is not valid", 1);

        if( !is_string( $key ) || is_numeric( $key ) )
            throw new \Exception("VK_input: The key must be a string", 1);
            
        $value = (isset($_POST[$key])) ? $_POST[$key] : false;
        $value = (!empty($value)) ? $value : $default;

        return $value;
    }

    private function escape_text_field( $string = null, $escape = false )
    {
        if( !is_bool( $escape ) )
            throw new \Exception("VK_input: Escape must be boolean", 1);

        return (!$escape) ? $string : sanitize_text_field( $string );
    }
}
