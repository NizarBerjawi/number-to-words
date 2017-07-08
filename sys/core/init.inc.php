<?php

declare(strict_types=1);

// Enable sessions if needed
if (session_status() == PHP_SESSION_NONE) {
    // There is no active session
    session_start();
}

// Generate an anti-CSRF token if one doesn't exist
if (!isset($_SESSION['_token'])) {
    $_SESSION['_token'] = sha1(uniqid((string) mt_rand(), TRUE));
}

// Define the autoload function for classes
function __autoload($class) {
    $filename = "../sys/class/" . $class . ".php";

    if (file_exists($filename)) {
        include_once $filename;
    }
}

?>
