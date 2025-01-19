<?php
$config = include __DIR__ . '/../../config/env.php';

$redirects = $config['redirects'] ?? [];
$requestUri = $_SERVER['REQUEST_URI'];

if (array_key_exists($requestUri, $redirects)) {
    header('Location: ' . $redirects[$requestUri]);
    exit;
}
