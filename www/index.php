<?php
require_once "helpers.php" ;


$link=mysqli_connect("db","root","root","yeti");
if($link == false) {
    $error=mysqli_connect_error();
    echo $error;
}
else {
    echo "установлено соединение";
}
mysqli_set_charset($link,"utf8");

$select="select id,categories from categories";
$result=mysqli_query($link,$select);
if($result == false){
    $error=mysqli_error($link);
    echo $error;
}
$rows=mysqli_fetch_all($result,MYSQLI_ASSOC);
$cat=[];
foreach ($rows as $row)
{
    $cat[]=$row['categories'];
}
$selectlots="select * from lots join categories c on lots.categories_id = c.id";
$resultlots=mysqli_query($link,$selectlots);
if($resultlots == false){
    $error=mysqli_error($link);
    echo $error;
}
$rowslots=mysqli_fetch_all($resultlots,MYSQLI_ASSOC);
$lots=[];
foreach ($rowslots as $rowslot)
{
    $lots[]=$rowslot;
}
//var_dump($lots);
$products = [
    [
        "name" => "2014 Rossignol District Snowboard",
        "categories" => "Доски и лыжи",
        "cost" => 10999,
        "url" => "img/lot-1.jpg",
        "date" => "2019-10-11",
    ],
    [
        "name" => "DC Ply Mens 2016/2017 Snowboard",
        "categories" => "Доски и лыжи",
        "cost" => 159999,
        "url" => "img/lot-2.jpg",
        "date" => "2019-10-12",
    ],
    [
        "name" => "Крепления Union Contact Pro 2015 года размер L/XL",
        "categories" => "Крепления",
        "cost" => 8000,
        "url" => "img/lot-3.jpg",
        "date" => "2019-10-13",
    ],
    [
        "name" => "Ботинки для сноуборда DC Mutiny Charocal",
        "categories" => "Ботинки",
        "cost" => 10999,
        "url" => "img/lot-4.jpg",
        "date" => "2019-10-14",
    ],
    [
        "name" => "Куртка для сноуборда DC Mutiny Charocal",
        "categories" => "Одежда",
        "cost" => 7500,
        "url" => "img/lot-5.jpg",
        "date" => "2019-10-15",
    ],
    [
        "name" => "Маска Oakley Canopy",
        "categories" => "Разное",
        "cost" => 5400,
        "url" => "img/lot-6.jpg",
        "date" => "2019-10-16",
    ],
];

/*
$categories = [
    "Доски и лыжи",
    "Крепления",
    "Ботинки",
    "Одежда",
    "Инструменты",
    "Разное",
    ];
*/
$is_auth = rand(0, 1);
$user_name = 'ksander142'; // укажите здесь ваше имя

$title='Главная страница' ;
$content=include_template("main.php",
    [
        'products' => $lots,
        'categories' => $cat
    ]);

echo (include_template("layout.php",
    [
        'categories' => $cat,
        'content' => $content,
        'title' => $title,
        'user_name' => $user_name,
        'is_auth' => $is_auth,
    ]));
?>