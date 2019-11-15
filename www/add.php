<?php
require_once "helpers.php" ;

$rows_cat = select('id, name as categories', 'categories');

$categories = [];

foreach ($rows_cat as $row_cat) {
    $categories[] = $row_cat['categories'];
}
$is_auth = rand(0, 1);

$user_name = 'ksander142'; // укажите здесь ваше имя

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

if (array_key_exists('forma',$errors)) {
    $textForm = 'Пожалуйста, заполните форму';
}

if (array_key_exists('lotName',$errors)) {
    $classDivName = 'form__item--invalid';
}


if (array_key_exists('lotCategories',$errors)) {
    $classDivCat = 'form__item--invalid';
}


if (array_key_exists('lotDescription',$errors)) {
    $classDivDesc = 'form__item--invalid';
}


if (array_key_exists('startCost',$errors)) {
    $classDivCost = 'form__item--invalid';
}


if (array_key_exists('stepRate',$errors)) {
    $classDivStepRate = 'form__item--invalid';
}

if (array_key_exists('lostData',$errors)) {
    $classDivLostData = 'form__item--invalid';
}

if (array_key_exists('formatFile',$errors)) {
    $classDivFormatFile = 'form__item--invalid';
}


if (empty($errors) == true) {

    if (array_key_exists('saveFile',$errors)) {
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


    $insertlot = mysqli_query($link, "insert into lots set name='{$lotName}',description='{$lotDes}',url='{$pathFileLot}',step_cost='{$lotStepCost}',cost='{$lotCost}',date='{$lotLostDate}',user_id='1',categories_id='{$selectIdCategories[0]['id']}'");

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


$selectLastLotID = select('*','lots','ORDER BY id DESC LIMIT 1');
var_dump($_GET);
var_dump($selectLastLotID);
var_dump($errors);
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
var_dump($_POST);
var_dump($_FILES);
