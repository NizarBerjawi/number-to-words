<?php

declare(strict_types=1);

// Enable sessions if needed
if (session_status() == PHP_SESSION_NONE){
    // There is no active session
    session_start();
}

// Create a lookup array for form actions
define('ACTIONS', array(
        'convert' => array(
                'object' => 'Convertor',
                'method' => 'processForm',
                'header' => 'Location: ../../'
            )
    )
);

// Make sure the anti-CSRF token was passed and that the
// requested action exists in the lookup array
if ( $_POST['_token'] == $_SESSION['_token']
        && isset(ACTIONS[$_POST['action']]) )
{
    $use_array = ACTIONS[$_POST['action']];
    $obj = new $use_array['object']($dbo);
    $method = $use_array['method'];
    $obj->$method();
    header($use_array['header']);
    exit;
}
else {
    // Redirect to the main index if the token/action is invalid
    header("Location: ../../");
    exit;
}

// Define the autoload function for classes
function __autoload($class)
{
    $filename = '../../../sys/class/' . $class . '.php';
    if (file_exists($filename))
    {
        include_once $filename;
    }
}

?>
