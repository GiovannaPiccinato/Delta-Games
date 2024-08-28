<?php

$host = '144.22.157.228'; //Especifica o nome do host onde o banco de dados MySQL está hospedado. O valor "localhost" significa que o banco de dados está no mesmo servidor onde o código PHP está sendo executado. Se o banco de dados estiver em um servidor remoto, você fornece o endereço IP ou o nome de domínio desse servidor).
$db = 'Delta';
$user = 'delta'; // usuário
$pass = 'delta'; // passowrd  (não deixe espaço)
$charset = 'utf8mb4';

// DSN (Data Source Name)
$dsn = "mysql:host=$host; dbname=$db;charset=$charset"; // sintaxe do PDO 

try{ // se tiver erro no comando do banco de dados irá ler o catch
$pdo = new PDO($dsn, $user, $pass);
} catch(PDOException $e){ // A classe PDOException é uma subclasse da classe Exception que é usada para representar exceções específicas relacionadas a erros de banco de dados quando você está trabalhando com o PDO
    echo "Erro ao tentar conectar com o banco de dados <p>" . $e;
}
?>