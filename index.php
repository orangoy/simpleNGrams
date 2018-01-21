<?php

include dirname(__FILE__)."/bootstrap.php";

if(isset($_POST['tekst'])) {
   include(dirname(__FILE__).'/ngram.php');
} else {
echo $twig->render('index.twig');
}