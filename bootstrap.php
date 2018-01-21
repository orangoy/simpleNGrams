<?php

ini_set('default_charset', 'UTF-8');
$root = dirname(__FILE__);
include $root."/vendor/autoload.php";

// Twig
$twigloader = new Twig_Loader_Filesystem($root.'/templates');
$twig = new Twig_Environment($twigloader);
