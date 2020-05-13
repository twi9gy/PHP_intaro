<?php
require('connect.php');
require_once '../vendor/autoload.php';

$loader = new Twig_Loader_Filesystem('../template');
$twig = new Twig_Environment($loader);

if (isset($_POST['number_laws']) && $_POST['number_laws'] != "") {
    //Получаем информацию из базы данных
    $prepared = $connection->prepare("SELECT * FROM law");
    $result = $prepared->execute();
    $laws = $prepared->fetchAll();
    //находим закон
    foreach ($laws as $law) :
        preg_match('/bill\/([0-9]+\-[0-9]+)/', $law['scr_law'], $matches, PREG_OFFSET_CAPTURE);
        if ($matches[1][0] == $_POST['number_laws']) {
            break;
        }
    endforeach;
} elseif (isset($_POST['name_laws']) && $_POST['name_laws'] != "") {
    $prepared = $connection->prepare("SELECT * FROM law WHERE title_law = :name_law");
    $prepared->bindParam(':name_law', $_POST['name_laws']);
    $result = $prepared->execute();
    $law = $prepared->fetch();
}
if ($law) {
    $template = $twig->loadTemplate('laws_info.php');
    echo $template->render(array('law'=> $law));
} else {
    echo "Ошибка!!!Введены не корректные данные.";
}