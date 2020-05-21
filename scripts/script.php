<?php
  $server = "localhost";
  $userDb = "root";
  $passwordDb = "";
  $nameDb = "cadastro";
  
  try {
    // adicionar as funções para excução
  } catch (Exception $e) {
    // tratamento de exceções
  }
  // funções
  function connectDb ($server, $user, $password, $nameDb) {
    $connection = new mysqli($server, $user, $password, $nameDb);
    if ($connection) {
      return $connection
    } else {
      return throw new Exception("Database not connected");
    }
  }
  
  function getAllDataTable ($nameTable) {
    $sql = "SELECT * FROM $nameTable";
    $resultado = $conn->query($sql);
    if ($resultado)
      while ($row =  mysqli_fetch_array( $resultado) ) {
        print $row['nome']." -- ".$row['email']." -- ".$row['senha'];
      }
    else
      echo "Erro ao executar: " . $conn->error;

    $conn->close();
  }

  function inserNewData ($nameTable, $name, $email, $password) {
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

  function createTable ($nameTable) {
    $sql = "CREATE TABLE $nameTable (
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

  function createDb ($nameDb) {
    $sql = "CREATE DATABASE $nameDb";
    if ($conn-> query($sql) === TRUE) {
      echo "Database created successfully";
    } else {
      echo "Error creating database: " . $conn->error;
    }
    $conn->close();
  }

?>