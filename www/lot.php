<?php
require_once "helpers.php" ;

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

$is_auth = rand(0, 1);

$user_name = 'ksander142'; // укажите здесь ваше имя
$title = 'Главная страница' ;

$id_get = $_GET['id'];

if (!in_array($id_get,$lot_id)) {
    return http_response_code(404);
}


$lot = select("*,l.name as lName,l.id as lID, c.name as categories","lots l","join categories c on l.categories_id = c.id where l.id ='$id_get'");


$content = include_template("lot.php",
    [
        'lot' => $lot
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
