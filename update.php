<?php

$dbName = "utilisateurs";
    $host = "localhost";
    $dbusername = "root";
    $dbpwd = "";

    try {
        $conn = new PDO("mysql:host=$host;dbname=$dbName;charset=utf8", $dbusername, $dbpwd);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if (!isset($_GET['id']) || !isset($_POST['submit-update'])) {
            header("Location: index.php");
        } else {

            $id = $_GET['id'];

            $nom = $_POST['updateLast'];
            $prenom = $_POST['updateFirst'];
            $sexe = $_POST['updateGender'];
            $email = $_POST['updateEmail'];
            $departement = $_POST['updateDepartment'];
            $dateBday = $_POST['updateBday'];
            $idMatiere = $_POST['updateMatiere'];

            $sql="UPDATE etudiants
            SET nom = :nom,
            prenom = :prenom,
            sexe = :sexe,
            email = :email,
            departement = :departement,
            date_naissance = :date_naissance,
            id_matieres = :id_matieres
            WHERE etudiants_id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':nom', $nom, PDO::PARAM_STR);
            $stmt->bindParam(':prenom', $prenom, PDO::PARAM_STR);
            $stmt->bindParam(':sexe', $sexe, PDO::PARAM_INT);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':departement', $departement, PDO::PARAM_STR);
            $stmt->bindParam(':date_naissance', $dateBday, PDO::PARAM_STR);
            $stmt->bindParam(':id_matieres', $idMatiere, PDO::PARAM_INT);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            header("Location: index.php?delete=success");
        }

    } catch (PDOException $e) {
        die("Erreur : " . $e->getMessage());
    }

    ?> 