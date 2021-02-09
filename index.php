<?php 
    $title = "Bienvenue";
    require "header.php";
?>

<?php
    $dbName = "utilisateurs";
    $host = "localhost";
    $dbusername = "root";
    $dbpwd = "";

    try {
        $conn = new PDO("mysql:host=$host;dbname=$dbName;charset=utf8", $dbusername, $dbpwd);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    ?> 


<main>
    <div class="accordion p-5" id="accordionQueries">
    <div class="card">
            <div class="card-header" id="headingZero">
                <h2 class="mb-0">
                    <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseZero" aria-expanded="true" aria-controls="collapseZero">
                        Liste de gestion des étudiants
                    </button>
                </h2>
            </div>

            <div id="collapseZero" class="collapse show" aria-labelledby="headingZero" data-parent="#accordionQueries">
                <div class="card-body">
                    <div class="input-group my-2">
                        <input type="search" class="form-control rounded" placeholder="Search" aria-label="Search"
                        aria-describedby="search-addon" />
                        <a class="btn btn-outline-primary" href="" role="button">Chercher par nom</a>
                    </div>
                <?php
                    $sql = "SELECT * FROM etudiants 
                    INNER JOIN matieres ON etudiants.id_matieres = matieres.id
                    ORDER BY etudiants.nom, etudiants.prenom";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute();

                    $data = $stmt->fetchAll();

                ?>

                    <table class="table table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Nom</th>
                                <th scope="col">Prénom</th>
                                <th scope="col">Genre</th>
                                <th scope="col">Date de naissance</th>
                                <th scope="col">Email</th>
                                <th scope="col">Département</th>
                                <th scope="col">Matières principales</th>
                                <th scope="col" colspan="2">Gestion</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                foreach($data as $row) { 
                            ?>
                            <tr>
                                <td scope="row"><?= htmlspecialchars($row['etudiants_id']) ?></td>
                                <td scope="row"><?= htmlspecialchars($row['nom']) ?></td>
                                <td scope="row"><?= htmlspecialchars($row['prenom']) ?></td>
                                <td scope="row">
                                    <?php
                                    if ((int)$row['sexe'] === 0) {
                                        echo "Homme";
                                    } elseif ((int)$row['sexe'] === 1) {
                                        echo "Femme";
                                    } else {
                                        echo "Autres";
                                    }
                                    ?>  
                                </td>
                                <?php 
                                     $datechg = new DateTime($row['date_naissance']);
                                     $dateFormat = date_format($datechg, 'd/m/Y'); 
                                     $dateTimeFormat = date_format($datechg, "Y-m-d")
                                ?>
                                <td scope="row"><?= htmlspecialchars($dateFormat) ?></td>
                                <td scope="row"><?= htmlspecialchars($row['email']) ?></td>
                                <td scope="row"><?= htmlspecialchars($row['departement']) ?></td>
                                <td scope="row"><?= htmlspecialchars($row['nom_matiere']) ?></td>
                                <td scope="row">
                                    <button type="button" class="btn btn-warning btn-primary" data-toggle="modal" data-target="<?= "#updateModal" . htmlspecialchars($row['etudiants_id']) ;?>">
                                        Modifier
                                    </button>

                                    <div class="modal fade" id="<?= "updateModal" . htmlspecialchars($row['etudiants_id']) ;?>" tabindex="-1" role="dialog" aria-labelledby="<?= "updateModalLabel" . htmlspecialchars($row['etudiants_id']) ;?>" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="<?= "updateModalLabel" . htmlspecialchars($row['etudiants_id']) ;?>">Modifier un étudiant</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                            <form method="POST" action="update.php?id=<?= htmlspecialchars($row['etudiants_id']) ;?>">
                                                <div class="form-group">
                                                    <label for="updateLast">Nom : </label>
                                                    <input type="text" class="form-control" id="updateLast" value="<?= htmlspecialchars($row['nom']) ;?>" name="updateLast">
                                                </div>
                                                <div class="form-group">
                                                    <label for="updateFirst">Prénom : </label>
                                                    <input type="text" class="form-control" id="updateFirst" value="<?= htmlspecialchars($row['prenom']) ;?>" name="updateFirst">
                                                </div>
                                                <div class="form-group">
                                                    <label for="updateGender">Genre :</label>
                                                    <select class="form-control" id="updateGender" name="updateGender">
                                                        <option value="<?= htmlspecialchars($row['sexe']) ?>">
                                                        <?php
                                                            if ((int)$row['sexe'] === 0) {
                                                                echo "Homme";
                                                            } elseif ((int)$row['sexe'] === 1) {
                                                                echo "Femme";
                                                            } else {
                                                                echo "Autres";
                                                            }
                                                        ?> 
                                                        </option>
                                                        <option value="0">Homme</option>
                                                        <option value="1">Femme</option>
                                                        <option value="2">Autres</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="updateBday">Date : </label>
                                                    <input type="date" class="form-control" id="updateBday" value="<?= htmlspecialchars($dateTimeFormat) ;?>" name="updateBday">
                                                </div>
                                                <div class="form-group">
                                                    <label for="updateEmail">Date : </label>
                                                    <input type="email" class="form-control" id="updateEmail" value="<?= htmlspecialchars($row['email']) ;?>" name="updateEmail">
                                                </div>
                                                <div class="form-group">
                                                    <label for="updateDepartment">Département : </label>
                                                    <input type="text" class="form-control" id="updateDepartment" value="<?= htmlspecialchars($row['departement']) ;?>" name="updateDepartment">
                                                </div>
                                                <div class="form-group">
                                                    <label for="updateMatiere">Matière principale :</label>
                                                    <select class="form-control" id="updateMatiere" name="updateMatiere">
                                                        <option value="<?= htmlspecialchars($row['id_matieres']) ?>">
                                                            <?= htmlspecialchars($row['nom_matiere']) ;?>
                                                        </option>
                                                        <option value="1">Mathématiques</option>
                                                        <option value="2">Littérature</option>
                                                        <option value="3">Sciences</option>
                                                    </select>
                                                </div>                                                
                                                <button type="submit" class="btn btn-warning" name="submit-update">Modifier</button>
                                            </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td scope="row">
                                    <button type="button" class="btn btn-danger btn-primary" data-toggle="modal" data-target="<?= "#deleteModal" . htmlspecialchars($row['etudiants_id']) ;?>">
                                        Supprimer
                                    </button>

                                    <div class="modal fade" id="<?= "deleteModal" . htmlspecialchars($row['etudiants_id']) ;?>" tabindex="-1" role="dialog" aria-labelledby="<?= "deleteModalLabel" . htmlspecialchars($row['etudiants_id']) ;?>" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="<?= "deleteModalLabel" . htmlspecialchars($row['etudiants_id']) ;?>">Supprimer un étudiant</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Attention, vous souhaitez supprimer une entrée, cette action est définitive.</p>
                                                    <p>Vous souhaitez supprimer l'étudiant suivant :</p>
                                                    <p><?php echo htmlspecialchars($row['etudiants_id']) . " - " .htmlspecialchars($row['nom']) . " " . htmlspecialchars($row['prenom']) ?></p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                                                    <a class="btn btn-danger" href="delete.php?id=<?= htmlspecialchars($row['etudiants_id']) ?>" role="button">Supprimer définitivement</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <?php
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header" id="headingOne">
                <h2 class="mb-0">
                    <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                        Afficher tous les étudiants dont le nom est "Palmer"
                    </button>
                </h2>
            </div>

            <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionQueries">
                <div class="card-body">
                <?php
                    $sql = "SELECT * FROM etudiants 
                    INNER JOIN matieres ON etudiants.id_matieres = matieres.id
                    WHERE etudiants.nom = 'PALMER'
                    ORDER BY etudiants.nom, etudiants.prenom";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute();

                    $data = $stmt->fetchAll();

                ?>

                    <table class="table table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Nom</th>
                                <th scope="col">Prénom</th>
                                <th scope="col">Genre</th>
                                <th scope="col">Date de naissance</th>
                                <th scope="col">Email</th>
                                <th scope="col">Département</th>
                                <th scope="col">Matières principales</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                foreach($data as $row) { 
                            ?>
                            <tr>
                                <td scope="row"><?= htmlspecialchars($row['etudiants_id']) ?></td>
                                <td scope="row"><?= htmlspecialchars($row['nom']) ?></td>
                                <td scope="row"><?= htmlspecialchars($row['prenom']) ?></td>
                                <td scope="row">
                                    <?php
                                    if ((int)$row['sexe'] === 0) {
                                        echo "Homme";
                                    } elseif ((int)$row['sexe'] === 1) {
                                        echo "Femme";
                                    } else {
                                        echo "Autres";
                                    }
                                    ?>  
                                </td>
                                <td scope="row"><?= htmlspecialchars($row['date_naissance']) ?></td>
                                <td scope="row"><?= htmlspecialchars($row['email']) ?></td>
                                <td scope="row"><?= htmlspecialchars($row['departement']) ?></td>
                                <td scope="row"><?= htmlspecialchars($row['nom_matiere']) ?></td>
                            </tr>
                            <?php
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header" id="headingTwo">
                <h2 class="mb-0">
                    <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        Afficher tous les étudiants qui sont des femmes                
                    </button>
                </h2>
            </div>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionQueries">
                <div class="card-body">
                <?php
                    $sql = "SELECT * FROM etudiants 
                    INNER JOIN matieres ON etudiants.id_matieres = matieres.id
                    WHERE etudiants.sexe = 1
                    ORDER BY etudiants.nom, etudiants.prenom";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute();

                    $data = $stmt->fetchAll();

                ?>
                    <table class="table table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Nom</th>
                                <th scope="col">Prénom</th>
                                <th scope="col">Genre</th>
                                <th scope="col">Date de naissance</th>
                                <th scope="col">Email</th>
                                <th scope="col">Département</th>
                                <th scope="col">Matières principales</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                foreach($data as $row) { 
                            ?>
                            <tr>
                                <td scope="row"><?= htmlspecialchars($row['etudiants_id']) ?></td>
                                <td scope="row"><?= htmlspecialchars($row['nom']) ?></td>
                                <td scope="row"><?= htmlspecialchars($row['prenom']) ?></td>
                                <td scope="row">
                                    <?php
                                    if ((int)$row['sexe'] === 0) {
                                        echo "Homme";
                                    } elseif ((int)$row['sexe'] === 1) {
                                        echo "Femme";
                                    } else {
                                        echo "Autres";
                                    }
                                    ?>  
                                </td>
                                <td scope="row"><?= htmlspecialchars($row['date_naissance']) ?></td>
                                <td scope="row"><?= htmlspecialchars($row['email']) ?></td>
                                <td scope="row"><?= htmlspecialchars($row['departement']) ?></td>
                                <td scope="row"><?= htmlspecialchars($row['nom_matiere']) ?></td>
                            </tr>
                            <?php
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header" id="headingThree">
                <h2 class="mb-0">
                    <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        Afficher tous les étudiants qui habitent un département commençant par la lettre "N"
                    </button>
                </h2>
            </div>
            <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionQueries">
                <div class="card-body">
                <?php
                    $sql = "SELECT * FROM etudiants 
                    INNER JOIN matieres ON etudiants.id_matieres = matieres.id
                    WHERE etudiants.departement LIKE 'N%'
                    ORDER BY etudiants.nom, etudiants.prenom";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute();

                    $data = $stmt->fetchAll();

                ?>
                    <table class="table table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Nom</th>
                                <th scope="col">Prénom</th>
                                <th scope="col">Genre</th>
                                <th scope="col">Date de naissance</th>
                                <th scope="col">Email</th>
                                <th scope="col">Département</th>
                                <th scope="col">Matières principales</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                foreach($data as $row) { 
                            ?>
                            <tr>
                                <td scope="row"><?= htmlspecialchars($row['etudiants_id']) ?></td>
                                <td scope="row"><?= htmlspecialchars($row['nom']) ?></td>
                                <td scope="row"><?= htmlspecialchars($row['prenom']) ?></td>
                                <td scope="row">
                                    <?php
                                    if ((int)$row['sexe'] === 0) {
                                        echo "Homme";
                                    } elseif ((int)$row['sexe'] === 1) {
                                        echo "Femme";
                                    } else {
                                        echo "Autres";
                                    }
                                    ?>  
                                </td>
                                <td scope="row"><?= htmlspecialchars($row['date_naissance']) ?></td>
                                <td scope="row"><?= htmlspecialchars($row['email']) ?></td>
                                <td scope="row"><?= htmlspecialchars($row['departement']) ?></td>
                                <td scope="row"><?= htmlspecialchars($row['nom_matiere']) ?></td>
                            </tr>
                            <?php
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header" id="headingFour">
                <h2 class="mb-0">
                    <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                        Afficher tous les étudiants dont l'email contient le mot "google"
                    </button>
                </h2>
            </div>
            <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordionQueries">
                <div class="card-body">
                <?php
                    $sql = "SELECT * FROM etudiants 
                    INNER JOIN matieres ON etudiants.id_matieres = matieres.id
                    WHERE etudiants.email LIKE '%@google%'
                    ORDER BY etudiants.nom, etudiants.prenom";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute();

                    $data = $stmt->fetchAll();

                ?>
                    <table class="table table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Nom</th>
                                <th scope="col">Prénom</th>
                                <th scope="col">Genre</th>
                                <th scope="col">Date de naissance</th>
                                <th scope="col">Email</th>
                                <th scope="col">Département</th>
                                <th scope="col">Matières principales</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                foreach($data as $row) { 
                            ?>
                            <tr>
                                <td scope="row"><?= htmlspecialchars($row['etudiants_id']) ?></td>
                                <td scope="row"><?= htmlspecialchars($row['nom']) ?></td>
                                <td scope="row"><?= htmlspecialchars($row['prenom']) ?></td>
                                <td scope="row">
                                    <?php
                                    if ((int)$row['sexe'] === 0) {
                                        echo "Homme";
                                    } elseif ((int)$row['sexe'] === 1) {
                                        echo "Femme";
                                    } else {
                                        echo "Autres";
                                    }
                                    ?>  
                                </td>
                                <td scope="row"><?= htmlspecialchars($row['date_naissance']) ?></td>
                                <td scope="row"><?= htmlspecialchars($row['email']) ?></td>
                                <td scope="row"><?= htmlspecialchars($row['departement']) ?></td>
                                <td scope="row"><?= htmlspecialchars($row['nom_matiere']) ?></td>
                            </tr>
                            <?php
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header" id="headingFive">
                <h2 class="mb-0">
                    <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                        Afficher tous les étudiants, triés par département par ordre alphabétique
                    </button>
                </h2>
            </div>
            <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordionQueries">
                <div class="card-body">
                <?php
                    $sql = "SELECT * FROM etudiants 
                    INNER JOIN matieres ON etudiants.id_matieres = matieres.id
                    ORDER BY etudiants.departement";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute();

                    $data = $stmt->fetchAll();

                ?>
                    <table class="table table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Nom</th>
                                <th scope="col">Prénom</th>
                                <th scope="col">Genre</th>
                                <th scope="col">Date de naissance</th>
                                <th scope="col">Email</th>
                                <th scope="col">Département</th>
                                <th scope="col">Matières principales</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                foreach($data as $row) { 
                            ?>
                            <tr>
                                <td scope="row"><?= htmlspecialchars($row['etudiants_id']) ?></td>
                                <td scope="row"><?= htmlspecialchars($row['nom']) ?></td>
                                <td scope="row"><?= htmlspecialchars($row['prenom']) ?></td>
                                <td scope="row">
                                    <?php
                                    if ((int)$row['sexe'] === 0) {
                                        echo "Homme";
                                    } elseif ((int)$row['sexe'] === 1) {
                                        echo "Femme";
                                    } else {
                                        echo "Autres";
                                    }
                                    ?>  
                                </td>
                                <td scope="row"><?= htmlspecialchars($row['date_naissance']) ?></td>
                                <td scope="row"><?= htmlspecialchars($row['email']) ?></td>
                                <td scope="row"><?= htmlspecialchars($row['departement']) ?></td>
                                <td scope="row"><?= htmlspecialchars($row['nom_matiere']) ?></td>
                            </tr>
                            <?php
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header" id="headingSix">
                <h2 class="mb-0">
                    <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                        Afficher le nombre d'hommes et de femmes
                    </button>
                </h2>
            </div>
            <div id="collapseSix" class="collapse" aria-labelledby="headingSix" data-parent="#accordionQueries">
                <div class="card-body">
                    <table class="table table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Total Hommes</th>
                                <th scope="col">Total Femmes</th>
                                <th scope="col">Total Autres</th>
                                <th scope="col">Total étudiants</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <?php
                                    $sql = "SELECT COUNT(*) AS total_homme FROM etudiants
                                    WHERE etudiants.sexe = 0";
                                    $stmt = $conn->prepare($sql);
                                    $stmt->execute();
                                    $row = $stmt->fetch();
                                ?>
                                <td scope="row"><?= htmlspecialchars($row['total_homme'])?></td>
                                <?php
                                    $sql = "SELECT COUNT(*) AS total_femme FROM etudiants
                                    WHERE etudiants.sexe = 1";
                                    $stmt = $conn->prepare($sql);
                                    $stmt->execute();
                                    $row = $stmt->fetch();
                                ?>
                                <td scope="row"><?= htmlspecialchars($row['total_femme'])?></td>
                                <?php
                                    $sql = "SELECT COUNT(*) AS total_autre FROM etudiants
                                    WHERE etudiants.sexe != 0 AND etudiants.sexe != 1";
                                    $stmt = $conn->prepare($sql);
                                    $stmt->execute();
                                    $row = $stmt->fetch();
                                ?>
                                <td scope="row"><?= htmlspecialchars($row['total_autre'])?></td>
                                <?php
                                    $sql = "SELECT COUNT(*) AS total_etudiant FROM etudiants";
                                    $stmt = $conn->prepare($sql);
                                    $stmt->execute();
                                    $row = $stmt->fetch();
                                ?>
                                <td scope="row"><?= htmlspecialchars($row['total_etudiant'])?></td>
                                
                            </tr>                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header" id="headingSeven">
                <h2 class="mb-0">
                    <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
                        Afficher l'âge des étudiants
                    </button>
                </h2>
            </div>
            <div id="collapseSeven" class="collapse" aria-labelledby="headingSeven" data-parent="#accordionQueries">
                <div class="card-body">
                <?php
                    $sql = "SELECT *, TIMESTAMPDIFF(YEAR, date_naissance, CURDATE()) AS age FROM etudiants 
                    INNER JOIN matieres ON etudiants.id_matieres = matieres.id
                    ORDER BY etudiants.departement";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute();

                    $data = $stmt->fetchAll();

                ?>
                    <table class="table table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Nom</th>
                                <th scope="col">Prénom</th>
                                <th scope="col">Genre</th>
                                <th scope="col">Age</th>
                                <th scope="col">Email</th>
                                <th scope="col">Département</th>
                                <th scope="col">Matières principales</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                foreach($data as $row) { 
                            ?>
                            <tr>
                                <td scope="row"><?= htmlspecialchars($row['etudiants_id']) ?></td>
                                <td scope="row"><?= htmlspecialchars($row['nom']) ?></td>
                                <td scope="row"><?= htmlspecialchars($row['prenom']) ?></td>
                                <td scope="row">
                                    <?php
                                    if ((int)$row['sexe'] === 0) {
                                        echo "Homme";
                                    } elseif ((int)$row['sexe'] === 1) {
                                        echo "Femme";
                                    } else {
                                        echo "Autres";
                                    }
                                    ?>  
                                </td>
                                <td scope="row"><?= htmlspecialchars($row['age']) ?></td>
                                <td scope="row"><?= htmlspecialchars($row['email']) ?></td>
                                <td scope="row"><?= htmlspecialchars($row['departement']) ?></td>
                                <td scope="row"><?= htmlspecialchars($row['nom_matiere']) ?></td>
                            </tr>
                            <?php
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header" id="headingEight">
                <h2 class="mb-0">
                    <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseEight" aria-expanded="false" aria-controls="collapseEight">
                        Afficher la moyenne d'âge des étudiants
                    </button>
                </h2>
            </div>
            <div id="collapseEight" class="collapse" aria-labelledby="headingEight" data-parent="#accordionQueries">
                <div class="card-body">
                <?php
                    $sql = "SELECT ROUND(AVG(TIMESTAMPDIFF(YEAR, date_naissance, CURDATE()))) AS moyenne_age FROM etudiants";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute();

                    $row = $stmt->fetch();

                ?>
                    <table class="table table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Moyenne d'âge des étudiants</th>
                            </tr>
                        </thead>
                        <tbody>                            
                            <tr>
                                <td scope="row"><?= htmlspecialchars($row['moyenne_age']) ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header" id="headingNine">
                <h2 class="mb-0">
                    <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseNine" aria-expanded="false" aria-controls="collapseNine">
                        Afficher la matière principale des étudiants
                    </button>
                </h2>
            </div>
            <div id="collapseNine" class="collapse" aria-labelledby="headingNine" data-parent="#accordionQueries">
                <div class="card-body">
                <?php
                    $sql = "SELECT * FROM etudiants 
                    INNER JOIN matieres ON etudiants.id_matieres = matieres.id
                    ORDER BY etudiants.nom, etudiants.prenom";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute();

                    $data = $stmt->fetchAll();

                ?>
                    <table class="table table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Nom</th>
                                <th scope="col">Prénom</th>
                                <th scope="col">Genre</th>
                                <th scope="col">Date de naissance</th>
                                <th scope="col">Email</th>
                                <th scope="col">Département</th>
                                <th scope="col">Matières principales</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                foreach($data as $row) { 
                            ?>
                            <tr>
                                <td scope="row"><?= htmlspecialchars($row['etudiants_id']) ?></td>
                                <td scope="row"><?= htmlspecialchars($row['nom']) ?></td>
                                <td scope="row"><?= htmlspecialchars($row['prenom']) ?></td>
                                <td scope="row">
                                    <?php
                                    if ((int)$row['sexe'] === 0) {
                                        echo "Homme";
                                    } elseif ((int)$row['sexe'] === 1) {
                                        echo "Femme";
                                    } else {
                                        echo "Autres";
                                    }
                                    ?>  
                                </td>
                                <td scope="row"><?= htmlspecialchars($row['date_naissance']) ?></td>
                                <td scope="row"><?= htmlspecialchars($row['email']) ?></td>
                                <td scope="row"><?= htmlspecialchars($row['departement']) ?></td>
                                <td scope="row"><?= htmlspecialchars($row['nom_matiere']) ?></td>
                            </tr>
                            <?php
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header" id="headingTen">
                <h2 class="mb-0">
                    <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseTen" aria-expanded="false" aria-controls="collapseTen">
                        Afficher les données de l'étudiants numéro 9
                    </button>
                </h2>
            </div>
            <div id="collapseTen" class="collapse" aria-labelledby="headingTen" data-parent="#accordionQueries">
                <div class="card-body">
                <?php
                    $sql = "SELECT * FROM etudiants 
                    INNER JOIN matieres ON etudiants.id_matieres = matieres.id
                    WHERE etudiants.etudiants_id = 9";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute();

                    $data = $stmt->fetchAll();

                ?>
                    <table class="table table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Nom</th>
                                <th scope="col">Prénom</th>
                                <th scope="col">Genre</th>
                                <th scope="col">Date de naissance</th>
                                <th scope="col">Email</th>
                                <th scope="col">Département</th>
                                <th scope="col">Matières principales</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                foreach($data as $row) { 
                            ?>
                            <tr>
                                <td scope="row"><?= htmlspecialchars($row['etudiants_id']) ?></td>
                                <td scope="row"><?= htmlspecialchars($row['nom']) ?></td>
                                <td scope="row"><?= htmlspecialchars($row['prenom']) ?></td>
                                <td scope="row">
                                    <?php
                                    if ((int)$row['sexe'] === 0) {
                                        echo "Homme";
                                    } elseif ((int)$row['sexe'] === 1) {
                                        echo "Femme";
                                    } else {
                                        echo "Autres";
                                    }
                                    ?>  
                                </td>
                                <td scope="row"><?= htmlspecialchars($row['date_naissance']) ?></td>
                                <td scope="row"><?= htmlspecialchars($row['email']) ?></td>
                                <td scope="row"><?= htmlspecialchars($row['departement']) ?></td>
                                <td scope="row"><?= htmlspecialchars($row['nom_matiere']) ?></td>
                            </tr>
                            <?php
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<?php } catch (PDOException $e) {
        die("Erreur : " . $e->getMessage());
    } ?>

<?php 
    require "footer.php";
?>