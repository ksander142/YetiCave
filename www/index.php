<?php
require_once "helpers.php" ;

$products = [
    ["name" => "2014 Rossignol District Snowboard	",
        "categories" => "Доски и лыжи",
        "cost" => "10999",
        "url" => "img/lot-1.jpg"],
    ["name" => "DC Ply Mens 2016/2017 Snowboard",
        "categories" => "Доски и лыжи",
        "cost" => "159999",
        "url" => "img/lot-2.jpg"],
    ["name" => "Крепления Union Contact Pro 2015 года размер L/XL",
        "categories" => "Крепления",
        "cost" => "8000",
        "url" => "img/lot-3.jpg"],
    ["name" => "Ботинки для сноуборда DC Mutiny Charocal",
        "categories" => "Ботинки",
        "cost" => "10999",
        "url" => "img/lot-4.jpg"],
    ["name" => "Куртка для сноуборда DC Mutiny Charocal",
        "categories" => "Одежда",
        "cost" => "7500",
        "url" => "img/lot-5.jpg"],
    ["name" => "Маска Oakley Canopy",
        "categories" => "Разное",
        "cost" => "5400",
        "url" => "img/lot-6.jpg"]
];
$categories = [
    "Доски и лыжи",
    "Крепления",
    "Ботинки",
    "Одежда",
    "Инструменты",
    "Разное"];

$is_auth = rand(0, 1);
$user_name = 'ksander142'; // укажите здесь ваше имя

$title='Главная страница' ;
$content=include_template("main.php",
    $arr=[
        'products'=>$products,
        'categories'=>$categories,]);

echo (include_template("layout.php",
    $arr=[
        'categories'=>$categories,
        'content'=>$content,
        'title' => $title,
        'user_name' => $user_name,
        'is_auth' =>$is_auth,]));
?>
