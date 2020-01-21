<section class="rates container">
    <h2>Мои ставки</h2>
    <table class="rates__list">
        <?php foreach ($info_bets as $value): ?>
            <? $lostTime = getTime($value["date"]);?>
            <?php if( $lostTime[0] < 1 && $lostTime[1] < 1 ) :?>
                <?php if( $win['usID'] == $is_auth ) :?>
                    <tr class="rates__item rates__item--win">
                <?php else:?>
                    <tr class="rates__item rates__item--end">
                <?php endif;?>
            <?php else:?>
                <tr class="rates__item ">
            <?php endif;?>
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
            <?php if( $lostTime[0] < 1 && $lostTime[1] > 1) :?>
                <td class="rates__timer timer--finishing">
                    <div class="timer"><?=$lostTime[0] . ":" . $lostTime[1] ;?></div>
                </td>
            <?php elseif ( $lostTime[0] < 1 && $lostTime[1] < 1 ):?>
                <?php if( $win['usID'] == $is_auth ) :?>
                    <td class="rates__timer">
                        <div class="timer timer--win"><?= "Ставка Выиграла" ;?></div>
                    </td>
                <?php else:?>
                    <td class="rates__timer">
                        <div class="timer timer--end"><?="Торги Окончены" ;?></div>
                    </td>
                <?php endif;?>
            <?php else:?>
                <td class="rates__timer">
                    <div class="timer"><?=$lostTime[0] . ":" . $lostTime[1] ;?></div>
                </td>
            <?php endif;?>
            <td class="rates__price">
                <?=getCost($value["raise_cost"]);?>
            </td>
            <td class="rates__time">
                <?=$value["rate_date"];?>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</section>
