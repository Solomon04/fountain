<?php
/**
 * Created by PhpStorm.
 * User: Dell
 * Date: 3/20/2019
 * Time: 12:15 AM
 */
namespace Fountain\Exception;

class InvalidApiKeyException extends \Exception
{
    protected $message = 'Please set the $apiKey';
}