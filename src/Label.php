<?php
/**
 * Created by PhpStorm.
 * User: Dell
 * Date: 3/20/2019
 * Time: 2:16 AM
 */

namespace Fountain;


use Fountain\Exception\InvalidApiKeyException;
use GuzzleHttp\Client;

class Label
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
     * This lists all labels for an applicant.
     * This way you can perform a quick check to see if the applicant has one label or another.
     *
     * @param $applicantId
     * @return string
     * @throws InvalidApiKeyException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function listApplicantLabels($applicantId)
    {
        self::validateConfig();
        $client = new Client(['base_uri' => self::$url]);
        $request = $client->request("GET", "applicants/$applicantId/labels",[
            'headers' =>  [
                'api_token' => self::$apiKey,
            ],
        ]);
        return $request->getBody()->getContents();
    }

    /**
     * This method updates a list of labels for an applicant. Use it to delete existing labels for an applicant or add new ones.
     *
     * @param $applicantId
     * @param $title
     * @param null $completed
     * @param null $completedAt
     * @return string
     * @throws InvalidApiKeyException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function updateApplicantLabels($applicantId, $title, $completed=null, $completedAt=null)
    {
        self::validateConfig();
        $client = new Client(['base_uri' => self::$url]);
        $request = $client->request("PUT", "applicants/$applicantId/labels/$title",[
            'headers' =>  [
                'api_token' => self::$apiKey,
            ],
            'form_params' => [
                'completed' => $completed,
                'completed_at' => $completedAt
            ]
        ]);
        return $request->getBody()->getContents();
    }

    /**
     * This method lists all the labels that are available in a specific stage.
     *You can assign labels to applicants using the applicant label management methods in the API.
     *
     * @param $stagedId
     * @return string
     * @throws InvalidApiKeyException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function listAllLabels($stagedId)
    {
        self::validateConfig();
        $client = new Client(['base_uri' => self::$url]);
        $request = $client->request("PUT", "stages/$stagedId/labels",[
            'headers' =>  [
                'api_token' => self::$apiKey,
            ],
        ]);
        return $request->getBody()->getContents();
    }
}