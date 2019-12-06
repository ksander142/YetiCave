<?php

require_once "helpers.php" ;

if (isset($_REQUEST[session_name()])) {
    session_start();
}

$is_auth = 0;
$user_name = ''; // укажите здесь ваше имя
$title = 'Главная страница' ;

if (!empty($_SESSION)) {
    $is_auth = $_SESSION['id'];
    $user_name = $_SESSION['name'];
}

$rows_cat = select('id, name as categories', 'categories');
$categories = [];
$errors = [];
$lots = '';
foreach ($rows_cat as $row_cat) {
    $categories[] = $row_cat['categories'];
}

$search = '';

if (!empty($_GET['search'])) {
    $search = trim($_GET['search']);
}

if ($search == '') {
    $errors = ['stroka' => 'empty'];
}

if (empty($errors)) {
    $lots = select("*,lots.name as lName,lots.id as lID, c.name as categories, MATCH(lots.name,description) AGAINST('{$search}') as score", "lots", "join categories c on lots.categories_id = c.id where MATCH(lots.name,description) AGAINST('{$search}')" );
}

$content = include_template("search.php",
    [
        'search' => $search,
        'lots' => $lots
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
