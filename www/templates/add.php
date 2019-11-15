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

        <form class="form form--add-lot container <?=$classForm?>" action="add.php" method="post" enctype="multipart/form-data"><!-- form--invalid -->
            <h2>Добавление лота</h2>
            <div class="form__container-two">
                <div class="form__item  <?=$classDivName?>"> <!-- form__item--invalid -->
                    <label for="name">Наименование <sup>*</sup></label>
                    <input id="name" type="text" name="name" placeholder="Введите наименование лота" value="<?=getPostVal('name');?>">
                    <span class="form__error"><?=$errors['lotName'] ?? "";?></span>
                </div>
                <div class="form__item <?=$classDivCat?>">
                    <label for="categories">Категория <sup>*</sup></label>
                    <select id="categories" name="categories" >
                        <option>Выберите категорию</option>
                        <?php foreach ($rows_cat as $value): ?>
                        <option><?=$value['categories'];?></option>
                        <?php endforeach;?>
                    </select>
                    <span class="form__error"><?=$errors['lotCategories'] ?? "";?></span>
                </div>
            </div>
            <div class="form__item form__item--wide  <?=$classDivDesc?>">
                <label for="description">Описание <sup>*</sup></label>
                <textarea id="description" name="description" placeholder="Напишите описание лота"><?=getPostVal('description'); ?></textarea>
                <span class="form__error"><?=$errors['lotDescription'] ?? "";?></span>
            </div>
            <div class="form__item form__item--file">
                <label>Изображение <sup>*</sup></label>
                <div class="form__input-file <?=$classDivFormatFile?>">
                    <input class="visually-hidden" type="file" id="url" name="url" value="<?=getPostVal('url'); ?>">
                    <label for="url">
                        Добавить
                    </label>
                    <span class="form__error"><?=$errors['formatFile'] ?? "";?><br><?=$errors['saveFile'] ?? "";?> </span>
                </div>
            </div>
            <div class="form__container-three">
                <div class="form__item form__item--small <?=$classDivCost?>" >
                    <label for="cost">Начальная цена <sup>*</sup></label>
                    <input id="cost" type="text" name="cost" placeholder="0" value="<?=getPostVal('cost'); ?>">
                    <span class="form__error"><?=$errors['startCost'] ?? "";?></span>
                </div>
                <div class="form__item form__item--small <?=$classDivStepRate?>">
                    <label for="step_cost">Шаг ставки <sup>*</sup></label>
                    <input id="step_cost" type="text" name="step_cost" placeholder="0" value="<?=getPostVal('step_cost'); ?>">
                    <span class="form__error"><?=$errors['stepRate'] ?? "";?></span>
                </div>
                <div class="form__item <?=$classDivLostData?>">
                    <label for="lot-date">Дата окончания торгов <sup>*</sup></label>
                    <input class="form__input-date" id="lot-date" type="text" name="lot-date" placeholder="Введите дату в формате ГГГГ-ММ-ДД" value="<?=getPostVal('lot-date'); ?>">
                    <span class="form__error"><?=$errors['lostData'] ?? "";?></span>
                </div>
            </div>
            <span class="form__error form__error--bottom"><?=$textForm;?></span>
            <button type="submit" class="button">Добавить лот</button>
        </form>