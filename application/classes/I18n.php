<?php
class I18n {

    /**
     * @param string
     * @return string
     */
    public static function get($key) {
        global $CONTENT;
        return (isset($CONTENT[$key])) ? $CONTENT[$key] : $key;
    }
}
