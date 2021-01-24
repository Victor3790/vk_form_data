<?php
/*
**  This class handles data sent using http requests (POST and GET).
**  It should be used to get data from html forms.
*/

namespace vk_form_data\input;

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

        if( is_numeric( $numeric ) || is_null( $numeric ) )
            return $numeric;
        else    
            throw new \Exception("VK_input: " . $key . " : " . $numeric . " is not numeric", 106);
    }

    public function get_digit( $key = null, $request = null, $escape = false, $default = null )
    {
        $raw_digit = $this->get_data( $key, $default, $request );

        $digit =  $this->escape_text_field( $raw_digit, $escape );

        if( ctype_digit( $digit ) || empty( $digit ) )
            return $digit;
        else
            throw new \Exception("VK_input: The string does not contain only digits", 111);
    }

    public function get_date_time( $key = null, $request = null, $format = null, $escape = false, $default = null )
    {
        if( empty( $format ) )
            throw new \Exception("VK_input: No format passed or invalid", 107);

        if( !is_string( $format ) || is_numeric( $format ) )
            throw new \Exception("VK_input: Format must be a string", 108);

        $raw_date_time = $this->get_data( $key, $default, $request );

        if( is_null( $raw_date_time ) )
            return null;

        $date_time =  $this->escape_text_field( $raw_date_time, $escape );

        $date_time_object = \DateTime::createFromFormat( $format, $date_time );

        if( $date_time_object === false )
            throw new \Exception("VK_input: Date-time value or its format were not valid. " . 
                                    "In " . $key . " " , 
                                    109);

        $format_date_time = $date_time_object->format($format);

        if( $format_date_time !== $date_time )
            throw new \Exception("VK_input: Date-time value was not valid.", 110);

        return $date_time;
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
                $set = (isset($_POST[$key])) ? true : false;
                $value = ($set) ? $_POST[$key] : $default;
                break;

            case 'get':
                $set = (isset($_GET[$key])) ? true : false;
                $value = ($set) ? $_GET[$key] : $default;
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
