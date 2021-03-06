<?php

/**
 * @param array $wordsFromText
 *
 * @return string
 */

function getExcerpt(array $wordsFromText): string {
    $excerptText = implode(" ",$wordsFromText) . ' ...';
    return '<p>' . $excerptText . '</p><a class="post-text__more-link" href="#">Читать далее</a>';
}
