<form method="post" action="login.php">

    <h1 class="h3 mb-3 fw-normal">Авторизация</h1>

    <div class="form-floating">
        <input type="email" name="email" class="form-control" id="floatingInput" placeholder="name@example.com" required>
        <label for="floatingInput">Адрес электронной почты</label>
    </div>
    <br>
    <div class="form-floating">
        <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Пароль" required>
        <label for="floatingPassword">Пароль</label>
    </div>
    <br>
    <button class="w-50 btn btn-lg btn-primary" type="submit">Войти</button>
    <br><br>
    <h5 class="card-title">
        <a href="/registration">Регистрация</a>
        <a href="/reset_password">Забыли пароль?</a>
    </h5>
</form>