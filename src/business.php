<?php


use MongoDB\BSON\ObjectID;

function resizeImg($i, $w, $h)
{
    $oldw = imagesx($i);
    $oldh = imagesy($i);
    $image = imagecreatetruecolor($w, $h);
    imagecopyresampled($image, $i, 0, 0, 0, 0, $w, $h, $oldw, $oldh);
    return $image;
}

function getImgType($type)
{
    if($type =="image/png"){
        return ".png";
    }
    if($type =="image/jpeg"){
        return ".jpg";
    }
    throw new Exception('The uploaded file does not match accepted format');
}


function uploadAllImgs($id, $watermark){
    if($_FILES){
        try{
            if($_FILES["file"]["error"]==1){
                throw new Exception('File is too big (max 1MB allowed)');

            }else{
                
                $t=getImgType($_FILES["file"]["type"]);

                $defaultimg="../../images/"."$id"."$t";
                $imgcopy="../../images/"."$id"."min"."$t";
                $imgmarked="../../images/"."$id"."wm"."$t";
        
                if (move_uploaded_file($_FILES['file']['tmp_name'], $defaultimg)) {
                    $img = ($t==".jpg") ? imagecreatefromjpeg($defaultimg) : imagecreatefrompng($defaultimg);
                    $img2 = ($t==".jpg") ? imagecreatefromjpeg($defaultimg) : imagecreatefrompng($defaultimg);
                    
                    if (!$img) {                      
                            throw new Exception('The uploaded file is corrupted');
                    }
                    $h = imagesy($img);
                    $w = round(imagesx($img)/2);
                    $white = imagecolorallocate($img2, 255, 255, 255);
                    $black = imagecolorallocate($img2, 0, 0, 0);
                    $resizedImage = resizeImg($img,200,125); //resize 200 125
                    
                    // Add text to image
                    for($i=0;$i<$h;$i+=100)
                    {
                        imagestring($img2, 5, 0, $i, $watermark, $white);
                        imagestring($img2, 5, 0, $i+50, $watermark, $black);
                        if ($w>300){
                            imagestring($img2, 5, $w, $i, $watermark, $white);
                            imagestring($img2, 5, $w, $i+50, $watermark, $black);
                        }
                        

                    }
                    if (!imagejpeg($resizedImage, $imgcopy) || !imagejpeg($img2, $imgmarked)) {
                        throw new Exception('failed to save a copy of an image');
                    }
                    
                } else {
                    throw new Exception('failed Upload');
                }
            }
        }
        catch(Exception $e)
        {
            $_SESSION['error']=$e->getMessage();
        }
    }
}


function validate_data($login, $email, $pass, $pass2)
{
    try{
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            throw new Exception('Email jest niepoprawny');
        }
        if($pass !==$pass2){
            throw new Exception('Hasła się róźnią');
        }
        if(get_login_check($login)){
            throw new Exception('Login już jest zajęty');
        }
        

        return true;

    }catch(Exception $e){
        $_SESSION['error']=$e->getMessage();
        return false;
    }
    //db.uzytkownicy.insertOne({'login':'$l', 'haslo':'$hash', 'email':'$e'});
}


function get_db()
{
    $mongo = new MongoDB\Client(
        "mongodb://localhost:27017/wai",
        [
            'username' => 'wai_web',
            'password' => 'w@i_w3b',
        ]);

    $db = $mongo->wai;
    return $db;
}

function get_products()
{
    $db = get_db();
    return $db->products->find()->toArray();
}


function get_users()
{
    $db = get_db();
    return $db->users->find()->toArray();
}

function get_products_by_category($cat)
{
    $db = get_db();
    $products = $db->products->find(['cat' => $cat]);
    return $products;
}

function get_product($id)
{
    $db = get_db();
    return $db->products->findOne(['_id' => new ObjectID($id)]);
}

function get_login_check($login)
{
    $db = get_db();
    $result = $db->users->find(['login' => $login])->toArray();
    return(!empty($result));
}

function save_user($user)
{
    $db = get_db();
    $db->users->insertOne($user);
}

function authenticate($login, $pass){
    try{
        $db = get_db();
        
        $result = $db->users->findOne(['login' => $login]);
        if(empty($result))
        {
            throw new Exception('Błędne dane logowania');
        }
        $hash=$result['hash'];
        
        if(password_verify($pass, $hash)){
            
            $_SESSION['islogged']=1;
            $_SESSION['loggedid']=session_id();
            $_SESSION['loggeduser']=$login;

        }else{
            throw new Exception('Błędne dane logowania');
        }
    }catch(Exception $e){
        $_SESSION['error']=$e->getMessage();
        return false;
    }
    return true;
}

function save_product($id, $product, $watermark)
{
    $db = get_db();
    if($_FILES['file']['error']==0)
    { 
        if ($id == null) {
            $insertResult = $db->products->insertOne($product);
            $newDocID = $insertResult->getInsertedId();

            if($_FILES){
                if($_FILES["file"]["error"]==0){
                    uploadAllImgs($newDocID,$watermark);
                }
            }
        } else {
            $db->products->replaceOne(['_id' => new ObjectID($id)], $product);
        }
        return true;
    }
    return false;
}

function delete_product($id)
{
    $db = get_db();
    $db->products->deleteOne(['_id' => new ObjectID($id)]);
}

function drop_users()
{
    $db = get_db();
    $db->users->drop();
}
