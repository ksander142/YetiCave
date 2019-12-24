<section class="rates container">
    <h2>Мои ставки</h2>
    <table class="rates__list">
        <tr class="rates__item">
            <td class="rates__info">
                <div class="rates__img">
                    <img src="../img/rate1.jpg" width="54" height="40" alt="Сноуборд">
                </div>
                <h3 class="rates__title"><a href="lot.html">2014 Rossignol District Snowboard</a></h3>
            </td>
            <td class="rates__category">
                Доски и лыжи
            </td>
            <td class="rates__timer">
                <div class="timer timer--finishing">07:13:34</div>
            </td>
            <td class="rates__price">
                10 999 р
            </td>
            <td class="rates__time">
                5 минут назад
            </td>
        </tr>
        <tr class="rates__item">
            <td class="rates__info">
                <div class="rates__img">
                    <img src="../img/rate2.jpg" width="54" height="40" alt="Сноуборд">
                </div>
                <h3 class="rates__title"><a href="lot.html">DC Ply Mens 2016/2017 Snowboard</a></h3>
            </td>
            <td class="rates__category">
                Доски и лыжи
            </td>
            <td class="rates__timer">
                <div class="timer timer--finishing">07:13:34</div>
            </td>
            <td class="rates__price">
                10 999 р
            </td>
            <td class="rates__time">
                20 минут назад
            </td>
        </tr>

        <tr class="rates__item rates__item--win">
            <td class="rates__info">
                <div class="rates__img">
                    <img src="../img/rate3.jpg" width="54" height="40" alt="Крепления">
                </div>
                <div>
                    <h3 class="rates__title"><a href="lot.html">Крепления Union Contact Pro 2015 года размер L/XL</a></h3>
                    <p>Телефон +7 900 667-84-48, Скайп: Vlas92. Звонить с 14 до 20</p>
                </div>
            </td>
            <td class="rates__category">
                Крепления
            </td>
            <td class="rates__timer">
                <div class="timer timer--win">Ставка выиграла</div>
            </td>
            <td class="rates__price">
                10 999 р
            </td>
            <td class="rates__time">
                Час назад
            </td>
        </tr>
        <?php foreach ($info_bets as $value): ?>
        <? $lostTime = getTime($value["date"]);?>
            <?= $class= '' ;?>
            <?php if( $lostTime[0] < 1 && $lostTime[1] < 1 ) :?>
                <?php if( $win['usID'] == $is_auth ) :?>
                    <?= $class = "rates__item--win"?>
                <?php else:?>
                    <?= $class = "rates__item--end"?>
                <?php endif;?>
            <?php endif;?>
            <tr class="rates__item <?= $class ;?> ">
            <td class="rates__info">
                <div class="rates__img">
                    <img src="<?=$value["url"];?>" width="54" height="40" alt="<?=$value["categories"];?>">
                </div>
                <div>
                    <h3 class="rates__title"><a href="/lot.php?id=<?=$value["id"];?>"><?=$value["name"];?></a></h3>
                    <?php if( $lostTime[0] < 1 && $lostTime[1] < 1 ) :?>
                        <?php if( $win['usID'] == $is_auth ) :?>
                            <p><?=$win["contacts"];?></p>
                        <?php else:?>
                            <p>Контакты видны только для победителя Ставки</p>
                        <?php endif;?>
                    <?php endif;?>
                </div>
            </td>
            <td class="rates__category">
                <?=$value["categories"];?>
            </td>
            <?$zeroTime = ''; ?>
            <?$text = ''; ?>
            <?php if( $lostTime[0] > 1 ) :?>
                <?$zeroTime = ''; ?>
                <?= $text = $lostTime[0] . ":" . $lostTime[1];?>
            <?php endif;?>
            <?php if( $lostTime[0] < 1 ) :?>
                <?$zeroTime = 'timer--finishing'; ?>
                <?= $text = $lostTime[0] . ":" . $lostTime[1];?>
            <?php endif;?>
            <?php if( $lostTime[0] < 1 && $lostTime[1] < 1 ) :?>
                <?php if( $win['usID'] == $is_auth ) :?>
                    <?$zeroTime = 'timer--win'; ?>
                    <?= $text = "Ставка Выиграла";?>
                <?php else:?>
                    <?$zeroTime = 'timer--end'; ?>
                    <?= $text = "Торги Окончены";?>
                <?php endif;?>
            <?php endif;?>
            <td class="rates__timer">
                <div class="timer <?= $zeroTime ;?>"><?= $text ;?></div>
            </td>
            <td class="rates__price">
                <?=getCost($value["raise_cost"]);?>
            </td>
            <td class="rates__time">
                <?=$value["rate_date"];?>
            </td>
        </tr>
        <?php endforeach; ?>
        <tr class="rates__item rates__item--end">
            <td class="rates__info">
                <div class="rates__img">
                    <img src="../img/rate5.jpg" width="54" height="40" alt="Куртка">
                </div>
                <h3 class="rates__title"><a href="lot.html">Куртка для сноуборда DC Mutiny Charocal</a></h3>
            </td>
            <td class="rates__category">
                Одежда
            </td>
            <td class="rates__timer">
                <div class="timer timer--end">Торги окончены</div>
            </td>
            <td class="rates__price">
                10 999 р
            </td>
            <td class="rates__time">
                Вчера, в 21:30
            </td>
        </tr>
        <tr class="rates__item rates__item--end">
            <td class="rates__info">
                <div class="rates__img">
                    <img src="../img/rate6.jpg" width="54" height="40" alt="Маска">
                </div>
                <h3 class="rates__title"><a href="lot.html">Маска Oakley Canopy</a></h3>
            </td>
            <td class="rates__category">
                Разное
            </td>
            <td class="rates__timer">
                <div class="timer timer--end">Торги окончены</div>
            </td>
            <td class="rates__price">
                10 999 р
            </td>
            <td class="rates__time">
                19.03.17 в 08:21
            </td>
        </tr>
        <tr class="rates__item rates__item--end">
            <td class="rates__info">
                <div class="rates__img">
                    <img src="../img/rate7.jpg" width="54" height="40" alt="Сноуборд">
                </div>
                <h3 class="rates__title"><a href="lot.html">DC Ply Mens 2016/2017 Snowboard</a></h3>
            </td>
            <td class="rates__category">
                Доски и лыжи
            </td>
            <td class="rates__timer">
                <div class="timer timer--end">Торги окончены</div>
            </td>
            <td class="rates__price">
                10 999 р
            </td>
            <td class="rates__time">
                19.03.17 в 08:21
            </td>
        </tr>
    </table>
</section>