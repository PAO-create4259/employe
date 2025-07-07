<?php
session_start();
include("../inc/fonction.php");
$result= "SELECT d.dept_name AS Departement, SUM(CASE WHEN e.sex = 'M'THEN 1 ELSE 0 END) AS Homme,
                SUM(CASE WHEN e.sex = 'M'THEN 1 ELSE 0 END) AS Femme,
                ROUND(avg(s.salary), 2) AS salaire_moyen
                FROM employees e 
                JOIN dept_emp de ON d.empt_no = de.empt_no
                JOIN departments d ON de.dept_no = 
                JOIN salaries ON d.empt_no = s.empt_no
                GROUP BY d.dept_name
                ORDER BY salaire_moyen DESC";

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Emplois</title>
     <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<header class="bg-dark text-white p-3 mb-4">
    <div class="container">
        <h1 class="h3 text-center">Liste des emplois</h1>
    </div>
</header>

<main class="container">
    <table class="table table-striped table-bordered text-center">
        <thead class="table-dark">
            <tr>
                <th>Nom du departement</th>
                <th>Nombre total hommes</th>
                <th>Nombre total femmes</th>
                <th>Salaire moyen</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                <tr>
                    <td><?= htmlspecialchars($row['departement']) ?></td>
                    <td><?= htmlspecialchars($row['Hommes']) ?></td>
                    <td><?= htmlspecialchars($row['Femmes']) ?></td>
                    <td><?= htmlspecialchars($row['salaire_moyen']) ?>$</td>
                    <td>
                        <a class="btn btn-primary btn-sm" href="../traitements/traitement_employes.php?dept_no=<?= $row['dept_no']?>">Vu</a>
                    </td>
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
