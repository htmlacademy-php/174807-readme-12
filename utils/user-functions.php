<?php
declare(strict_types=1);

/**
 * Функция обрезает текст по заданной длине или возвращает исходный текст если он короче.
 * @param string $text
 * @param int    $length
 * @return string
 */
function trimText(string $text, int $length = 300): string
{
    if (mb_strlen($text) <= $length) {
        return $text;
    }

    $words = explode(' ', $text);
    $resultText = '';

    foreach ($words as $word) {
        if (mb_strlen($resultText . ' ' . $word) > $length) {
            break;
        }
        $resultText .= !$resultText ? $word : ' ' . $word;
    }

    return $resultText;
}

function includeTemplate (string $name, $data): string {
    $name = 'templates/' . $name;
    $result = '';

    if (!file_exists($name)) {
        return $result;
    }

    ob_start();
    extract($data);
    require $name;

    $result = ob_get_clean();

    return $result;
}
