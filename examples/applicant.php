<?php
require_once __DIR__ . '/../vendor/autoload.php';


\Fountain\Applicants::setApiKey("1234456");
\Fountain\Applicants::listApplicants();