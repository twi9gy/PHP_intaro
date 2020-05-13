<?php
require_once '../vendor/autoload.php';

$loader = new Twig_Loader_Filesystem('../template');
$twig = new Twig_Environment($loader);

$template = $twig->loadTemplate('main.php');
echo $template->render(array());