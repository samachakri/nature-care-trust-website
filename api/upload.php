<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

$mediaFile = __DIR__ . '/data/media.json';
$uploadDir = dirname(__DIR__) . '/assets/images/';

if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

$mediaList = file_exists($mediaFile) ? json_decode(file_get_contents($mediaFile), true) : [];

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    echo json_encode($mediaList);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
        http_response_code(400);
        echo json_encode(['error' => 'No image uploaded or upload error code: ' . ($_FILES['image']['error'] ?? 'none')]);
        exit;
    }

    $file = $_FILES['image'];
    $allowedTypes = ['image/jpeg', 'image/png', 'image/webp', 'image/gif', 'image/svg+xml'];
    
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);

    if (!in_array($mime, $allowedTypes)) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid image format. Allowed: JPG, PNG, WEBP, GIF, SVG']);
        exit;
    }

    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $safeName = preg_replace('/[^a-zA-Z0-9_\-\.]/', '_', pathinfo($file['name'], PATHINFO_FILENAME));
    $filename = time() . '_' . $safeName . '.' . $extension;
    $targetPath = $uploadDir . $filename;

    if (move_uploaded_file($file['tmp_name'], $targetPath)) {
        $sizeKb = round(filesize($targetPath) / 1024, 1) . ' KB';
        $item = [
            'id' => 'm_' . time() . '_' . rand(100, 999),
            'name' => $filename,
            'title' => isset($_POST['title']) && trim($_POST['title']) !== '' ? trim($_POST['title']) : $safeName,
            'url' => '/assets/images/' . $filename,
            'size' => $sizeKb,
            'date' => date('Y-m-d')
        ];

        array_unshift($mediaList, $item);
        file_put_contents($mediaFile, json_encode($mediaList, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

        echo json_encode(['success' => true, 'item' => $item]);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to save uploaded file']);
    }
    exit;
}
