<?php
    require "db.php";

    $data = $_POST;

    if(isset($data['do_signup'])){
        //We are registering here
        $errors = array();

        if(trim($data['login']) == ''){
            $errors[] = 'Введите логин';
        }

        if(trim($data['email']) == ''){
            $errors[] = 'Введите email!';
        }

        if($data['password'] == ''){
            $errors[] = 'Введите пароль!';
        }

        if($data['password_2'] != $data['password']){
            $errors[] = 'Пароль не совпадает!';
        }
        if(R::count('users', 'login = ?', array($data['login'])) > 0){
            $errors[] = 'Пользователь с таким логином существует';
        }

        if(R::count('users', 'email = ?', array($data['email'])) > 0){
            $errors[] = 'Ползовательн с таким email существует';
        }

        if(empty($errors)){
            // all fine registering the user
            $user = R::dispense('users');
            $user->login = $data['login'];
            $user->email = $data['email'];
            $user->password = password_hash($data['password'], PASSWORD_DEFAULT);
            R::store($user);
            echo '<div style="color: greenyellow;">Вы зарегались</div>';
        } else {
            echo '<div style="color:red;">'.array_shift($errors).'</div><hr>';
        }
    }
?>

<form action="/signup.php" method="POST">
    <p>
        <p>Ваш логин</p>
        <input type="text" name="login" value="<?php echo @$data['login'] ?>">
    </p>
    <p>
        <p>Ваш емайл</p>
        <input type="email" name="email" value="<?php echo @$data['email'] ?>">
    </p>
    <p>
        <p>Ваш пароль</p>
        <input type="password" name="password" value="<?php echo @$data['password'] ?>">
    </p>
    <p>
        <p>Повторите пароль</p>
        <input type="password" name="password_2" value="<?php echo @$data['password_2'] ?>">
    </p>
    <p>
        <button type="submit" name="do_signup">Зарегаться</button>
    </p>
</form>