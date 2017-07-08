<?php

declare(strict_types=1);

/**
 * A class that takes a three digit integer and creates a DigitGroup object
 * for it.
 *
 * PHP version 7
 *
 * @author  Nizar El Berjawi <nizarberjawi12@gmail.com>
 */
class DigitGroup
{
    /**
     * The number group
     *
     * @var int
     */
    private $group;

    /**
     * The ones digit
     *
     * @var int
     */
    private $ones;

    /**
     * The tens digit
     *
     * @var int
     */
    private $tens;

    /**
     * The hundreds digit
     *
     * @var int
     */
    private $hundreds;

    /**
     * An instance of the word service
     *
     * @var WordService
     */
    private $wordService;

    /**
     * Accepts a three digit integer and stores it
     *
     * @param int $number
     * @return void
     */
    public function __construct(int $group)
    {
        if ($group < 0 || $group > 999) {
            throw new Exception('Invalid digit group value');
        }
        // Store the number
        $this->group = $group;
        // Store the ones digit
        $this->ones = $group % 10;
        // Store the tens digit
        $this->tens = ($group/10) % 10;
        // Store the hundreds digit
        $this->hundreds = ($group/100) % 100;
        // Store an instance of the word service
        $this->wordService = new WordService();
    }

    /**
     * Get the value of the number stored in this object
     *
     * @return int
     */
    public function getValue() : int
    {
        return $this->group;
    }

    /**
     * Get the word representation of this three-digit group
     *
     * @return string
     */
    public function getWord() : string
    {
        return $this->_createWord();
    }

    /**
     * Create a word representation of this digit group
     *
     * @return string
     */
    protected function _createWord() : string
    {
        // Assign the ones, tens, and hundreds
        list($ones, $tens, $hundreds) = [$this->ones, $this->tens, $this->hundreds];
        // Deal with the hundreds digit scenarios
        $hundredsText = $this->wordService->numberDict($hundreds);
        if ($hundreds > 0) {
            $hundredsText .= ' ';
            $hundredsText .= $this->wordService->numberDict(100);
            $hundredsText .= ($tens != 0 || $ones != 0) ? ' AND ' : '';
        }
        // Deal with the tens digit scenarios
        $index = $tens != 1 ? ($tens * 10) : ($tens * 10 + $ones);
        $tensText = $this->wordService->numberDict($index);
        $tensText .= ($ones != 0 && $tens != 0) ? '-' : '';
        // Deal with the ones digit scenarios
        $onesText = ($tens != 1 && $ones != 0) ? $this->wordService->numberDict($ones) : '';
        // Return the word representation
        return $hundredsText . $tensText . $onesText;
    }
}

?>
