<?php
require ('connect.php');
//Получаем информацию из базы данных
global $connection;
$prepared = $connection->prepare("SELECT id_law, scr_law FROM law");
$result = $prepared->execute();
$laws = $prepared->fetchAll();
//переменные для замены ссылок
$pattern_origin = '(asozd\.duma)';
$replacement_origin = 'sozd.parlament';
//делим на группы конец ссылки на законопроект
$pattern_the_end = '/\/main.nsf\/(\(Spravka\)\?OpenAgent&RN=)([0-9]+-[0-9]+)&[0-9]{1,3}/';
//заменям на конец ссылки на вторую группу
$replacement_the_end = '/bill/$2';
foreach ($laws as $law) :
    //получаем новые ссылки
    $tmp_scr = preg_replace($pattern_origin, $replacement_origin, $law['scr_law']);
    $new_scr = preg_replace($pattern_the_end, $replacement_the_end, $tmp_scr);
    //записываем их в бд
    $prepared = $connection->prepare("UPDATE law SET scr_law = :scr WHERE id_law = :id;");
    $prepared->bindParam(':scr', $new_scr);
    $prepared->bindParam(':id', $law['id_law']);
    $result = $prepared->execute();

endforeach;