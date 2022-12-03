![image](https://user-images.githubusercontent.com/90724604/205431314-53d0eab3-59d2-4a4a-92bd-f095b6b5db24.png)

Возможные пользовательские сценарии:
1. Регистрация
	Пользователь наводит курсор в шапке страницы на окно sing in, и через выпадающее окно нажимает на кнопку registration (Либо через кнопку create account в окне входа), его переносит в окно регистрации. Там пользователь должен ввести соответствующие условиям логин и пароль, если пользователь ошибётся в составлении логина и пароля, то ему высветится подсказка по условиям валидации, также логин не стирается при неуспешном заполнении граф, для комфорта пользователя. После регистрации его переносит на главную страницу сайта и аутентифицирует в системе.
2. Вход
	Пользователь переходит в окно входа с помощью кнопки sing in в шапке сайта(или через кнопку sing in в окне регистрации). Он вводит свои логин и пароль(в случае неверного ввода появится надпись "Incorrect email or password"), его аутентифицирует в системе и переносит на главную страницу.
3. Выход 
	Для аунтифицированных пользователей при наведении на их логин(там где для неаунтифицированных надпись sing in), в выпадающем окне появится кнопка выхода, при нажатии на которую пользователь выходит из аккаунта.
4. Смена пароля
	Для аунтифицированных пользователей при наведении на их логин(там где для неаунтифицированных надпись sing in), в выпадающем окне, под кнопкой выхода будет кнопка смены пароля, необходимо ввести дважды новый пароль. Пароль будет изменён, а пользователь перенесён на главный экран.
 
Основные страницы сайта
Главная страница сайта:  
![image](https://user-images.githubusercontent.com/90724604/205431323-5de6983e-9240-4ffc-a6d1-1946a634ba77.png)

Страница регистрации пользователя: 
![image](https://user-images.githubusercontent.com/90724604/205431327-61d8aab9-6729-4711-9b93-16503a496594.png)

Страница авторизации пользователей 
![image](https://user-images.githubusercontent.com/90724604/205431330-08cee637-b28e-4919-87a0-ff86830c9053.png)

Страница смены пароля:
![image](https://user-images.githubusercontent.com/90724604/205431335-c39d8f24-e1a4-458b-a9c0-fc0bfef2e709.png)

 
Приверы запросов на сервер и ответов от них:
Успешная регистрация: 
![image](https://user-images.githubusercontent.com/90724604/205431343-fee728cb-e1f0-44bc-93d5-ae9b434768d5.png)

Ошибка при вводе формы:
![image](https://user-images.githubusercontent.com/90724604/205431344-eff2b0f9-748b-42e4-aae6-73e243f55352.png)

 
Блок схема работы сайта
![image](https://user-images.githubusercontent.com/90724604/205431354-bb7cb5f7-4a65-4b00-abe2-182ae2eb4b8a.png)

Описание БД
В лабораторной работе была использована база данных – mysql. Таблица состоит из 3х столбцов:
1)ID - идентификационный номер пользователя, уникален и выдаётся сервером.
2)Логин - уникальное имя пользователя, введённое им при регистрации.
3)Пароль – набор символов введённый пользователем, необходимый для подтверждения, что пользователь владелец аккаунта. На сервере хранится в хешированном виде с солью.
 
Пример кода для основных сценариев работы
<?php
include("app/database/db.php");

$errMsg = '';
//reg
if(isset($_POST['reg-button'])) {
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $login = trim($_POST['login']);
        $passF = trim($_POST['pass-first']);
        $passS = trim($_POST['pass-second']);

        if($login === '' || $passF === '') {
            $errMsg = "Form can't be blank";
        }elseif (mb_strlen($login,'UTF-8') < 4) {
            $errMsg = "Login must be longer than 3 characters";
        }elseif (mb_strlen($passF,'UTF-8') < 6) {
            $errMsg = "Password must be longer than 5 characters";
        }elseif (!preg_match("#.*^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*$#", $passF)) {
            $errMsg = "Your password must have a lowercase letter, an uppercase letter, a number, and a special character!";
        }elseif($passF !== $passS){
            $errMsg = "Password mismatch";
        }else {
            $existence = seleckOne('users', ['login' => $login]);
            if (!empty($existence['login']) && $existence['login'] === $login) {
                $errMsg = "Login already registered";
            } else {
                $pass = password_hash($passF, PASSWORD_DEFAULT);
                $post = [
                    'login' => $login,
                    'password' => $pass
                ];
                $id = insert('users', $post);
                $user = seleckOne('users',['id' => $id]);

                $_SESSION['id'] = $user['id'];
                $_SESSION['login'] = $user['login'];
                header('location: ' . BASE_URL);
            }
        }
    }else {
        $login = '';
    }
}

//login
else if(isset($_POST['log-button'])) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $login = trim($_POST['login']);
        $pass = trim($_POST['password']);

        if ($login === '' || $pass === '') {
            $errMsg = "Form can't be blank";
        } else {
            $existence = seleckOne('users', ['login' => $login]);
            if ($existence && password_verify($pass, $existence['password'])) {
                $_SESSION['id'] = $existence['id'];
                $_SESSION['login'] = $existence['login'];
                header('location: ' . BASE_URL);
            } else {
                $errMsg = "Incorrect email or password";
            }
        }
    } else {
        $login = '';
    }
}
else{
    $login = '';
}

//change password
if(isset($_POST['pass-button'])) {
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $passF = trim($_POST['new-password1']);
        $passS = trim($_POST['new-password2']);

        if($passF === '') {
            $errMsg = "Form can't be blank";
        }elseif (mb_strlen($passF,'UTF-8') < 6) {
            $errMsg = "Password must be longer than 5 characters";
        }elseif (!preg_match("#.*^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*$#", $passF)) {
            $errMsg = "Your password must have a lowercase letter, an uppercase letter, a number, and a special character!";
        }elseif($passF !== $passS){
            $errMsg = "Password mismatch";
        }else {
            $id = $_SESSION['id'];
            $pass = password_hash($passF, PASSWORD_DEFAULT);
            $post = [
                'password' => $pass
            ];
            update('users', $id, $post);
            header('location: ' . BASE_URL);
        }
    }
}

