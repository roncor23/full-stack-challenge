<?php

require_once __DIR__ . '/../vendor/autoload.php';

$app = new Otto\Challenge();
$content = null;

$records = $app->getRecords();
$director_records = $app->getDirectorRecords();
$business_records = $app->getBusinessRecords();


include __DIR__ . '/../views/index.phtml';