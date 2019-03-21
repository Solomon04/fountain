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

class Notes
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
     * List all notes associated with an applicant.
     *
     * @param $applicantId
     * @return string
     * @throws InvalidApiKeyException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function listApplicantNotes($applicantId)
    {
        self::validateConfig();
        $client = new Client(['base_uri' => self::$url]);
        $request = $client->request("GET", "applicants/$applicantId/notes",[
            'headers' =>  [
                'api_token' => self::$apiKey,
            ],
        ]);
        return $request->getBody()->getContents();
    }

    /**
     * Create a new note associated to an applicant.
     *
     * @param $applicantId
     * @param $content
     * @return string
     * @throws InvalidApiKeyException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function createApplicantNote($applicantId, $content)
    {
        self::validateConfig();
        $client = new Client(['base_uri' => self::$url]);
        $request = $client->request("POST", "applicants/$applicantId/notes",[
            'headers' =>  [
                'api_token' => self::$apiKey,
            ],
            'form_params' => [
                'content' => $content
            ]
        ]);
        return $request->getBody()->getContents();
    }

    /**
     * Delete a note stored on an applicant's profile.
     *
     * @param $applicantId
     * @param $id
     * @return string
     * @throws InvalidApiKeyException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function deleteApplicantNote($applicantId, $id)
    {
        self::validateConfig();
        $client = new Client(['base_uri' => self::$url]);
        $request = $client->request("DELETE", "applicants/$applicantId/notes/$id",[
            'headers' =>  [
                'api_token' => self::$apiKey,
            ],
        ]);
        return $request->getBody()->getContents();
    }

    /**
     * Update a stored applicant note.
     *
     * @param $applicantId
     * @param $id
     * @param $content
     * @return string
     * @throws InvalidApiKeyException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function updateApplicantNote($applicantId, $id, $content)
    {
        self::validateConfig();
        $client = new Client(['base_uri' => self::$url]);
        $request = $client->request("PUT", "applicants/$applicantId/notes/$id",[
            'headers' =>  [
                'api_token' => self::$apiKey,
            ],
            'form_params' => [
                'content' => $content
            ]
        ]);
        return $request->getBody()->getContents();
    }
}