<?php
//Нужно ввести строку для преобразования.
//Пример: 2aaa'3'bbb'4'
$str_for_parse = trim(fgets(STDIN));
$pattern = '/(\'[0-9]\')/';

function composition_matches ($matches)
{
    preg_match('/[0-9]/', $matches[0], $out);
    return '\''. ($out[0]*2). '\'';
}

echo preg_replace_callback(
    $pattern,
    "composition_matches",
    $str_for_parse);
