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

if (!empty($_GET['search'])) {
    $_GET['search'] = trim($_GET['search']);
}

if ($_GET['search'] == '') {
    $errors = ['string' => 'empty'];
}

$current_page = $_GET['page'] ?? 1;
$page_items = 9;

if (empty($errors)) {

    $count_select = select("*,lots.name as lName,lots.id as lID, c.name as categories, MATCH(lots.name,description) AGAINST('{$_GET['search']}') as score", "lots", "join categories c on lots.categories_id = c.id where MATCH(lots.name,description) AGAINST('{$_GET['search']}') " );
    $count_lots = count($count_select);
    $pages_count = ceil($count_lots/$page_items);
    $offset = ($current_page - 1) * $page_items;
    $pages = range(1, $pages_count);

} else {

    $count_lots = 0;
    $pages_count = ceil($count_lots/$page_items);
    $offset = ($current_page - 1) * $page_items;
    $pages = range(1, $pages_count);
}

if (empty($errors)) {
    $lots = select("*,lots.name as lName,lots.id as lID, c.name as categories, MATCH(lots.name,description) AGAINST('{$_GET['search']}') as score", "lots", "join categories c on lots.categories_id = c.id where MATCH(lots.name,description) AGAINST('{$_GET['search']}') ORDER BY date DESC  LIMIT {$page_items} OFFSET {$offset}" );
}

$content = include_template("search.php",
    [
        'search' => $_GET['search'],
        'lots' => $lots,
        'pages_count' => $pages_count,
        'current_page' => $current_page,
        'pages' => $pages
    ]);

echo (include_template("layout.php",
    [
        'categories' => $categories,
        'content' => $content,
        'title' => $title,
        'user_name' => $user_name,
        'is_auth' => $is_auth,
        'search' => $_GET['search']
    ]
));
