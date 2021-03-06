<?php
require_once "helpers.php" ;

if (isset($_REQUEST[session_name()])) {
    session_start();
}

$is_auth = 0;
$user_name = ''; // укажите здесь ваше имя

if (empty($_SESSION)) {
    return http_response_code(403);
}

if (!empty($_SESSION)) {
    $is_auth = $_SESSION['id'];
    $user_name = $_SESSION['name'];
}

$rows_cat = select('id, name as categories', 'categories');
$categories = [];

foreach ($rows_cat as $row_cat) {
    $categories[] = $row_cat['categories'];
}

$title = 'Главная страница' ;
$rules = [];
$errorForm = [
  'forma' => 'the good'
];

if(!empty($_POST)) {

$rules = [
    'formatFile' => validateFormatFile(),
    'saveFile' => '',
    'startCost' => validateCost(),
    'stepRate' => validateStepRate(),
    'lostData' => validateLostData(),
    'lotName' => validateFileName(),
    'lotDescription' => validateDescription(),
    'lotCategories' => validateCategories()
];

    if ($rules['formatFile'] == 'the good') {
        saveFile();
        $rules['saveFile'] = 'the good';
        } else {
            $rules['saveFile'] .= "Не удалось сохранить файл: ";
    }

} else {
    $errorForm['forma'] = 'Не заполнена форма';
}

$errors =[];

foreach ($errorForm as $key => $values) {
    if ($values != 'the good') {
        $errors[$key] = $values;
    }
}

foreach ($rules as $key => $values) {
    if ($values != 'the good') {
        $errors[$key] = $values;
    }
}

$classForm = '';
$textForm = '';
$classDivName = '';
$classDivCat = '';
$classDivDesc = '';
$classDivCost = '';
$classDivStepRate = '';
$classDivLostData = '';
$classDivFormatFile = '';

if (empty($errors) == false) {

    $classForm = 'form--invalid';
    $textForm = 'Пожалуйста, исправьте ошибки в форме.';
}

if (array_key_exists('forma', $errors)) {
    $textForm = 'Пожалуйста, заполните форму';
}

if (array_key_exists('lotName', $errors)) {
    $classDivName = 'form__item--invalid';
}


if (array_key_exists('lotCategories', $errors)) {
    $classDivCat = 'form__item--invalid';
}

if (array_key_exists('lotDescription', $errors)) {
    $classDivDesc = 'form__item--invalid';
}

if (array_key_exists('startCost', $errors)) {
    $classDivCost = 'form__item--invalid';
}

if (array_key_exists('stepRate', $errors)) {
    $classDivStepRate = 'form__item--invalid';
}

if (array_key_exists('lostData', $errors)) {
    $classDivLostData = 'form__item--invalid';
}

if (array_key_exists('formatFile', $errors)) {
    $classDivFormatFile = 'form__item--invalid';
}

if (empty($errors) == true) {

    if (array_key_exists('saveFile', $errors)) {
        $classDivFormatFile = 'form__item--invalid';
    }

}

if (empty($errors) == true) {

    $link =  getConnection();
    $lotName = $_POST['name'];
    $lotDes = $_POST['description'];
    $lotCost = $_POST['cost'];
    $lotStepCost = $_POST['step_cost'];
    $lotLostDate= $_POST['lot-date'];
    $lotCat = $_POST['categories'];
    $selectIdCategories = select('id', 'categories', "where name = '{$_POST['categories']}'");
    $fileList = scandir(__DIR__ . '/uploads/');
    $countFileList = count($fileList);
    $lastIdFileList = 0;
    $lastIdFileList = $countFileList - 1;
    $pathFileLot = '/uploads/' . $fileList[$lastIdFileList];
    $insertlot = mysqli_query($link, "insert into lots set name='{$lotName}',description='{$lotDes}',url='{$pathFileLot}',step_cost='{$lotStepCost}',cost='{$lotCost}',date='{$lotLostDate}',user_id='{$is_auth}',categories_id='{$selectIdCategories[0]['id']}'");

    if ($insertlot == false) {
        $error = mysqli_error($link);
        echo $error;
    }

    $selectLastLotID = select('*','lots','ORDER BY id DESC LIMIT 1');
    $id = $selectLastLotID[0]['id'];
    mysqli_close($link);
    $url = '/lot.php?id=' . $id;
    header('Location: ' . $url);
    exit;
}

$content = include_template("add.php",
    [
            'rows_cat' => $rows_cat,
            'errors' => $errors,
            'classForm' => $classForm,
            'textForm' => $textForm,
            'classDivName' => $classDivName,
            'classDivCat' => $classDivCat,
            'classDivDesc' => $classDivDesc,
            'classDivCost' => $classDivCost,
            'classDivStepRate' => $classDivStepRate,
            'classDivLostData' => $classDivLostData,
            'classDivFormatFile' => $classDivFormatFile
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