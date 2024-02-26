<?php
session_start();
require'./inc/db.php';
require_once './vendor/phpmailer/phpmailer/src/PHPMailer.php';
require_once './smarty-3.1.48/libs/Smarty.class.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Page inaccessible si la personne est connecté
$file = file_get_contents('template/register.tpl');
echo $file;

if(isset($_POST['submit'])){

    if(!empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['confirm-password'])){
    
        $sql = 'INSERT INTO utilisateurs SET
                        
                        email = :email,
                        password = :password,';

        // $req=$db->query('SELECT * FROM utilisateurs WHERE email = "'.$_POST['email'].'" LIMIT 1');
        $verif1 = $db->prepare('SELECT * FROM utilisateurs WHERE email = :email LIMIT 1');
        $verif1->bindParam(':email', $_POST['email']);
        $verif1->execute();
        $utilisateur = $verif1->fetch();

        if($utilisateur){
            echo "un utilisateur avec cet email existe deja!";
        } else {
                if(($_POST['password']) === ($_POST['confirm-password'])){

                    $passwordHash = password_hash($_POST['password'],PASSWORD_DEFAULT);

            

                    $req=$db->prepare("$sql");

                    echo $password;
                    $req->bindParam(":email",$_POST['email'],PDO::PARAM_STR);
                    $req->bindParam(":password",$passwordHash, PDO::PARAM_STR);
                        
                        
                        if($req->execute())
                        {
                            
                            //Load Composer's autoloader
                            require './vendor/autoload.php';

                            //Create an instance; passing `true` enables exceptions
                            $mail = new PHPMailer(true);

                            try {
                            //Server settings
                                $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                                $mail->isSMTP();                                            //Send using SMTP
                                $mail->Host       = 'dwwm2324.fr';                     //Set the SMTP server to send through
                                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                                $mail->Username   = 'contact@dwwm2324.fr';                     //SMTP username
                                $mail->Password   = 'm%]E5p2%o]yc';                               //SMTP password
                                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                                $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                                //Recipients
                                $mail->setFrom('contact@dwwm2324.fr', 'PHP life');
                                $mail->addAddress($user['email']);     //Add a recipient
                                //Content
                                $mail->isHTML(true);                                  //Set email format to HTML
                                $mail->Subject = 'Inscription réussi';
                                $mail->Body    = '';
                                $mail->AltBody = '';

                                $mail->send();
                                echo 'Vous êtes bien inscrit';
                                } catch (Exception $e) {
                                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                                }
                            }

                                // Je redirige vers login-form.php
                                header('location:login-form.php');
                                exit;
                                }
                                else
                                {
                                    // Si erreur SQL
                                    echo "Impossible d'enregistrer le mot de passe";
                                }
                }        
                
            }
        
}

?>