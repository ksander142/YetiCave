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

$is_auth = 0;
$user_name = ''; // укажите здесь ваше имя

if (!empty($_SESSION)) {
    $is_auth = $_SESSION['id'];
    $user_name = $_SESSION['name'];
}

if ($is_auth != '0' && $is_auth != 0) {
    require_once "getwinner.php" ;
}

$title = 'Главная страница';
$current_page = $_GET['page'] ?? 1;
$page_items = 9;
$count_select_lots = select('COUNT(*) as cnt','lots');
$count_lots = $count_select_lots[0]['cnt'];
$pages_count = ceil($count_lots/$page_items);
$offset = ($current_page - 1) * $page_items;
$pages = range(1, $pages_count);
$lots = select('*,lots.name as lName,lots.id as lID, c.name as categories','lots',"join categories c on lots.categories_id = c.id ORDER BY date DESC LIMIT {$page_items} OFFSET {$offset}");

$content = include_template("main.php",
    [
        'products' => $lots,
        'categories' => $categories,
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
    ]
));

?>


