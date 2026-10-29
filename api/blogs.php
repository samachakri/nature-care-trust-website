<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

$dataFile = __DIR__ . '/data/blogs.json';
$blogs = file_exists($dataFile) ? json_decode(file_get_contents($dataFile), true) : [];

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['slug'])) {
        $slug = $_GET['slug'];
        foreach ($blogs as $b) {
            if ($b['slug'] === $slug) {
                echo json_encode($b);
                exit;
            }
        }
        http_response_code(404);
        echo json_encode(['error' => 'Post not found']);
        exit;
    }

    echo json_encode($blogs);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = file_get_contents('php://input');
    $post = json_decode($input, true);

    if (!$post || empty($post['title'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Title is required']);
        exit;
    }

    if (empty($post['slug'])) {
        $post['slug'] = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $post['title'])));
    }

    if (empty($post['id'])) {
        $post['id'] = 'b_' . time() . '_' . rand(100, 999);
        $post['date'] = date('F j, Y');
        array_unshift($blogs, $post);
    } else {
        $found = false;
        foreach ($blogs as $i => $existing) {
            if ($existing['id'] === $post['id']) {
                $blogs[$i] = array_merge($existing, $post);
                $found = true;
                break;
            }
        }
        if (!$found) {
            array_unshift($blogs, $post);
        }
    }

    file_put_contents($dataFile, json_encode($blogs, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    echo json_encode(['success' => true, 'post' => $post]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $id = isset($_GET['id']) ? $_GET['id'] : null;
    if (!$id) {
        http_response_code(400);
        echo json_encode(['error' => 'ID is required']);
        exit;
    }

    $filtered = array_filter($blogs, function($b) use ($id) {
        return $b['id'] !== $id;
    });

    file_put_contents($dataFile, json_encode(array_values($filtered), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    echo json_encode(['success' => true, 'message' => 'Post deleted']);
    exit;
}
