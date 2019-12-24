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
$rules = [];
$lot_cost = $lot[0]['cost'] + $lot[0]['step_cost'];
$bets_cost = '';
$rate = select("raise_cost,rate.add_date, u.name as users","rate","join users u on rate.user_id = u.id where rate.lots_id ='{$id_get}' ORDER BY raise_cost DESC LIMIT 10");

if (!empty($_POST)) {

    for($i = 0; $i < strlen($_POST['cost']); $i++) {

        if ($_POST['cost'][$i] != ' ') {
            $bets_cost .= $_POST['cost'][$i];
        }

    }

    $_POST['cost'] = $bets_cost;
    $rules = [
        'cost' => validateCost()
    ];

    if ($rules['cost'] == 'the good') {

        if ($_POST['cost'] < $lot_cost ) {
            $rules['cost'] = 'значение должно быть больше, чем текущая цена лота + шаг ставки, без лишних символов';
        }

    }

}

$errors = [];

foreach ($rules as $key => $values) {

    if ($values != 'the good') {
        $errors[$key] = $values;
    }

}

$classDivError = '';

if (array_key_exists('cost', $errors)) {
    $classDivError = 'form__item--invalid';
}

if (empty($errors)) {

    $link =  getConnection();
    $InsertBets = mysqli_query($link,"insert into rate set raise_cost='{$bets_cost}', user_id='{$is_auth}', lots_id='{$id_get}'");
    $UpdateCostLot = mysqli_query($link,"update lots set cost='{$bets_cost}' where id = '{$id_get}'");
}

$content = include_template("lot.php",
    [
        'lot' => $lot,
        'is_auth' => $is_auth,
        'lot_cost' => $lot_cost,
        'classDivError' => $classDivError,
        'errors' => $errors,
        'rate' => $rate
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
