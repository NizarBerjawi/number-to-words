<?php

declare(strict_types=1);

/**
 * A service class that contains
 *
 * PHP version 7
 *
 * @author  Nizar El Berjawi <nizarberjawi12@gmail.com>
 */
class WordService
{
    /**
     * Return a group value based on a supplied key
     *
     * @param int $num
     * @return string
     */
    public function groupsDict($num) {
        $dict = [
            '',
            'THOUSAND',
            'MILLION',
            'BILLION',
            'TRILLION',
        ];

        return $dict[$num];
    }


    /**
     * Return a string representation of a digit based on a supplied key.
     *
     * @param int $num
     * @return string
     */
    public function numberDict($num) {
        $dict =  [
            0   => '',
            1   => 'ONE',
            2   => 'TWO',
            3   => 'THREE',
            4   => 'FOUR',
            5   => 'FIVE',
            6   => 'SIX',
            7   => 'SEVEN',
            8   => 'EIGHT',
            9   => 'NINE',
            10  => 'TEN',
            11  => 'ELEVEN',
            12  => 'TWELVE',
            13  => 'THIRTEEN',
            14  => 'FOURTEEN',
            15  => 'FIFTEEN',
            16  => 'SIXTEEN',
            17  => 'SEVENTEEN',
            18  => 'EIGHTEEN',
            19  => 'NINETEEN',
            20  => 'TWENTY',
            30  => 'THIRTY',
            40  => 'FORTY',
            50  => 'FIFTY',
            60  => 'SIXTY',
            70  => 'SEVENTY',
            80  => 'EIGHTY',
            90  => 'NINETY',
            100 => 'HUNDRED',
        ];
        return $dict[$num];
    }
}


?>
