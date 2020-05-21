<?php
  $servidor = "localhost";
  $usuario = "root";
  $senha = "";
  $nome_bd = "test";

  $conn = new mysqli($servidor, $usuario, $senha, $nome_bd);
  if ($conn) {
    $sql = "SELECT * FROM usuario";
    $resultado = $conn->query($sql);
    if ($resultado)
      while ($row =  mysqli_fetch_array( $resultado) ) {
        print $row['nome']." -- ".$row['email']." -- ".$row['senha'];
      }
    else
      echo "Erro ao executar: " . $conn->error;

    $conn->close();

  } else {
    die("Não conectado".mysql_error());
  }


  // funções
  function inserNewData () {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = " INSERT INTO usuario (nome, email, senha)
      VALUES ('$name', '$email', '$password')";
    
    if ($conn-> query($sql) === TRUE) {
      echo "Dados inseridos com sucesso";
    } else {
      echo "Erro ao inserir os dados: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();
  }

  function createTable () {
    $sql = "CREATE TABLE usuario (
      id INT UNSIGNED NOT NULL AUTO_INCREMENT,
      nome VARCHAR (30) NOT NULL,
      email VARCHAR (30) NOT NULL,
      senha VARCHAR (40) NOT NULL,
      primary key (id)
      )";
    if ($conn-> query($sql) === TRUE) {
      echo "Tabela criada com sucesso ";
    } else {
      echo "Erro ao criar a tabela:".$conn-> error;
    }
    $conn->close();
  }

  function createDb () {
    $sql = "CREATE DATABASE cadastro";
    if ($conn-> query($sql) === TRUE) {
      echo "Database created successfully";
    } else {
      echo "Error creating database: " . $conn->error;
    }
    $conn->close();
  }

?>