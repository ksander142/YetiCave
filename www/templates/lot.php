
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
                    <div class="lot-item__state">
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
                                Мин. ставка <span><?= getCost(12000);?></span>
                            </div>
                        </div>
                        <?php endforeach; ?>
                        <form class="lot-item__form" action="https://echo.htmlacademy.ru" method="post" autocomplete="off">
                            <p class="lot-item__form-item form__item form__item--invalid">
                                <label for="cost">Ваша ставка</label>
                                <input id="cost" type="text" name="cost" placeholder="12 000">
                                <span class="form__error">Введите наименование лота</span>
                            </p>
                            <button type="submit" class="button">Сделать ставку</button>
                        </form>
                    </div>
                    <div class="history">
                        <h3>История ставок (<span>10</span>)</h3>
                        <table class="history__list">
                            <tr class="history__item">
                                <td class="history__name">Иван</td>
                                <td class="history__price">10 999 р</td>
                                <td class="history__time">5 минут назад</td>
                            </tr>
                            <tr class="history__item">
                                <td class="history__name">Константин</td>
                                <td class="history__price">10 999 р</td>
                                <td class="history__time">20 минут назад</td>
                            </tr>
                            <tr class="history__item">
                                <td class="history__name">Евгений</td>
                                <td class="history__price">10 999 р</td>
                                <td class="history__time">Час назад</td>
                            </tr>
                            <tr class="history__item">
                                <td class="history__name">Игорь</td>
                                <td class="history__price">10 999 р</td>
                                <td class="history__time">19.03.17 в 08:21</td>
                            </tr>
                            <tr class="history__item">
                                <td class="history__name">Енакентий</td>
                                <td class="history__price">10 999 р</td>
                                <td class="history__time">19.03.17 в 13:20</td>
                            </tr>
                            <tr class="history__item">
                                <td class="history__name">Семён</td>
                                <td class="history__price">10 999 р</td>
                                <td class="history__time">19.03.17 в 12:20</td>
                            </tr>
                            <tr class="history__item">
                                <td class="history__name">Илья</td>
                                <td class="history__price">10 999 р</td>
                                <td class="history__time">19.03.17 в 10:20</td>
                            </tr>
                            <tr class="history__item">
                                <td class="history__name">Енакентий</td>
                                <td class="history__price">10 999 р</td>
                                <td class="history__time">19.03.17 в 13:20</td>
                            </tr>
                            <tr class="history__item">
                                <td class="history__name">Семён</td>
                                <td class="history__price">10 999 р</td>
                                <td class="history__time">19.03.17 в 12:20</td>
                            </tr>
                            <tr class="history__item">
                                <td class="history__name">Илья</td>
                                <td class="history__price">10 999 р</td>
                                <td class="history__time">19.03.17 в 10:20</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </section>