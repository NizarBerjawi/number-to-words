<?php

declare(strict_types=1);

// Include the necessary files
include_once '../sys/core/init.inc.php';

// Load the convertor
$convertor = new Convertor();

// Set up the page title and CSS files
$pageTitle = "Number to Words Convertor";
$cssFiles = array('style.css');

// Include the header
include_once 'assets/common/header.inc.php';

?>

<div id="content">
<?php
// Display any error messages
echo $convertor->displayErrors();

// Display the convertor form HTML
echo $convertor->displayForm();

?>

</div>

<?php

// Include the footer
include_once 'assets/common/footer.inc.php';

?>
