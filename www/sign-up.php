<?php
require_once "helpers.php" ;

if (isset($_REQUEST[session_name()])) {
    session_start();
}

if (!empty($_SESSION)) {
    return http_response_code(403);
}

$rows_cat = select('id, name as categories', 'categories');
$categories = [];

foreach ($rows_cat as $row_cat) {
    $categories[] = $row_cat['categories'];
}

$is_auth = 0;
$user_name = ''; // укажите здесь ваше имя

$title = 'Главная страница' ;

$errorForm = [
    'form' => 'the good'
];
$rules = [];

if (!empty($_POST)) {

    $rules = [
        'email' => validateEmail(),
        'password' => validatePassword(),
        'name' => validateName(),
        'message' => validateContacts()
    ];

} else {
    $errorForm['form'] = 'Не заполнена форма';
}

$errors = [];

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
$classDivEmail = '';
$classDivPassword = '';
$classDivName = '';
$classDivContacts = '';

if (empty($errors) == false) {

    $classForm = 'form--invalid';
    $textForm = 'Пожалуйста, исправьте ошибки в форме.';
}

if (array_key_exists('form', $errors)) {
    $textForm = 'Пожалуйста, заполните форму';
}

if (array_key_exists('email', $errors)) {
    $classDivEmail = 'form__item--invalid';
}


if (array_key_exists('password', $errors)) {
    $classDivPassword = 'form__item--invalid';
}

if (array_key_exists('name', $errors)) {
    $classDivName = 'form__item--invalid';
}

if (array_key_exists('message', $errors)) {
    $classDivContacts = 'form__item--invalid';
}

if (empty($errors)) {

    $password_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $userName = $_POST['name'];
    $userEmail = $_POST['email'];
    $userMessage = $_POST['message'];
    $link =  getConnection();
    $insertUsers = mysqli_query($link,"insert into users set name='{$userName}', email='{$userEmail}', password='{$password_hash}', contacts='{$userMessage}',roley_id='1'");

    if ($insertUsers == false) {
        $error = mysqli_error($link);
        echo $error;
    }

    mysqli_close($link);
    $url = '/login.php';
    header('Location: ' . $url);
    exit;
}

$content = include_template("sign-up.php",
    [
        'errors' => $errors,
        'classForm' => $classForm,
        'textForm' => $textForm,
        'classDivEmail' => $classDivEmail,
        'classDivPassword' => $classDivPassword,
        'classDivName' => $classDivName,
        'classDivContacts' => $classDivContacts
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