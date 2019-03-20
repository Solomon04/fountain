<?php
/**
 * Created by PhpStorm.
 * User: Dell
 * Date: 3/20/2019
 * Time: 11:40 AM
 */

namespace Fountain;

use Fountain\Exception\InvalidApiKeyException;
use GuzzleHttp\Client;

class Option
{
    /** @var string  */
    public static $url = 'https://api.fountain.com/v2';

    /**
     * @var string
     */
    public static $apiKey;

    /**
     * Set the Fountain Api Key
     *
     * @param $apiKey
     */
    public static function setApiKey($apiKey)
    {
        self::$apiKey = $apiKey;
    }

    /**
     * Validate the api key.
     *
     * @throws InvalidApiKeyException
     */
    public static function validateConfig()
    {
        if(!isset(self::$apiKey)){
            throw new InvalidApiKeyException();
        }
    }

    /**
     * Create option bank
     *
     * @param string $name
     * @param array $options
     * @return string
     * @throws InvalidApiKeyException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function create($name, $options)
    {
        self::validateConfig();
        $client = new Client(['base_uri' => self::$url]);
        $request = $client->request("POST", "/option_banks",[
            'headers' =>  [
                'api_token' => self::$apiKey,
            ],
            'form_params' => [
                'name' => $name,
                'options' => $options
            ]
        ]);
        return $request->getBody()->getContents();
    }

    /**
     * List option bank
     *
     * @param $page
     * @param $perPage
     * @return string
     * @throws InvalidApiKeyException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function read($page, $perPage)
    {
        self::validateConfig();
        $client = new Client(['base_uri' => self::$url]);
        $request = $client->request("GET", "/option_banks",[
            'headers' =>  [
                'api_token' => self::$apiKey,
            ],
            'query' => [
                'page' => $page,
                'per_page' => $perPage
            ]
        ]);
        return $request->getBody()->getContents();
    }

    /**
     * Update option bank
     *
     * @param $id
     * @param $name
     * @param $options
     * @return string
     * @throws InvalidApiKeyException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function update($id, $name, $options)
    {
        self::validateConfig();
        $client = new Client(['base_uri' => self::$url]);
        $request = $client->request("PUT", "/option_banks/$id",[
            'headers' =>  [
                'api_token' => self::$apiKey,
            ],
            'form_params' => [
                'name' => $name,
                'options' => $options
            ]
        ]);
        return $request->getBody()->getContents();
    }

    /**
     * Delete option bank
     *
     * @param $id
     * @return string
     * @throws InvalidApiKeyException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function delete($id)
    {
        self::validateConfig();
        $client = new Client(['base_uri' => self::$url]);
        $request = $client->request("DELETE", "/option_banks/$id",[
            'headers' =>  [
                'api_token' => self::$apiKey,
            ],
        ]);
        return $request->getBody()->getContents();
    }
}