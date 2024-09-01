<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once '../config/conecta_db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $user = strip_tags(trim($_POST['user']));
    $password = strip_tags(trim($_POST['password']));

    if (empty($user) || empty($password)) {
        echo "<script>alert('Por favor, preencha todos os campos!'); document.location='../index.php';</script>";
    } else {

        $sql = $pdo->prepare("SELECT * FROM login_ad WHERE user = :user");
        $sql->bindParam(":user", $user);
        $sql->execute();
        $result = $sql->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            // Comparar senha em texto simples
            if ($password === $result['password']) {
                session_start();
                $_SESSION['log'] = true;
                $_SESSION['id'] = $result['id'];
                $_SESSION['user'] = $result['user'];
                header('Location: ../../site/');
                exit;
            } else {
                echo "<script>alert('Password fail!'); document.location='../index.php';</script>";
            }
        } else {
            echo "<script>alert('User does not exist!'); document.location='../index.php';</script>";
        }
    }
}
?>
