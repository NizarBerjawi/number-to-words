<?php

declare(strict_types=1);

/**
 * A class that takes a number and returns its string representation
 *
 * PHP version 7
 *
 * @author  Nizar El Berjawi <nizarberjawi12@gmail.com>
 */
class Number
{
    /**
     * The number
     *
     * @var int
     */
    private $number;

    /**
     * The whole part of the number
     *
     * @var int
     */
    private $wholePart;

    /**
     * The decimal part of the number
     *
     * @var int
     */
    private $decimalPart;

    /**
     * An instance of the word service
     *
     * @var WordService
     */
    private $wordService;

    /**
     * Instantiate a Number instance. This constructor accepts
     * a number then stores and manipulates it.
     *
     * @param float $number
     * @return void
     */
    public function __construct(float $number)
    {
        // Format the number to have 2 decimal places
        $this->number = number_format($number, 2, '.', '');
        // Split the number at the decimal point
        $parts = explode('.', (string) $this->number);
        // Store the whole part
        $this->wholePart = (int) $parts[0];
        // Store the decimal part
        $this->decimalPart = (int) $parts[1];
        // Store an instance of the word service
        $this->wordService = new WordService();
    }

    /**
     * Glue the whole thing together.
     *
     * @return string
     */
    public function getWord()
    {
        // Whole Part String
        $wholeString = $this->_createWholePartString();
        // Decimal Part String
        $decimalString = $this->_createDecimalPartString();
        // Build the final word
        $word = '';
        $word .= $wholeString ? $wholeString . ' DOLLARS' : '';
        $word .= $wholeString && $decimalString ? ' AND ' : '';
        $word .= $decimalString ? $decimalString . ' CENTS' : '';
        return $word;
    }

    /*
    |--------------------------------------------------------------------------
    | Private Helper Methods
    |--------------------------------------------------------------------------
    */

    /**
     * Creates a string of all the digit group words while adding separators,
     * group names(MILLION, BILLION...), conjunctions where needed,
     * and 'DOLLARS' to the end of the string.
     *
     * @return string The text representation of the whole part
     */
    private function _createWholePartString()
    {
        // Load the whole part digit group objects into an array
        $groups = $this->_loadGroupsArray($this->wholePart);
        // Get the index of the first none empty digit group
        $index = $this->_getFirstNoneEmptyIndex($groups);
        $result = '';
        // Get the word representation of each group and store it
        foreach($groups as $key => $group) {
            // Get the word representation of each group
            $word = $group->getWord();
            if (!empty($word)) {
                $word .= ' ';
                $word .= $this->wordService->groupsDict($key);
                if ($key >= $index + 1) {
                    $word .= ',';
                }
                $result = $word . ' ' . $result;
            }
        }
        return trim($result);
    }

    /**
     * Create the word representation of the decimal part
     *
     * @return string $word
     */
    private function _createDecimalPartString()
    {
        // Load the decimal part digit groups into an array
        $decimalGroup = $this->_loadGroupsArray($this->decimalPart);
        if (empty($decimalGroup)) { return; }
        // There will always be one object in the array
        $groupObj = $decimalGroup[0];
        // Return the Decimal Part string
        return trim($groupObj->getWord());
    }

    /**
     * Loads digit group objects into an array.
     *
     * @param int $number
     * @return array $groups
     */
    private function _loadGroupsArray($number)
    {
        // An array of digit group objects
        $groups = array();
        // Loop over the number while creating digit group objects
        while ($number > 0) {
            $group = $number % 1000;
            $number = floor($number / 1000);
            try {
                $groups[] = new DigitGroup($group);
            } catch (Exception $e) {
                die ($e->getMessage());
            }
        }
        return $groups;
    }

    /**
     * Finds the index of the first none empty digit group in
     * the digit groups array
     *
     * @param  array $groupsArray
     * @return int $key
     */
    private function _getFirstNoneEmptyIndex($groupsArray)
    {
        foreach($groupsArray as $key => $group) {
            if (!empty($group->getword())) {
                return $key;
            }
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Accessor Methods
    |--------------------------------------------------------------------------
    */

    /**
     * Get the number stored in this object
     *
     * @return int
     */
    public function getNumber()
    {
        return $this->number;
    }
}

?>
