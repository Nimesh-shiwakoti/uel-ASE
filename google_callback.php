<?php
session_start();
require_once 'config.php';
require_once 'db_connect.php'; // your database connection

if (isset($_GET['code'])) {
    $code = $_GET['code'];

    // Exchange code for access token
    $postFields = [
        'code' => $code,
        'client_id' => GOOGLE_CLIENT_ID,
        'client_secret' => GOOGLE_CLIENT_SECRET,
        'redirect_uri' => GOOGLE_REDIRECT_URI,
        'grant_type' => 'authorization_code'
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, GOOGLE_TOKEN_URL);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postFields));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // only if needed
    $response = curl_exec($ch);
    curl_close($ch);

    $tokenData = json_decode($response, true);

    if (isset($tokenData['access_token'])) {
        $access_token = $tokenData['access_token'];

        // Fetch user info
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, GOOGLE_USERINFO_URL);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Bearer ' . $access_token]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $userInfo = json_decode(curl_exec($ch), true);
        curl_close($ch);

        // Extract user info
        $google_id = $userInfo['id'];
        $name = $userInfo['name'];
        $email = $userInfo['email'];
        $profile_image = $userInfo['picture'];

        // Check if user exists
        $stmt = $conn->prepare("SELECT customer_id FROM customers WHERE google_id=?");
        $stmt->bind_param("s", $google_id);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($customer_id);
            $stmt->fetch();
        } else {
            // Insert new user
            $stmt_insert = $conn->prepare("INSERT INTO customers (google_id, name, email, profile_image) VALUES (?, ?, ?, ?)");
            $stmt_insert->bind_param("ssss", $google_id, $name, $email, $profile_image);
            $stmt_insert->execute();
            $customer_id = $stmt_insert->insert_id;
            $stmt_insert->close();
        }
        $stmt->close();

        // Set session
        $_SESSION['customer_id'] = $customer_id;
        $_SESSION['customer_name'] = $name;
        $_SESSION['customer_email'] = $email;

        // Redirect to dashboard
        header("Location: client_dashboard.php");
        exit;

    } else {
        echo "Error fetching access token.";
    }
} else {
    echo "No code parameter found.";
}
?>
