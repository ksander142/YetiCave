<?php
require_once "helpers.php" ;

if (isset($_REQUEST[session_name()])) {
    session_start();
}

$rows_cat = select('id, name as categories', 'categories');

$categories = [];

foreach ($rows_cat as $row_cat) {
    $categories[] = $row_cat['categories'];
}

$lots = select('*,lots.name as lName,lots.id as lID, c.name as categories','lots','join categories c on lots.categories_id = c.id');

$is_auth = 0;
$user_name = ''; // укажите здесь ваше имя

if (!empty($_SESSION)) {
    $is_auth = $_SESSION['id'];
    $user_name = $_SESSION['name'];
}

$title = 'Главная страница' ;

$content = include_template("main.php",
    [
        'products' => $lots,
        'categories' => $categories
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


?>


