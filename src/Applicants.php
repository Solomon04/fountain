<?php
/**
 * Created by PhpStorm.
 * User: Dell
 * Date: 3/19/2019
 * Time: 11:55 PM
 */

namespace Fountain;

use Fountain\Exception\InvalidApiKeyException;
use GuzzleHttp\Client;

class Applicants
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
     * List all applicants within your account.
     * You can get all of the information about an applicant — including their scorecard results,
     * background check information, and labels.
     *
     * @param null $funnelId
     * @param null $stageId
     * @param null $stage
     * @param null $labels
     * @return string
     * @throws InvalidApiKeyException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function listApplicants($funnelId = null, $stageId  = null, $stage = null, $labels = null)
    {
        self::validateConfig();
        $client = new Client(['base_uri' => self::$url]);
        $request = $client->request("GET", "/applicants", [
            'headers' =>  [
                'api_token' => self::$apiKey,
            ],
           'query' => [
                'funnel_id' => $funnelId,
                'stage_id' => $stageId,
                'stage' => $stage,
                'labels' => $labels,
           ]
        ]);
        return $request->getBody()->getContents();
    }

    /**
     * To create an applicant, just pass some required attributes, and you are ready to go.
     * Required attributes: name, email, phone_number
     *
     * @param @required string $name
     * @param @require string $email
     * @param @require string $phoneNumber
     * @param array $data
     * @param array $secureData
     * @param null $funnelId
     * @param null $stageId
     * @return string
     * @throws InvalidApiKeyException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function createApplicant($name, $email, $phoneNumber, $data, $secureData , $funnelId = null, $stageId = null)
    {
        self::validateConfig();
        $client = new Client(['base_uri' => self::$url]);
        $request = $client->request("POST", "/applicants", [
            'headers' =>  [
                'api_token' => self::$apiKey,
            ],
            'form_params' => [
                'name' => $name,
                'email' => $email,
                'phone_number' => $phoneNumber,
                'data' => $data,
                'secured_data' => $secureData,
                'funnel_id' => $funnelId,
                'stage_id' => $stageId
            ]
        ]);
        return $request->getBody()->getContents();
    }

    /**
     * This will delete an applicant for good, please use with caution.
     *
     * @param $applicantId
     * @return string
     * @throws InvalidApiKeyException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function deleteApplicant($applicantId)
    {
        self::validateConfig();
        $client = new Client(['base_uri' => self::$url]);
        $request = $client->request("DELETE", "/applicants/$applicantId", [
            'headers' =>  [
                'api_token' => self::$apiKey,
            ],
        ]);
        return $request->getBody()->getContents();
    }

    /**
     * A standard GET call for applicant info yields any data which was not collected via a secure field in our forms.
     *
     * @param $applicantId
     * @return string
     * @throws InvalidApiKeyException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function getApplicant($applicantId)
    {
        self::validateConfig();
        $client = new Client(['base_uri' => self::$url]);
        $request = $client->request("GET", "/applicants/$applicantId",[
            'headers' =>  [
                'api_token' => self::$apiKey,
            ],
        ]);
        return $request->getBody()->getContents();
    }

    /**
     * Very similar to the “Create an applicant” method.
     * Existing attributes are overwritten (except auto-generated attributes such as created_at), and new attributes are added
     *
     * @param $applicantId
     * @param $name
     * @param $email
     * @param $phoneNumber
     * @param array $data
     * @param array $secureData
     * @param string $rejectionReason
     * @param string $onHoldReason
     * @return string
     * @throws InvalidApiKeyException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function updateApplicant($applicantId, $name, $email, $phoneNumber, $data = null, $secureData = null, $rejectionReason = null, $onHoldReason = null)
    {
        self::validateConfig();
        $client = new Client(['base_uri' => self::$url]);
        $request = $client->request("PUT", "/applicants/$applicantId", [
            'headers' =>  [
                'api_token' => self::$apiKey,
            ],
            'form_params' => [
                'name' => $name,
                'email' => $email,
                'phone_number' => $phoneNumber,
                'data' => $data,
                'secured_data' => $secureData,
                'rejection_reason' => $rejectionReason,
                'on_hold_reason' => $onHoldReason
            ]
        ]);
        return $request->getBody()->getContents();
    }

    /**
     * Fountain supports secure documents to manage personally identifiable information such as Drivers License photos,
     * insurance documents, and more.
     *
     * @param string $applicantId
     * @return string
     * @throws InvalidApiKeyException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function getApplicantDocuments($applicantId)
    {
        self::validateConfig();
        $client = new Client(['base_uri' => self::$url]);
        $request = $client->request("GET", "/applicants/$applicantId/secure_documents", [
            'headers' =>  [
                'api_token' => self::$apiKey,
            ]
        ]);
        return $request->getBody()->getContents();
    }

    /**
     * @param string $applicantId
     * @param bool $skipActions
     * @param string $stageId
     * @return string
     * @throws InvalidApiKeyException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function advanceApplicant($applicantId, $skipActions, $stageId)
    {
        self::validateConfig();
        $client = new Client(['base_uri' => self::$url]);
        $request = $client->request("PUT", "/applicants/$applicantId/advance", [
            'headers' =>  [
                'api_token' => self::$apiKey,
            ],
            'form_params' => [
               'skip_automated_actions' => $skipActions,
                'stage_id' => $stageId
            ]
        ]);
        return $request->getBody()->getContents();
    }
}