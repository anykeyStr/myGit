<h1 class="h1 mb-3 fw-normal">Регистрация</h1>
<h3>Введите электронную почту и пароль и нажмите кнопку "Зарегистрироваться", чтобы создать аккаунт</h3>

<form method="get" action="registration.php">
    <div class="form-floating">
        <input type="email" name="new_email" class="form-control" id="floatingInput" placeholder="name@example.com" required>
        <label for="floatingInput">Email address</label>
    </div>
    <br>
    <div class="form-floating">
        <input type="password" name="new_password" class="form-control" id="floatingPassword" placeholder="Password" required>
        <label for="floatingPassword">Password</label>
    </div>
    <br>
    <button class="w-50 btn btn-lg btn-primary" type="submit">Зарегистрироваться</button>

    <br><br>

    <a href="login">Вернуться</a>

</form>
