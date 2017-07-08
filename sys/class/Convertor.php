<?php

declare(strict_types=1);

/**
 * Builds and manipulates a number to words convertor
 *
 * PHP version 7
 *
 * @author  Nizar El Berjawi <nizarberjawi12@gmail.com>
 */
class Convertor
{
    /**
     * Generates a form to convert numbers to words
     *
     * @return string the HTML markup for the form
     */
    public function displayForm()
    {
        // Instantiate the submit button text
        $submit = "Convert Number";
        // Instantiate the two input fields
        $number = 0;
        $word = "ZERO DOLLARS";
        // create an object using the input
        if (isset($_SESSION['input']) && !isset($_SESSION['errors'])) {
            try {
                $numObj = new Number($_SESSION['input']);
                // Get the numerical value of the number
                $number = $numObj->getNumber();
                // Get the text representation of the number
                $word = $numObj->getWord() ?: 'ZERO DOLLARS';
                // Unset the user input session
                unset($_SESSION['input']);
            } catch (Exception $e) {
                die ($e->getMessage());
            }
        } else if (isset($_SESSION['oldInput'])) {
            $number = $_SESSION['oldInput'];
        }
        unset($_SESSION['oldInput']);

        // Build the markup
        return "
            <form action='assets/inc/process.inc.php' method='post'>
                <label for='number'>Cash Amount</label>
                <input type='text' name='number' id='number' value='$number' />
                <label for='number'>Word Representation</label>
                <textarea name='number_word' id='number_word' readonly>$word</textarea>
                <input type='hidden' name='_token' value='$_SESSION[_token]' />
                <input type='hidden' name='action' value='convert' />
                <input type='submit' name='number_submit' value='$submit' />
            </form>";
    }

    /**
     * Generates HTML markup to show any validation errors
     *
     * @return string
     */
    public function displayErrors()
    {
        // If there are any validation errors, display them
        if (isset($_SESSION['errors'])){
            $html = '<ul>';
            foreach($_SESSION['errors'] as $error) {
                $html .= "<li>$error</li>";
            }
            unset($_SESSION['errors']);
            $html .= '</ul>';
            return "<div class='errors'>$html</div>";
        }
        return null;
    }

    /**
     * Validates the form
     *
     * @return mixed TRUE on success, an error message on failure
     */
    public function processForm()
    {
        // Exit if the action isn't set properly
        if ($_POST['action'] != 'convert')
        {
            return "The method processForm was accessed incorrectly";
        }
        // Escape data from the form
        $input = htmlentities($_POST['number'], ENT_QUOTES);
        // Validate the input and store error messages
        $errors = $this->_validateInput($input);
        // If there are errors
        if (!empty($errors)) {
            // Store the validation errors
            $_SESSION['errors'] = $errors;
            // Store the old input
            $_SESSION['oldInput'] = $input;
            // Return false in case of any errors
            return FALSE;
        }
        // Cast the number as a float for security, and store in session
        $_SESSION['input'] = (float) $input;
        // Return TRUE if everything went OK
        return TRUE;
    }

    /*
    |--------------------------------------------------------------------------
    | Private Helper Methods
    |--------------------------------------------------------------------------
    */

    /**
     * Validates that the input is a valid number, then checks that
     * the number is less than the limit of 999 Trillion.
     *
     * Error messages are added to the errors array
     *
     * @param float $num
     */
    private function _validateInput($input){
        // Check that the number is numeric
        if (!is_numeric($input)) {
            $errors[] = 'The amount should be numeric';
        }
        // Make sure it is a positive number
        if ($input < 0) {
            $errors[] = 'The amount should be positive';
        }
        // Make sure it is less than a quadrillion
        if ($input > 999999999999999) {
            $errors[] = 'Let\'s face it, you don\'t have this much money!';
        }

        return $errors;
    }
}

?>
