<?php
declare(strict_types=1);
date_default_timezone_set('Europe/Amsterdam');

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

/**
 * Функция возвращает разницу между значениями даты и времени.
 * Результатом является время в общепринятом формате – месяцы, недели, дни, часы, минуты.
 *
 * @param string $date
 * @return string
 */

function getDateDifferenceText(string $date): string {
    $dateNow = date_create();
    $postDate = date_create($date);
    $timeDifference = date_diff($postDate, $dateNow);
    $minutes = (int)ceil($timeDifference->i);
    $hours = (int)ceil($timeDifference->h);
    $days = (int)ceil($timeDifference->d);
    $weeks = (int)ceil($days / 7);
    $months = (int)ceil($timeDifference->m);
    $result = "Недавно";

    if ($months) {
        $result = "${months} " . get_noun_plural_form($months, 'месяц', 'месяца', 'месяцев') . " назад";
    } elseif ($days > 7) {
        $result = "${weeks} " . get_noun_plural_form($weeks, 'неделя', 'недели', 'недель') . " назад";
    } elseif ($days) {
        $result = "${days} " . get_noun_plural_form($days, 'день', 'дня', 'дней') . " назад";
    } elseif ($hours) {
        $result = "${hours} " . get_noun_plural_form($hours, 'час', 'часа', 'часов') . " назад";
    } elseif ($minutes) {
        $result = "${minutes} " . get_noun_plural_form($minutes, 'минута', 'минуты', 'минут') . " назад";
    }

    return $result;
}
