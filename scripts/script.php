<?php
  $server = "localhost";
  $userDb = "root";
  $passwordDb = "";
  $nameDb = "cadastro";
  $nameTable = "usuarios";
  
  init($server, $userDb, $passwordDb, $nameDb, $nameTable);

  function init ($server, $user, $password, $nameDb, $nameTable) {
    try {
      $connection = connectDatabase($server, $user, $password, $nameDb);
      createTable($connection, $nameTable);
      if ($_POST["password"] === $_POST["repassword"]) {
        insertNewDataInTable($connection, $_POST["name"], $_POST["email"], $_POST["password"], $nameTable);
        getAllDataTable($connection, $nameTable);
      } else {
        throw new Exception ("Password is not equal.");
      }
    } catch (Exception $e) {
      print("Error: ".$e->getMessage());
    } finally {
      $connection->close();
    }
  }

  function connectDatabase ($server, $user, $password, $nameDb) {
    if ($connection = connectionHost($server, $user, $password)) {
      return createDatabaseAndConnection($connection, $nameDb);
    } else {
      throw new Exception("Database not connected.");
    }
  }

  function connectionHost ($server, $user, $password) {
    if ($connection = new mysqli($server, $user, $password)) {
      return $connection;
    } else {
      throw new Exception ("Database not connected.");
    }
  }

  function createDatabaseAndConnection ($connection, $nameDb) {
    $sql = "CREATE DATABASE IF NOT EXISTS $nameDb";
    if ($connection-> query($sql) === TRUE) {
      $sql = "USE $nameDb";
      $connection->query($sql);
      return $connection;
    } else {
      throw new Exception ("Database not created.");
    }
  }

  function createTable ($connection, $nameTable) {
    $sql = "CREATE TABLE IF NOT EXISTS $nameTable (
      id INT UNSIGNED NOT NULL AUTO_INCREMENT,
      nome VARCHAR (30) NOT NULL,
      email VARCHAR (30) NOT NULL,
      senha VARCHAR (40) NOT NULL,
      primary key (id)
      )";
    if ($connection-> query($sql) === TRUE) {
      return true;
    } else {
      throw new Exception ("Table not created.");
    }
  }

  function insertNewDataInTable($connection, $registerName, $registerEmail, $registerPassword, $nameTable) {
    $sql = "INSERT INTO $nameTable (nome, email, senha)
      VALUES ('$registerName', '$registerEmail', '$registerPassword')";
    if ($connection-> query($sql) === TRUE) {
      return;
    } else {
      throw new Exception ("Data not insert in table.");
    }
  }

  function getAllDataTable ($connection, $nameTable) {
    $sql = "SELECT * FROM $nameTable";
    $resultado = $connection->query($sql);
    if ($resultado) {
      echo "
        <style>
          .container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
          }
          h1 {
            color: #0074d9;
          }
          table {
            color: #0074d9;
            border-collapse: collapse;
          }
          th, td {
            text-align: center;
            border: 1px solid #0074d9;
            padding: 5px 20px;
          }
          button {
            height: 30px;
            width: 20%;
            margin-top: 2%;
            border-radius: 10px;
            border: none;
            background-color: #0074d9;
            color: white;
          }
        </style>";
      echo "<div class='container'>";
      echo "<h1>Usuários cadastrados</h1>";
      echo "<table>";
      echo "<tr><th>#</th><th>NOME</th><th>E-MAIL</th></tr>";
      while ($row =  mysqli_fetch_array( $resultado) ) {
        echo "<tr><th>".$row['id']."</th><td>".$row['nome']."</td><td>".$row['email']."</td></tr>";
      }
      echo "</table>";
      echo "<button onclick='javascript:history.back()'>Página inicial</button>";
      echo "</div>";
    } else {
      throw new Exception ("Not Data in Table.");
    }
  }
?>