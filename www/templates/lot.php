
        <nav class="nav">
            <ul class="nav__list container">
                <li class="nav__item">
                    <a href="all-lots.html">Доски и лыжи</a>
                </li>
                <li class="nav__item">
                    <a href="all-lots.html">Крепления</a>
                </li>
                <li class="nav__item">
                    <a href="all-lots.html">Ботинки</a>
                </li>
                <li class="nav__item">
                    <a href="all-lots.html">Одежда</a>
                </li>
                <li class="nav__item">
                    <a href="all-lots.html">Инструменты</a>
                </li>
                <li class="nav__item">
                    <a href="all-lots.html">Разное</a>
                </li>
            </ul>
        </nav>
        <section class="lot-item container">
            <?php foreach ($lot as $value): ?>
            <h2><?= $value["lName"];?></h2>
            <div class="lot-item__content">
                <div class="lot-item__left">
                    <div class="lot-item__image">
                        <img src="<?= $value["url"];?>" width="730" height="548" alt="Сноуборд">
                    </div>
                    <p class="lot-item__category">Категория: <span><?= $value["categories"];?></span></p>
                    <p class="lot-item__description"><?= $value["description"];?></p>
                </div>
                <div class="lot-item__right">
                    <?php endforeach; ?>

                    <?php if ($is_auth > 0): ?>
                    <div class="lot-item__state">
                        <?php foreach ($lot as $value): ?>
                        <?  $lostTime = getTime($value["date"]);
                        $zeroTime = $lostTime[0] < 1 ? 'timer--finishing' : ''; ?>

                        <div class="lot-item__timer timer <?= $zeroTime ;?>">
                            <?= $lostTime[0] . ":" . $lostTime[1];?>
                        </div>
                        <div class="lot-item__cost-state">
                            <div class="lot-item__rate">
                                <span class="lot-item__amount">Текущая цена</span>
                                <span class="lot-item__cost"><?= getCost($value["cost"]);?> </span>
                            </div>
                            <div class="lot-item__min-cost">
                                Мин. ставка <span><?= getCost($lot_cost);?></span>
                            </div>
                        </div>

                        <form class="lot-item__form" action="/lot.php?id=<?= $value["lID"];?>" method="post" autocomplete="off">
                            <p class="lot-item__form-item form__item <?= $classDivError;?>">
                                <label for="cost">Ваша ставка</label>
                                <input id="cost" type="text" name="cost" placeholder="<?=getCost($lot_cost);?> ">
                                <span class="form__error"><?=$errors['cost'] ?? "";?></span>
                            </p>
                            <button type="submit" class="button">Сделать ставку</button>
                        </form>
                    </div>

                        <?php endforeach; ?>
                    <?php endif;?>
                    <div class="history">
                        <h3>История ставок (<span><?=count($rate);?></span>)</h3>
                        <table class="history__list">
                            <?php foreach ($rate as $value): ?>
                            <tr class="history__item">
                                <td class="history__name"><?=$value["users"];?></td>
                                <td class="history__price"><?=getCost($value["raise_cost"]);?></td>
                                <td class="history__time"><?=$value["add_date"];?></td>
                            </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                </div>
            </div>
        </section>