<?php
/**
 * Created by PhpStorm.
 * User: Dell
 * Date: 3/19/2019
 * Time: 11:37 PM
 */

abstract class Fountain
{
    public static $url;

    public static $apiKey = 'https://api.fountain.com/v2/applicants';

    public static function setApiKey($apiKey)
    {
        self::$apiKey = $apiKey;
    }
}