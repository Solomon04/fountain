<?php
/**
 * Created by PhpStorm.
 * User: Dell
 * Date: 3/20/2019
 * Time: 12:19 PM
 */
require_once __DIR__ . '/../vendor/autoload.php';
use Fountain\Applicants;

Applicants::setApiKey("1234456");
Applicants::listApplicants();