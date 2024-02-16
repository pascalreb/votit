<?php

function addUser(PDO $pdo, string $email, string $password, string $nickname) {
    $sql = "INSERT INTO `user` (`email`, `password`, `nickname`) VALUES (:email, :password, :nickname);";
    $query = $pdo->prepare($sql);

    $password = password_hash($password, PASSWORD_DEFAULT);

    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->bindParam(':password', $password, PDO::PARAM_STR);
    $query->bindParam(':nickname', $nickname, PDO::PARAM_STR);
    
    return $query->execute();
}

function verifyUserLoginAndPassword(PDO $pdo, string $email, string $password):array|bool
{
    $query = $pdo->prepare('SELECT * FROM user WHERE email = :email');
    $query->bindValue(':email', $email, PDO::PARAM_STR);
    $query->execute();
    $user = $query->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        return $user;
    } else {
        return false;
    }
}