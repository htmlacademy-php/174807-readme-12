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
    $agoString = " назад";

    if ($months) {
        $result = "${months} " . get_noun_plural_form($months, 'месяц', 'месяца', 'месяцев') . $agoString;
    } elseif ($days > 7) {
        $result = "${weeks} " . get_noun_plural_form($weeks, 'неделя', 'недели', 'недель') . $agoString;
    } elseif ($days) {
        $result = "${days} " . get_noun_plural_form($days, 'день', 'дня', 'дней') . $agoString;
    } elseif ($hours) {
        $result = "${hours} " . get_noun_plural_form($hours, 'час', 'часа', 'часов') . $agoString;
    } elseif ($minutes) {
        $result = "${minutes} " . get_noun_plural_form($minutes, 'минута', 'минуты', 'минут') . $agoString;
    }

    return $result;
}

/**
 * Вспомогательная функция для проверки полученных данных на наличие ошибок
 * @param   mixed ...$params  параметры, которые нужно проверить на наличие ошибки
 *
 * @return  string            строка с ошибкой или пустая строка, если ошибок нет
 */
function getStringParams(...$params): string {
    foreach ($params as $param) {
        if (gettype($param) === 'string') {
            return $param;
        }
    }

    return '';
}
