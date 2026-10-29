<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

$dataFile = __DIR__ . '/data/site_content.json';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (file_exists($dataFile)) {
        echo file_get_contents($dataFile);
    } else {
        echo json_encode(['error' => 'Data file not found']);
    }
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = file_get_contents('php://input');
    $decoded = json_decode($input, true);

    if ($decoded !== null) {
        file_put_contents($dataFile, json_encode($decoded, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        echo json_encode(['success' => true, 'message' => 'Site content updated successfully']);
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid JSON input']);
    }
    exit;
}
