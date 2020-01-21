<?php
require_once "helpers.php" ;
require_once "vendor/autoload.php";

$link = getConnection();
$res = mysqli_query($link,"select lots.id,lots.name,lots.date, lots.url, r.raise_cost,r.add_date as rate_date, c.name as categories,u.contacts from lots join categories c on lots.categories_id = c.id join rate r on lots.id = r.lots_id join users u on lots.user_id = u.id where r.user_id = '{$is_auth}'");
$info_bets = mysqli_fetch_all($res, MYSQLI_ASSOC);
$result = mysqli_query($link,"select lots.id,u.id as usID,u.name as usName,rate.raise_cost from lots join rate on lots.id = rate.lots_id join users u on rate.user_id = u.id where u.id = rate.user_id");
$info_all_bets = mysqli_fetch_all($result, MYSQLI_ASSOC);
$last = null;
$lastArrRate = null;
$win = [];

foreach ($info_all_bets as $arr) {

    if(!is_null($last)){

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

$emailSQL = select('email', 'users', "where id = {$win['usID']}");
$content = include_template("email.php",
    [
        'info_bets' => $info_bets,
        'win' => $win,
        'is_auth' => $is_auth
    ]);

if ($is_auth == $win['usID']) {

//создал транспорт, мыло откуда будет отправляться письмо
$transport = (new Swift_SmtpTransport('phpdemo.ru', 25))
    ->setUsername('keks@phpdemo.ru')
    ->setPassword('htmlacademy')
;

//майлер использует транспорт который создали
$mailer = new Swift_Mailer($transport);

//кому отправляем
$to = $emailSQL[0]['email'];

// от кого
$from = 'keks@phpdemo.ru';

//письмо для победителя
$messageToWinnner = (new Swift_Message("Ваша ставка победила!"))
    ->setFrom(['keks@phpdemo.ru' => 'keks@phpdemo.ru'] )
    ->setTo($to)
    ->setBody($content, 'text/html')
;

// отправляем письмо клиенту
$mailer->send($messageToWinnner);
}
