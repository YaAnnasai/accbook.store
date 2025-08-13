<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $secretKey = "6Lf6gpwrAAAAFxJlDS_M6UZhVCWG-QeQFrC9F7c";
    $captchaResponse = $_POST['g-recaptcha-response'];
    $remoteip = $_SERVER['REMOTE_ADDR'];

    // Call Google API
    $url = "https://www.google.com/recaptcha/api/siteverify";
    $data = [
        'secret' => $secretKey,
        'response' => $captchaResponse,
        'remoteip' => $remoteip
    ];

    $options = [
        'http' => [
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data)
        ]
    ];

    $context  = stream_context_create($options);
    $verify = file_get_contents($url, false, $context);
    $captchaSuccess = json_decode($verify);

    if ($captchaSuccess->success) {
        echo "<h2 style='color:green;'>✅ Login successful!</h2>";
        echo "<p>Welcome, <strong>" . htmlspecialchars($_POST['username']) . "</strong></p>";
    } else {
        echo "<h2 style='color:red;'>❌ reCAPTCHA failed</h2>";
        echo "<p>Please confirm you are not a robot.</p>";
    }
} else {
    echo "<h3>Form not submitted properly.</h3>";
}
?>
