<?php

if (! function_exists('amount_in_words')) {
    function amount_in_words(float $amount): string
    {
        $no = floor($amount);
        $point = round($amount - $no, 2) * 100;
        $hundred = null;
        $digits_1 = strlen((string) $no);
        $i = 0;
        $str = [];
        $words = [
            0  => '',      1  => 'one',       2  => 'two',        3  => 'three',
            4  => 'four',  5  => 'five',      6  => 'six',        7  => 'seven',
            8  => 'eight', 9  => 'nine',      10 => 'ten',        11 => 'eleven',
            12 => 'twelve',13 => 'thirteen',  14 => 'fourteen',   15 => 'fifteen',
            16 => 'sixteen',17 => 'seventeen',18 => 'eighteen',   19 => 'nineteen',
            20 => 'twenty',30 => 'thirty',    40 => 'forty',      50 => 'fifty',
            60 => 'sixty', 70 => 'seventy',   80 => 'eighty',     90 => 'ninety',
        ];
        $digits = ['', 'hundred', 'thousand', 'lakh', 'crore'];

        while ($i < $digits_1) {
            $divider = ($i == 2) ? 10 : 100;
            $number = $no % $divider;
            $no = (int)($no / $divider);
            $i += ($divider == 10) ? 1 : 2;

            if ($number) {
                $plural = (count($str) && $number > 9) ? '' : null;
                $hundred = (count($str) == 1 && $str[0]) ? ' and ' : null;

                if ($number < 21) {
                    $str[] = $words[$number] . ' ' . $digits[count($str)] . $plural . ' ' . $hundred;
                } else {
                    $str[] = $words[(int)($number / 10) * 10] . ' ' .
                             $words[$number % 10] . ' ' .
                             $digits[count($str)] . $plural . ' ' . $hundred;
                }
            } else {
                $str[] = null;
            }
        }

        $str = array_reverse($str);
        $result = trim(implode('', $str));

        $rupees = $result ? ucfirst($result) . 'rupees' : '';

        $paise = '';
        if ($point > 0) {
            $points = '';
            if ($point < 21) {
                $points = $words[$point];
            } else {
                $points = $words[(int)($point / 10) * 10] . ' ' . $words[$point % 10];
            }
            $paise = ' and ' . $points . ' paise';
        }

        return trim($rupees . $paise) . ' only';
    }
}