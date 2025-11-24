<?php
require_once 'config.php';

// Generate Google OAuth login URL
$params = [
    'client_id' => GOOGLE_CLIENT_ID,
    'redirect_uri' => GOOGLE_REDIRECT_URI,
    'response_type' => 'code',
    'scope' => 'email profile',
    'access_type' => 'offline',
    'prompt' => 'select_account'
];

$login_url = GOOGLE_AUTH_URL . '?' . http_build_query($params);

// Redirect user to Google login
header('Location: ' . $login_url);
exit;
?>
