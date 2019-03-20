<?php
/**
 * Created by PhpStorm.
 * User: Dell
 * Date: 3/20/2019
 * Time: 10:43 AM
 */

namespace Fountain;

use Fountain\Exception\InvalidApiKeyException;
use GuzzleHttp\Client;

class Export
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
     * Create a timestamped export based on the given template_id. To find a template_id, use List Export Templates.
     *
     * @param $templateId
     * @param $output ("csv" or "xlsx")
     * @return string
     * @throws InvalidApiKeyException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function create($templateId, $output)
    {
        self::validateConfig();
        $client = new Client(['base_uri' => self::$url]);
        $request = $client->request("POST", "/timestamped_exports",[
            'headers' =>  [
                'api_token' => self::$apiKey,
            ],
            'form_params' => [
                'template_id' => $templateId,
                'output' => $output
            ]
        ]);
        return $request->getBody()->getContents();
    }

    /**
     * Download an export that you've created specified by id. Obtain an id from Create Timestamped Export.
     *
     * @param $id
     * @return string
     * @throws InvalidApiKeyException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function download($id)
    {
        self::validateConfig();
        $client = new Client(['base_uri' => self::$url]);
        $request = $client->request("GET", "/timestamped_exports/$id",[
            'headers' =>  [
                'api_token' => self::$apiKey,
            ],
        ]);
        return $request->getBody()->getContents();
    }

    /**
     * Lists all timestamped export templates in the account.
     *
     * @return string
     * @throws InvalidApiKeyException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function listTemplates()
    {
        self::validateConfig();
        $client = new Client(['base_uri' => self::$url]);
        $request = $client->request("GET", "/timestamped_exports/templates",[
            'headers' =>  [
                'api_token' => self::$apiKey,
            ],
        ]);
        return $request->getBody()->getContents();
    }
}