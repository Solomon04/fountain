<?php
/**
 * Created by PhpStorm.
 * User: Dell
 * Date: 3/20/2019
 * Time: 11:10 AM
 */

namespace Fountain;

use Fountain\Exception\InvalidApiKeyException;
use GuzzleHttp\Client;

class Workers
{
    /** @var string  */
    public static $url = 'https://api.fountain.com/v2/';

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
     * List all workers within your account. Pagination is available.
     *
     * @param $funnelId
     * @param bool $active
     * @return string
     * @throws InvalidApiKeyException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function listWorkers($funnelId, $active=false)
    {
        self::validateConfig();
        $client = new Client(['base_uri' => self::$url]);
        $request = $client->request("GET", "workers",[
            'headers' =>  [
                'api_token' => self::$apiKey,
            ],
            'query' => [
                'funnel_id' => $funnelId,
                'is_active' => $active
            ]
        ]);
        return $request->getBody()->getContents();
    }

    /**
     * A standard GET call for worker info yields basic worker data,
     * status and the last data collection checks collected and approved in posthire
     *
     * @param $id
     * @return string
     * @throws InvalidApiKeyException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function getInfo($id)
    {
        self::validateConfig();
        $client = new Client(['base_uri' => self::$url]);
        $request = $client->request("GET", "workers/$id",[
            'headers' =>  [
                'api_token' => self::$apiKey,
            ],
        ]);
        return $request->getBody()->getContents();
    }

    /**
     * At the moment you can only update the is_active attribute.
     *
     * @param $id
     * @param $active
     * @return string
     * @throws InvalidApiKeyException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function update($id, $active)
    {
        self::validateConfig();
        $client = new Client(['base_uri' => self::$url]);
        $request = $client->request("PUT", "workers/$id",[
            'headers' =>  [
                'api_token' => self::$apiKey,
            ],
            'form_params' => [
                'is_active' => $active
            ]
        ]);
        return $request->getBody()->getContents();
    }
}