<?php
session_start();
include("../inc/fonction.php");
$dept_no = $_GET['dept_no'];
$result = get_employe_department($dept_no);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Employés du département <?= htmlspecialchars($dept_no) ?></title>
     <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<header class="bg-dark text-white p-3 mb-4">
    <div class="container">
        <h1 class="h4">Employes du département <?= htmlspecialchars($dept_no) ?></h1>
    </div>
</header>

<main class="container">
     <a href="formulaire.php" class="btn btn-primary mt-6">Recherche</a>
     <a href="index.php" class="btn btn-secondary mt-3">⬅ Retour a la liste de départements</a>
     <table class="table table-hover table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Matricule</th>
                <th>Nom</th>
                <th>Prenom</th>
                <th>Sexe</th>
                <th>Date d'embauche</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                <tr>
                    <td><?= htmlspecialchars($row['emp_no']) ?></td>
                    <td ><a class="btn-sm" href="../traitements/traitement_fiche.php?emp_no=<?= $row['emp_no']?>"><?= htmlspecialchars($row['last_name']) ?></a></td>
                    <td><?= htmlspecialchars($row['first_name']) ?></td>
                    <td><?= htmlspecialchars($row['gender']) ?></td>
                    <td><?= htmlspecialchars($row['hire_date']) ?></td>
                  
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

   
</main>

<footer class="bg-light text-center py-3 mt-4">
    <p class="mb-0">Projet Employees DB - ETU4221-4259</p>
</footer>

</body>
</html>
