<?php
// Page inaccessible si la personne est connecté
require './inc/db.php';
require_once './inc/functions.php';
include 'index.php';
    
$fichier = file_get_contents('template/login.tpl');
echo $fichier;

if(isset($_POST['submit'])){

        if(!empty($_POST['email']) && !empty($_POST['password'])) {
            
            $_SESSION['email'] = $_POST['email'];
            $_SESSION['password'] = $password;
            $confirm=$db->prepare('SELECT * FROM utilisateurs WHERE email = :email LIMIT 1');
            $confirm->bindValue(':email',$_POST['email'], PDO::PARAM_STR);
            $cle = setToken();

            if($confirm->rowCount() == 0)
            {
            echo 'Adresse non trouvable';
            exit;
            }
            $resultat = $confirm->fetch(PDO::FETCH_ASSOC);
            if(password_verify($_POST['password'],$resultat['password']))
            {
                setcookie('email',$resultat['email'],(time()+900));
                setcookie('password',$resultat['password'],(time()+900));
                $infos_cookie = array(
                    'email'        => $resultat['email'],
                    'password'    =>$resultat['password']);
                setcookie('utilisateur',serialize($infos_cookie),(time()+900));    
                
            
            }
        }
}
        

?>