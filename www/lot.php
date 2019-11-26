<?php
require_once "helpers.php" ;
if (isset($_REQUEST[session_name()])) session_start();

$rows_cat = select('id, name as categories', 'categories');

$categories = [];

foreach ($rows_cat as $row_cat) {
    $categories[] = $row_cat['categories'];
}

$rows_lot_ID = select('id','lots');

$lot_id = [];
foreach ($rows_lot_ID as $row_lotID) {
    $lot_id[] = $row_lotID['id'];

}

$is_auth = 0;

if (!empty($_SESSION)) {
    $is_auth = $_SESSION['id'];
}

$user_name = ''; // укажите здесь ваше имя

if (!empty($_SESSION)) {
    $user_name = $_SESSION['name'];
}

$title = 'Главная страница' ;

$id_get = $_GET['id'];

if (!in_array($id_get,$lot_id)) {
    return http_response_code(404);
}


$lot = select("*,l.name as lName,l.id as lID, c.name as categories","lots l","join categories c on l.categories_id = c.id where l.id ='$id_get'");


$content = include_template("lot.php",
    [
        'lot' => $lot,
        'is_auth' => $is_auth
    ]);

echo (include_template("layout.php",
    [
        'categories' => $categories,
        'content' => $content,
        'title' => $title,
        'user_name' => $user_name,
        'is_auth' => $is_auth,
    ]
));
