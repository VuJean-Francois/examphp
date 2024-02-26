<?php
require'./inc/db.php';
require_once './smarty-3.1.48/libs/Smarty.class.php';
$fichier = file_get_contents('template/upload.tpl');
echo $fichier;

?>