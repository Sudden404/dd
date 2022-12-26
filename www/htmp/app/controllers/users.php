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
