<?php
/*
**  This class handles data sent using http requests (POST and GET).
**  It should be used to get data from html forms.
*/

namespace vk_form_input;

class Input
{
    public function get_string( $key = null, $request = null, $escape = false, $default = null )
    {
        $string = $this->get_data( $key, $default, $request );

        return $this->escape_text_field( $string, $escape );
    }

    public function get_numeric( $key = null, $request = null, $escape = false, $default = null )
    {
        $raw_numeric = $this->get_data( $key, $default, $request );

        $numeric =  $this->escape_text_field( $raw_numeric, $escape );

        if( !is_numeric( $numeric ) )
            throw new \Exception("VK_input: The value is not numeric", 106);

        return $numeric;
    }

    public function get_date_time( $key = null, $request = null, $format = null, $escape = false, $default = null )
    {
        if( empty( $format ) )
            throw new \Exception("VK_input: No format passed or invalid", 107);

        if( !is_string( $format ) )
            throw new \Exception("VK_input: Format must be a string", 108);

        $raw_date_time = $this->get_data( $key, $default, $request );

        $date_time =  $this->escape_text_field( $raw_numeric, $escape );

        /*if( !is_numeric( $numeric ) )
            throw new \Exception("VK_input: The value is not numeric", 1);*/

        return $numeric;
    }

    private function get_data( $key = null, $default = null, $request = null )
    {
        if( empty( $key ) )
            throw new \Exception("VK_input: No key passed or the key is not valid", 100);

        if( !is_string( $key ) || is_numeric( $key ) )
            throw new \Exception("VK_input: The key must be a string", 101);

        if( empty( $request ) )
            throw new \Exception("VK_input: No request parameter passed or it is not valid", 102);

        if( !is_string( $request ) || is_numeric( $request ) )
            throw new \Exception("VK_input: The request parameter must be a string", 103);

        $lower_request = strtolower( $request );

        switch ( $lower_request ) {
            case 'post':
                $value = (isset($_POST[$key])) ? $_POST[$key] : false;
                $value = (!empty($value)) ? $value : $default;
                break;

            case 'get':
                $value = (isset($_GET[$key])) ? $_GET[$key] : false;
                $value = (!empty($value)) ? $value : $default;
                break;
            
            default:
                throw new \Exception("VK_input: The http request is not valid", 104);
                break;
        }

        return $value;
    }

    private function escape_text_field( $string = null, $escape = false )
    {
        if( !is_bool( $escape ) )
            throw new \Exception("VK_input: Escape must be boolean", 105);

        return (!$escape) ? $string : sanitize_text_field( $string );
    }
}
