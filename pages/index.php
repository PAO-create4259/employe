<?php
session_start();
include("../inc/fonction.php");
$result= get_department_manager();


?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Departements</title>
     <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<header class="bg-dark text-white p-3 mb-4">
    <div class="container">
        <h1 class="h3 text-center">Liste des Departements</h1>
    </div>
</header>

<main class="container">
    <table class="table table-striped table-bordered text-center">
        <thead class="table-dark">
            <tr>
                <th>Code</th>
                <th>Nom du departement</th>
                <th>Manager actuel</th>
                <th>Voir employes</th>
                <th>Nombre employes</th>
                
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                <tr>
                    <td><?= htmlspecialchars($row['dept_no']) ?></td>
                    <td><?= htmlspecialchars($row['dept_name']) ?></td>
                    <td><?= htmlspecialchars($row['manager_name']) ?></td>
                    <td>
                        <a class="btn btn-primary btn-sm" href="../traitements/traitement_employes.php?dept_no=<?= $row['dept_no']?>">Voir</a>
                    </td>
                      <td><?= htmlspecialchars($row['employee_count']) ?></td>
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
