<?php


/**
 * Проверяет переданную дату на соответствие формату 'ГГГГ-ММ-ДД'
 *
 * Примеры использования:
 * is_date_valid('2019-01-01'); // true
 * is_date_valid('2016-02-29'); // true
 * is_date_valid('2019-04-31'); // false
 * is_date_valid('10.10.2010'); // false
 * is_date_valid('10/10/2010'); // false
 *
 * @param string $date Дата в виде строки
 *
 * @return bool true при совпадении с форматом 'ГГГГ-ММ-ДД', иначе false
 */
function is_date_valid(string $date) : bool {
    $format_to_check = 'Y-m-d';
    $dateTimeObj = date_create_from_format($format_to_check, $date);

    return $dateTimeObj !== false && array_sum(date_get_last_errors()) === 0;
}

/**
 * Создает подготовленное выражение на основе готового SQL запроса и переданных данных
 *
 * @param $link mysqli Ресурс соединения
 * @param $sql string SQL запрос с плейсхолдерами вместо значений
 * @param array $data Данные для вставки на место плейсхолдеров
 *
 * @return mysqli_stmt Подготовленное выражение
 */
function db_get_prepare_stmt($link, $sql, $data = []) {
    $stmt = mysqli_prepare($link, $sql);

    if ($stmt === false) {
        $errorMsg = 'Не удалось инициализировать подготовленное выражение: ' . mysqli_error($link);
        die($errorMsg);
    }

    if ($data) {
        $types = '';
        $stmt_data = [];

        foreach ($data as $value) {
            $type = 's';

            if (is_int($value)) {
                $type = 'i';
            }
            else if (is_string($value)) {
                $type = 's';
            }
            else if (is_double($value)) {
                $type = 'd';
            }

            if ($type) {
                $types .= $type;
                $stmt_data[] = $value;
            }
        }

        $values = array_merge([$stmt, $types], $stmt_data);

        $func = 'mysqli_stmt_bind_param';
        $func(...$values);

        if (mysqli_errno($link) > 0) {
            $errorMsg = 'Не удалось связать подготовленное выражение с параметрами: ' . mysqli_error($link);
            die($errorMsg);
        }
    }

    return $stmt;
}

/**
 * Возвращает корректную форму множественного числа
 * Ограничения: только для целых чисел
 *
 * Пример использования:
 * $remaining_minutes = 5;
 * echo "Я поставил таймер на {$remaining_minutes} " .
 *     get_noun_plural_form(
 *         $remaining_minutes,
 *         'минута',
 *         'минуты',
 *         'минут'
 *     );
 * Результат: "Я поставил таймер на 5 минут"
 *
 * @param int $number Число, по которому вычисляем форму множественного числа
 * @param string $one Форма единственного числа: яблоко, час, минута
 * @param string $two Форма множественного числа для 2, 3, 4: яблока, часа, минуты
 * @param string $many Форма множественного числа для остальных чисел
 *
 * @return string Рассчитанная форма множественнго числа
 */
function get_noun_plural_form (int $number, string $one, string $two, string $many): string
{
    $number = (int) $number;
    $mod10 = $number % 10;
    $mod100 = $number % 100;

    switch (true) {
        case ($mod100 >= 11 && $mod100 <= 20):
            return $many;

        case ($mod10 > 5):
            return $many;

        case ($mod10 === 1):
            return $one;

        case ($mod10 >= 2 && $mod10 <= 4):
            return $two;

        default:
            return $many;
    }
}

/**
 * Подключает шаблон, передает туда данные и возвращает итоговый HTML контент
 * @param string $name Путь к файлу шаблона относительно папки templates
 * @param array $data Ассоциативный массив с данными для шаблона
 * @return string Итоговый HTML
 */
function include_template($name, array $data = [])
{
    $name = 'templates/' . $name;
    $result = '';

    if (!is_readable($name)) {
        return $result;
    }

    ob_start();
    extract($data);
    require $name;

    $result = ob_get_clean();

    return $result;
}


/**
 * @param int $num
 * @return string
 */
function getCost( $num): string
{
    $num = ceil($num);
    $str = (string)$num;
    $lenght = strlen($str);

    if ($num > 1000 || $num == 1000) {

        if ($lenght == 4) {
            return $str[0].' '.substr($str,1). '₽';
        }

        if ($lenght == 5) {
            return $str[0]. $str[1].' '.substr($str,2). '₽';
        }

        if ($lenght == 6) {
            return $str[0]. $str[1]. $str[2].' '.substr($str,3). '₽';
        }

        if ($lenght == 7) {
            return $str[0]. $str[1]. $str[2]. $str[3].' '.substr($str,4). '₽';
        }
    }
        return $str.'₽';


}

/**
 * @param string $time
 * @return array
 */
function getTime(string $time): array
{
    $now_time = time();
    $end_time = strtotime($time);
    $ost = $end_time - $now_time ;
    $minute = $ost / 60;

    if ($minute < 0) {
        $minute = 0;
    }

    $min = floor($minute); //floor округляет до целого в меньшую сторону
    $hour = $min / 60;
    $h = floor($hour); //floor округляет до целого в меньшую сторону
    $min = $min - $h * 60;

    if ($min < 10) {
        $min = "0$min";
    }

    $res = [(int)$h, $min];

    if ($res[0] < 0) {
        $res[0] = 0;
    }

    if ($res[1] < 0) {
        $res[1] = 0;
    }

    return $res;
}

/**
 * @return false|mysqli
 */
function getConnection()
{
    if (isset($link)) {
        return $link;
    }

    $link = mysqli_connect("db", "root", "root", "yeti");

    if ($link == false) {
        $error = mysqli_connect_error();
        echo $error;
        exit;
    }

    mysqli_set_charset($link, "utf8");

    return $link;

}


/**
 * @param string $what
 * @param string $from
 * @param string $conditions
 * @return array
 */
function select(string $what, string $from, string $conditions = "WHERE 1") : array
{
    $link =  getConnection();
    $result = mysqli_query($link, "select" . " " . $what . " " . "from" . " " . $from . " " . $conditions);

    if ($result == false) {
        $error = mysqli_error($link);
        echo $error;
    }

    $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);

    return $rows;
}


/**
 * @param $index
 * @return mixed|string
 */
function getPostVal($index)
{
    if (!isset($_POST[$index])) {
        return "";
    }
    return $_POST[$index];
}


/**
 * @param $tmp_name
 * @return bool
 */
function checkFile(): bool
{
    if ($_FILES['url']['tmp_name'] == '') {
        return false;
    }

    if (in_array(mime_content_type($_FILES['url']['tmp_name']), ['image/jpeg', 'image/png', 'image/jpg'])) {

        return true;
    }

    return false;
}


/**
 * @return bool|mixed
 */
function saveFile() : bool
{
    if (isset($_FILES['url'])) {
        $file_name = "lot_" . time();
        $file_path = __DIR__ . '/uploads/';
        move_uploaded_file($_FILES['url']['tmp_name'], $file_path . $file_name);

        return true;
    }

    return false;
}

/**
 * @return bool
 */

function checkCost() : bool
{
    if ($_POST['cost'] == 0 || $_POST['cost'] < 0 ) {
        return false;
    }
    return true;
}

/**
 * @return bool
 */
function checkStepRate() : bool
{
    $isInt = filter_var($_POST['step_cost'],FILTER_VALIDATE_INT);

    if ( $isInt === false) {
        return false;
    }

    if ($isInt == 0 || $isInt < 0 ) {
        return false;
    }

    return true;
}

/**
 * @return bool
 */
function checkLostDate() : bool
{
    $year = substr($_POST['lot-date'],0,4);
    $month = substr($_POST['lot-date'],5,2);
    $day = substr($_POST['lot-date'],8,2);
    $checkFormatDate = checkdate($month,$day,$year);

    if ($checkFormatDate === false) {
        return false;
    }

    $today = date("Y-m-d");
    $y = substr($today,0,4);
    $m = substr($today,5,2);
    $d = substr($today,8,2);

    if ((int)$year < (int)$y) {
        return false;
    }

    if ((int)$year == (int)$y && (int)$month < (int)$m) {
        return false;
    }

    if ((int)$year == (int)$y && (int)$month == (int)$m && (int)$day < (int)$d) {
        return false;
    }

    return true;
}

function validateFormatFile() {

    if ($_FILES['url']['tmp_name'] == '') {
        return 'Загрузите изображение';
    }

    $check = checkFile();

    if ($check == false) {
        return "Формат файла должен быть jpeg, jpg, png";
    }

    return 'the good';
}

function validateCost() {

    if ($_POST['cost'] == '' ) {
        return 'Поле не заполнено';
    }

    if (!checkCost()) {
        return  "Содержимое поля «начальная цена» должно быть числом больше нуля.";
    }

    return 'the good';
}

function validateStepRate() {

    if ($_POST['step_cost'] == '' ) {
        return 'Поле не заполнено';
    }

    if (!checkStepRate()) {
        return "Содержимое поля «шаг ставки» должно быть целым числом больше нуля.";
    }

    return 'the good';
}

function validateLostData() {

    if ($_POST['lot-date'] == '' ) {
        return 'Поле не заполнено';
    }

    $length = strlen($_POST['lot-date']);
    if ($length < 10) {
        return  "Содержимое поля «дата завершения» Форматы даты должен быть ГГГГ-ММ-ДД и больше текущей даты хотябы на один день";
    }

    if (!checkLostDate()) {
        return  "Содержимое поля «дата завершения» Форматы даты должен быть ГГГГ-ММ-ДД и больше текущей даты хотябы на один день";
    }

    return 'the good';
}

function validateFileName() {

    if ($_POST['name'] == '' ) {
        return 'Введите наименование лота';
    }

    $lenght = strlen($_POST['name']);

    if ($lenght < 10 || $lenght > 100) {
        return 'Длина поля должна быть не меньше от 10 до 100 символов';
    }

    return 'the good';
}

function validateDescription() {

    if ($_POST['description'] == '' ) {
        return 'Поле не заполнено';
    }

    $lenght = strlen($_POST['description']);

    if ($lenght < 10 || $lenght > 2000) {
        return 'Длина поля должна быть не меньше от 10 до 2000 символов';
    }

    return 'the good';
}

function validateCategories() {

    if ($_POST['categories'] == 'Выберите категорию') {
        return 'Выберите категорию';
    }

    return 'the good';
}