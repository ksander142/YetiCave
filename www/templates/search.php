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
    <div class="container">
        <section class="lots">
            <h2>Результаты поиска по запросу «<span><?=$search;?></span>»</h2>
            <?php if (!empty($lots)): ?>
            <ul class="lots__list">
                <?php foreach ($lots as $value): ?>
                    <li class="lots__item lot">
                        <div class="lot__image">
                            <img src="<?= $value["url"];?>" width="350" height="260" alt="">
                        </div>
                        <div class="lot__info">
                            <span class="lot__category"><?= $value["categories"];?></span>
                            <h3 class="lot__title"><a class="text-link" href="/lot.php?id=<?= $value["lID"];?>"><?= $value["lName"];?></a></h3>
                            <div class="lot__state">
                                <div class="lot__rate">
                                    <span class="lot__amount">Стартовая цена</span>
                                    <span class="lot__cost"><?= getCost($value["cost"]);?></span>
                                </div>
                                <?  $lostTime = getTime($value["date"]);
                                $zeroTime = $lostTime[0] < 1 ? 'timer--finishing' : '';?>

                                <div class="lot__timer timer <?= $zeroTime ;?>">
                                    <?= $lostTime[0] . ":" . $lostTime[1];?>
                                </div>
                            </div>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
            <?php else :?>
                <h3 class="lot__title">Ничего не найдено по вашему запросу</h3>
            <?php endif;?>
        </section>

        <?=include_template("pagination_search.php",
            [
                'pages_count' => $pages_count,
                'current_page' => $current_page,
                'pages' => $pages,
                'search' => $search
            ]
        );?>
    </div>