<?php

// Include necessary files and classes
require_once '../src/PdoBuilder.php'; // Adjust the path as needed
require_once '../src/Challenge.php'; // Adjust the path as needed
require_once __DIR__ . '/../vendor/autoload.php';

// Create a new instance of Challenge
$challenge = new \Otto\Challenge();

// Check if an action is requested
if (isset($_POST['action'])) {
    $action = $_POST['action'];
    // for director record
    if ($action === 'getSingleDirectorRecord' && isset($_POST['id'])) {
        $directorId = $_POST['id'];
        $directorRecord = $challenge->getSingleDirectorRecord($directorId);

        if ($directorRecord) {
            // Return JSON response with the retrieved data
            echo json_encode(['success' => true, 'data' => $directorRecord]);
        } else {
            echo json_encode(['success' => false]);
        }
    } 
    // for business record
    if ($action === 'getSingleBusinessRecord' && isset($_POST['id'])) {
        $businessId = $_POST['id'];
        $businessRecord = $challenge->getSingleBusinessRecord($businessId);

        if ($businessRecord) {
            // Return JSON response with the retrieved data
            echo json_encode(['success' => true, 'data' => $businessRecord]);
        } else {
            echo json_encode(['success' => false]);
        }
    } 
    // get last 100 record
    if ($action === 'getLast100Records') {

        $last100Record = $challenge->getLast100Records();

        if ($last100Record) {
            // Return JSON response with the retrieved data
            echo json_encode(['success' => true, 'data' => $last100Record]);
        } else {
            echo json_encode(['success' => false]);
        }
    } 
}

if (isset($_GET['action'])) {
    $action = $_GET['action'];
    // for search business year
    if ($action === 'getBusinessesRegisteredInYear' && isset($_GET['year'])) {
        $businessYear = $_GET['year'];
        $businessRecordPeryear = $challenge->getBusinessesRegisteredInYear($businessYear);

        if ($businessRecordPeryear) {
            // Return JSON response with the retrieved data
            echo json_encode(['success' => true, 'data' => $businessRecordPeryear]);
        } else {
            echo json_encode(['success' => false]);
        }
    } 
}