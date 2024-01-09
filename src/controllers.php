<?php
require_once 'business.php';
require_once 'controller_utils.php';


function products(&$model)
{
    $products = get_products();
    $model['products'] = $products;

    return 'products_view';
}
function selected(&$model)
{
    $products = get_products();
    $model['products'] = $products;

    return 'selected_view';
}

function product(&$model)
{
    if (!empty($_GET['id'])) {
        $id = $_GET['id'];

        if ($product = get_product($id)) {
            $model['product'] = $product;
            return 'product_view';
        }
    }

    http_response_code(404);
    exit;
}

function edit(&$model)
{
    $product = [
        'name' => null,
        'author' => null, //autor
        'type' => null, //typ
        'extension' => null, //ext
        '_id' => null
    ];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!empty($_POST['name']) &&
            !empty($_POST['author']) &&
            !empty($_POST['watermark'])
        ) {
            $id = isset($_POST['id']) ? $_POST['id'] : null;
            try{
                if($_FILES['file']['error']==1){
                    throw new Exception('File is too big (max 1MB allowed)');
                }
            
            $ext = isset($_FILES['file']['type']) ?  getImgType($_FILES['file']['type']) : null;
            }catch(Exception $e){
                $ext = 0; 
                $_SESSION['error']=$e->getMessage();
                $model['product'] = $product;

                return 'edit_view';
            }

            $product = [
                'name' => $_POST['name'],
                'author' => $_POST['author'],
                'type' => 1,
                'extension' => $ext
            ];
            $watermark=$_POST['watermark'];

            if (save_product($id, $product, $watermark)) {
                return 'redirect:products';
            }else{
                try{
                    throw new Exception('Error');
                }
                catch(Exception $e)
                {
                    $_SESSION['error']=$e->getMessage();
                }
            }
        }
    } elseif (!empty($_GET['id'])) {
        $product = get_product($_GET['id']);
    }

    $model['product'] = $product;

    return 'edit_view';
}



function delete(&$model)
{
    if (!empty($_REQUEST['id'])) {
        $id = $_REQUEST['id'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            delete_product($id);
            return 'redirect:products';

        } else {
            if ($product = get_product($id)) {
                $model['product'] = $product;
                return 'delete_view';
            }
        }
    }
    http_response_code(404);
    exit;
}


function register(&$model)
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if(isset($_POST['login']) && isset($_POST['pass']) && isset($_POST['pass2']) && isset($_POST['email']))
        {
            $login=trim($_POST['login']);
            $email=trim($_POST['email']);
            $pass=trim($_POST['pass']);
            $pass2=trim($_POST['pass2']);

            if(validate_data($login,$email,$pass,$pass2)){
                
                $hash=password_hash($pass, PASSWORD_DEFAULT);

                $user = [
                    'login' => $login,
                    'email' => $email,
                    'hash' => $hash=password_hash($pass, PASSWORD_DEFAULT)

                ];
                save_user($user);


                return 'redirect:products';

            }else {
                return 'register_view';
            }
        }
    } else {
            return 'register_view';
    }

    return 'redirect:products';
}



function login(&$model)
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if(isset($_POST['user']) && isset($_POST['pass']))
        {
            $login=trim($_POST['user']);
            $pass=trim($_POST['pass']);

            if(!authenticate($login,$pass)){
                return 'login_view';
            }
        }

    } else {
        return 'login_view';
        
    }

    return 'redirect:products';
}



function logout(&$model)
{
    setcookie (session_id(), "", time() - 3600);
    session_destroy();
    session_write_close();

    return 'redirect:products';
}


function cart(&$model)
{
    $model['cart'] = get_cart();
    return 'partial/navbar_view';
}


function add_to_cart()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id1'])) {
        $db = get_db();
        $num = count($db->products->find()->toArray());
        
        
        for($i=1;$i<=$num;$i++){
            $amount = 0;
            if(isset($_POST["$i"])){
                
                $amount = 1;
            }
            $id = $_POST["id$i"];
            $product = get_product($id);
            $cart = &get_cart();
            $cart[$id] = ['name' => $product['name'], 'amount' => $amount];
        }

        return 'redirect:' . $_SERVER['HTTP_REFERER'];
    }
}

function clear_cart()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $_SESSION['cart'] = [];
        return 'redirect:' . $_SERVER['HTTP_REFERER'];
    }
}
