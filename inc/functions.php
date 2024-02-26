<?php
require'./inc/db.php';


function setToken()
{
 
    $caracteres = 'azertyuiopqsdfghjklmwxcvbn1234567890';
    $token = '';
    for($i=0;$i<10;$i++)
    {
        $token.= $caracteres[rand(0,strlen($caracteres)-1)]; 
    }
    return $token;
}

function addFileInput($files=null)
{
    //si je n'ai pas de fichier
    if($files == null || !$files) return false;
    
    $bool = []; 
    for($i=0; $i<count($files); $i++)
    {
        if(move_uploaded_file($files['tmp_name'][$i],$files['name'][$i]))
        {
            $bool[$i] = true;
        }
        else{
            $bool[$i] = false;
        }
    }
    return $bool;
}

?>