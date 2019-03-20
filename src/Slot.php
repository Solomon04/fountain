<?php
/**
 * Created by PhpStorm.
 * User: Dell
 * Date: 3/20/2019
 * Time: 11:51 AM
 */

namespace Fountain;

use Fountain\Exception\InvalidApiKeyException;
use GuzzleHttp\Client;

class Slot
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
     * Create calendar slots.
     *
     * @param array $stageIds
     * @param string $recruiterEmail
     * @param string $startTime
     * @param string $endTime
     * @param string $maxAttendees
     * @param string $location
     * @param null|string $period
     * @param null|integer $frequency
     * @param null|integer $split
     * @param null|string $title
     * @param null|string $instructions
     * @return string
     * @throws InvalidApiKeyException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function create($stageIds, $recruiterEmail, $startTime, $endTime, $maxAttendees, $location, $period = null, $frequency = null, $split = null, $title = null, $instructions = null)
    {
        self::validateConfig();
        $client = new Client(['base_uri' => self::$url]);
        $request = $client->request("POST", "/available_slots",[
            'headers' =>  [
                'api_token' => self::$apiKey,
            ],
            'form_params' => [
                'stage_ids' => $stageIds,
                'recruiter_email' => $recruiterEmail,
                'start_time' => $startTime,
                'end_time' => $endTime,
                'max_attendees' => $maxAttendees,
                'location' => $location,
                'period' => $period,
                'frequency' => $frequency,
                'split' => $split,
                'title' => $title,
                'instructions' => $instructions
            ]
        ]);
        return $request->getBody()->getContents();
    }

    /**
     * This method lists all the available slots.
     *
     * @param $stageId
     * @return string
     * @throws InvalidApiKeyException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function listAvailable($stageId)
    {
        self::validateConfig();
        $client = new Client(['base_uri' => self::$url]);
        $request = $client->request("GET", "/stages/$stageId/available_slots",[
            'headers' =>  [
                'api_token' => self::$apiKey,
            ],
        ]);
        return $request->getBody()->getContents();
    }

    /**
     * Delete calendar slots.
     *
     * @param $stageId
     * @return string
     * @throws InvalidApiKeyException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function delete($stageId)
    {
        self::validateConfig();
        $client = new Client(['base_uri' => self::$url]);
        $request = $client->request("DELETE", "/available_slots/$stageId",[
            'headers' =>  [
                'api_token' => self::$apiKey,
            ],
        ]);
        return $request->getBody()->getContents();
    }

    /**
     * This method confirms an available slot. Use it to organize your time automatically, visiting the Fountain dashboard.
     *
     * @param $slotId
     * @param $applicantId
     * @return string
     * @throws InvalidApiKeyException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function confirm($slotId, $applicantId)
    {
        self::validateConfig();
        $client = new Client(['base_uri' => self::$url]);
        $request = $client->request("POST", "/available_slots/$slotId/confirm",[
            'headers' =>  [
                'api_token' => self::$apiKey,
            ],
            'form_params' => [
                'applicant_id' => $applicantId
            ]
        ]);
        return $request->getBody()->getContents();
    }
}