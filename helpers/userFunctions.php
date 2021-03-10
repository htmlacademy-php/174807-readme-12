<?php
declare(strict_types=1);

/**
 * @param string $text
 * @param int    $length
 *
 * @return string
 */
function trimText(string $text, int $length = 300): string
{
    if (mb_strlen($text) <= $length) {
        return $text;
    }

    $words = explode(' ', $text);
    $result = [];

    foreach ($words as $word) {
        if ((mb_strlen(implode(' ', $result)) + mb_strlen($word) + 1) > $length) {
            break;
        }
        $result[] = $word;
    }

    return implode(' ', $result);
}
