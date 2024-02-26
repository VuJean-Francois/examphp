<?php
// Page accessible uniquement aux personnes connectées
session_start();
require './inc/db.php';
require_once('autoload.php');
require_once './smarty-3.1.48/libs/Smarty.class.php';

$smarty = new Smarty;

$smarty->display('index.tpl');
$fichier = file_get_contents('template/index.tpl');
echo $fichier;

if($_COOKIE['email'] && $_COOKIE['password'])
{
    
    $cookie_infos = unserialize($_COOKIE['utilisateur']);
    var_dump($cookie_infos);
    $sql = $db->prepare('SELECT * FROM utilisateurs WHERE email = :email AND password = :password LIMIT 1');
    $sql->bindValue(':email',$_COOKIE['email'],PDO::PARAM_INT);
    $sql->bindValue(':password',$_COOKIE['password'],PDO::PARAM_STR);
    $sql->execute();
    if($sql->rowCount() == 1)
    {
        $resultat = $sql->fetch(PDO::FETCH_ASSOC);
        $_SESSION['connect'] = 1;
        echo 'Bienvenue ';
        // Pour executer une requête directement
        //$req = $dbh->query('SELECT * FROM utilisateurs');
        $users = $dbh->query('SELECT * FROM utilisateurs')->fetchAll(PDO::FETCH_ASSOC);

    }
}
?>