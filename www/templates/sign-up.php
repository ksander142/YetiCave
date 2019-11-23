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
    <form class="form container <?=$classForm?>" action="sign-up.php" method="post" autocomplete="off"> <!-- form
    --invalid -->
        <h2>Регистрация нового аккаунта</h2>
        <div class="form__item <?=$classDivEmail?>"> <!-- form__item--invalid -->
            <label for="email">E-mail <sup>*</sup></label>
            <input id="email" type="text" name="email" placeholder="Введите e-mail" value="<?=getPostVal('email');?>">
            <span class="form__error"><?=$errors['email'] ?? "";?></span>
        </div>
        <div class="form__item <?=$classDivPassword?>">
            <label for="password">Пароль <sup>*</sup></label>
            <input id="password" type="password" name="password" placeholder="Введите пароль" value="<?=getPostVal('password');?>">
            <span class="form__error"><?=$errors['password'] ?? "";?></span>
        </div>
        <div class="form__item <?=$classDivName?>">
            <label for="name">Имя <sup>*</sup></label>
            <input id="name" type="text" name="name" placeholder="Введите имя" value="<?=getPostVal('name');?>">
            <span class="form__error"><?=$errors['name'] ?? "";?></span>
        </div>
        <div class="form__item <?=$classDivContacts?>" >
            <label for="message">Контактные данные <sup>*</sup></label>
            <textarea id="message" name="message" placeholder="Напишите как с вами связаться"><?=getPostVal('message');?></textarea>
            <span class="form__error"><?=$errors['message'] ?? "";?></span>
        </div>
        <span class="form__error form__error--bottom"><?=$textForm;?></span>
        <button type="submit" class="button">Зарегистрироваться</button>
        <a class="text-link" href="#">Уже есть аккаунт</a>
    </form>