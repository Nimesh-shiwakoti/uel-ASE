<?php
session_start();

// Google OAuth configuration
define('GOOGLE_CLIENT_ID', '508840764923-iqd0pv58nrstgb4h8j8fvqkelo8nebu6.apps.googleusercontent.com');
define('GOOGLE_CLIENT_SECRET', 'Your_code'); // replace with your actual client secret
define('GOOGLE_REDIRECT_URI', 'https://bamshawali.com/toys/google_callback.php');

// Google OAuth endpoints
define('GOOGLE_AUTH_URL', 'https://accounts.google.com/o/oauth2/v2/auth');
define('GOOGLE_TOKEN_URL', 'https://oauth2.googleapis.com/token');
define('GOOGLE_USERINFO_URL', 'https://www.googleapis.com/oauth2/v2/userinfo');
?>
