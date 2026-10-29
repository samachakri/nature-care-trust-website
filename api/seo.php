<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

$dataFile = __DIR__ . '/data/seo_meta.json';
$seo = file_exists($dataFile) ? json_decode(file_get_contents($dataFile), true) : [];

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['page'])) {
        $page = $_GET['page'];
        if (isset($seo[$page])) {
            echo json_encode($seo[$page]);
            exit;
        }
        http_response_code(404);
        echo json_encode(['error' => 'Page SEO not found']);
        exit;
    }
    echo json_encode($seo);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    if ($data !== null) {
        if (isset($data['page']) && isset($data['seo'])) {
            $seo[$data['page']] = array_merge($seo[$data['page']] ?? [], $data['seo']);
        } else {
            $seo = array_merge($seo, $data);
        }
        file_put_contents($dataFile, json_encode($seo, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        echo json_encode(['success' => true, 'message' => 'SEO metadata updated successfully', 'seo' => $seo]);
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid JSON input']);
    }
    exit;
}
