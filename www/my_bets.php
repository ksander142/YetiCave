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
$user_name = '';

if (!empty($_SESSION)) {
    $is_auth = $_SESSION['id'];
    $user_name = $_SESSION['name'];
}

$title = 'Главная страница';
$link = getConnection();
$res = mysqli_query($link,"select lots.id,lots.name,lots.date, lots.url, r.raise_cost,r.add_date as rate_date, c.name as categories,u.contacts from lots join categories c on lots.categories_id = c.id join rate r on lots.id = r.lots_id join users u on lots.user_id = u.id where r.user_id = '{$is_auth}'");
$info_bets = mysqli_fetch_all($res, MYSQLI_ASSOC);
$result = mysqli_query($link,"select lots.id,u.id as usID,u.name as usName,rate.raise_cost from lots join rate on lots.id = rate.lots_id join users u on rate.user_id = u.id where u.id = rate.user_id");
$info_all_bets = mysqli_fetch_all($result, MYSQLI_ASSOC);
$last = null;
$lastArrRate = null;
$win = [];

foreach ($info_all_bets as $arr) {

    if($arr['id'] == $last){

        if ($arr['raise_cost'] > $lastArrRate) {
            $win = $arr;
        }

        $lastArrRate = $arr['raise_cost'];
    }

    $last = $arr['id'];
}

foreach ($info_bets as $value) {

    $win['contacts'] = $value['contacts'];

}

$content = include_template("my_bets.php",
    [
        'info_bets' => $info_bets,
        'win' => $win,
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