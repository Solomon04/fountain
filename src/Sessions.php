<?php
/**
 * Created by PhpStorm.
 * User: Dell
 * Date: 3/20/2019
 * Time: 12:08 PM
 */

namespace Fountain;

use Fountain\Exception\InvalidApiKeyException;
use GuzzleHttp\Client;

class Sessions
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
     * List all sessions within your account. Pagination is available.
     *
     * @param $funnelId
     * @param $stageId
     * @param bool $unbooked
     * @return string
     * @throws InvalidApiKeyException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function read($funnelId, $stageId,  $unbooked = true)
    {
        self::validateConfig();
        $client = new Client(['base_uri' => self::$url]);
        $request = $client->request("GET", "/sessions",[
            'headers' =>  [
                'api_token' => self::$apiKey,
            ],
            'query' => [
                'funnel_id' => $funnelId,
                'stage_id' => $stageId,
                'with_unbooked' => $unbooked,
            ]
        ]);
        return $request->getBody()->getContents();
    }

    /**
     * This methods cancels a previously booked slot.
     *
     * @param $bookedSlotId
     * @return string
     * @throws InvalidApiKeyException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function cancel($bookedSlotId)
    {
        self::validateConfig();
        $client = new Client(['base_uri' => self::$url]);
        $request = $client->request("GET", "/booked_slots/$bookedSlotId/cancel",[
            'headers' =>  [
                'api_token' => self::$apiKey,
            ],
        ]);
        return $request->getBody()->getContents();
    }
}