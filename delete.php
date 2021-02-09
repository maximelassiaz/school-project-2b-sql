<?php

$dbName = "utilisateurs";
    $host = "localhost";
    $dbusername = "root";
    $dbpwd = "";

    try {
        $conn = new PDO("mysql:host=$host;dbname=$dbName;charset=utf8", $dbusername, $dbpwd);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if (!isset($_GET['id'])) {
            header("Location: index.php");
        } else {
            $id = $_GET['id'];
            $sql="DELETE FROM etudiants
            WHERE etudiants_id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->execute(array(
                ':id' => (int)$id
            ));
            header("Location: index.php?delete=success");
        }

    } catch (PDOException $e) {
        die("Erreur : " . $e->getMessage());
    }

    ?> 