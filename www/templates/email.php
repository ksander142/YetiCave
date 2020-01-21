
<?php foreach ($info_bets as $value): ?>
    <? $lostTime = getTime($value["date"]);?>
    <?php if( $lostTime[0] < 1 && $lostTime[1] < 1 ) :?>
<h1>Поздравляем с победой</h1>
<p>Здравствуйте, <?=$win['usName'];?></p>
<p>Ваша ставка для лота <a href="/lot.php?id=<?=$value["id"];?>"><?=$value["name"];?></a> победила.</p>
<p>Перейдите по ссылке <a href="/my_bets.php">Мои ставки</a>,
    чтобы связаться с автором объявления</p>
<small>Интернет Аукцион "YetiCave"</small>
    <?php endif;?>
<?php endforeach; ?>
