<?php
declare(strict_types=1);

require_once 'getExcerpt.php';

/**
 * @param string $text
 * @param int    $length
 *
 * @return string
 */
function prepareExcerpt(string $text, int $length = 300): string
{
    $wordsFromText = explode(' ', $text);
    $wordsLengthSum = 0;

    for ($index = 0; $index < count($wordsFromText); $index++) {
        if ($wordsLengthSum + strlen($wordsFromText[$index]) > $length) {
            return getExcerpt(array_slice($wordsFromText, 0, $index - 1));
        }
        $wordsLengthSum += strlen($wordsFromText[$index]);
    }

    return '<p>' . $text . '</p>';
}


