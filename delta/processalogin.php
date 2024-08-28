<?php

session_start(); //inicia a sessão

require_once('./conexao.php'); 

$nome = $_POST['email'];
$senha = $_POST['senha'];

$sql = "SELECT * FROM ADMINISTRADOR WHERE ADM_EMAIL = :email AND ADM_SENHA = :senha AND ADM_ATIVO = 1"; // : - representa um placerolder no banco de dados


$query = $pdo->prepare($sql);

$query->bindParam(':email',$nome, PDO::PARAM_STR); //  //associa o valor da variável PHP '$nome' ao *placeholder* ':nome' na consulta SQL. Também especifica que o tipo do parâmetro é uma string ('PDO::PARAM_STR'). O operador :: é um operador de resolução de escopo.

$query->bindParam(':senha',$senha, PDO::PARAM_STR);// query é o comando SQL "select" ja pré definido

$query -> execute();

if($query->rowCount()> 0){
    $_SESSION['admin_logado'] = true; //session é uma super global
    header('Location: painel_admin.php');
}else{
    header('Location: login.php?erro');
}
?>
