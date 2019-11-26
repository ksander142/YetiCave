<?php
require_once "helpers.php" ;

$rows_cat = select('id, name as categories', 'categories');

$categories = [];

foreach ($rows_cat as $row_cat) {
    $categories[] = $row_cat['categories'];
}

$is_auth = 0;
$user_name = '';
$title = 'Главная страница' ;
$errorForm = [
    'form' => 'the good'
];
$rules = [];

if (!empty($_POST)) {

    $rules = [

        'email' => validLoginEmail(),
        'password' => validatePassword()

    ];

} else {
    $errorForm['form'] = 'Пожалуйста, заполните форму';
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

$userBase = [ ];

if (empty($errors)) {

    $selectUser = select('*', 'users',"where email = '{$_POST['email']}' ");

    if (!empty($selectUser)) {

        $userBase = $selectUser;

          if (!password_verify($_POST['password'], $selectUser[0]['password'])) {

              $errors = ['password' => 'Введен неверный пароль'];

              if (array_key_exists('password', $errors)) {
                  $classDivPassword = 'form__item--invalid';
              }

          }

    } else {

        $errors = ['email' => 'Такой email не зарегистрирован'];

        if (array_key_exists('email', $errors)) {
            $classDivEmail = 'form__item--invalid';
        }

    }

}

if (empty($errors)) {

    session_start();
    $_SESSION['id'] = $userBase[0]['id'];
    $_SESSION['name'] = $userBase[0]['name'];
    $url = '/index.php';
    header('Location: ' . $url);
    exit;
}

$content = include_template("login.php",
    [
        'errors' => $errors,
        'classForm' => $classForm,
        'textForm' => $textForm,
        'classDivEmail' => $classDivEmail,
        'classDivPassword' => $classDivPassword
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
