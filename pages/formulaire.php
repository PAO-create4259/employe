<?php
session_start();
include("../inc/fonction.php");

$dept_no = $_GET['dept_no'] ?? '';
$name = $_GET['name'] ?? '';
$age_min = $_GET['age_min'] ?? '';
$age_max = $_GET['age_max'] ?? '';
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$limit = 20;
$offset = ($page - 1) * $limit;

$departments = get_departments();
$result = search_employees($dept_no, $name, $age_min, $age_max, $offset, $limit);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des employés</title>
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<header class="bg-dark text-white p-3 mb-4">
    <div class="container">
        <h1 class="h4">Recherche d'employés</h1>
    </div>
</header>

<main class="container">

    <form method="GET" class="row g-3 mb-4">
        <div class="col-md-3">
            <label class="form-label">Département</label>
            <select name="dept_no" class="form-select">
                <option value="">-- Tous --</option>
                <?php foreach ($departments as $dept): ?>
                    <option value="<?= htmlspecialchars($dept['dept_no']) ?>" <?= $dept_no === $dept['dept_no'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($dept['dept_name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label">Nom ou prénom</label>
            <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($name) ?>">
        </div>
        <div class="col-md-2">
            <label class="form-label">Âge min</label>
            <input type="number" name="age_min" class="form-control" value="<?= htmlspecialchars($age_min) ?>">
        </div>
        <div class="col-md-2">
            <label class="form-label">Âge max</label>
            <input type="number" name="age_max" class="form-control" value="<?= htmlspecialchars($age_max) ?>">
        </div>
        <div class="col-md-2 align-self-end">
            <button type="submit" class="btn btn-primary w-100">Rechercher</button>
        </div>
    </form>

    <table class="table table-hover table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Matricule</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Sexe</th>
                <th>Date d'embauche</th>
                <th>Âge</th>
                <th>Département</th>
                <th>Fiche</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['emp_no']) ?></td>
                <td><?= htmlspecialchars($row['last_name']) ?></td>
                <td><?= htmlspecialchars($row['first_name']) ?></td>
                <td><?= htmlspecialchars($row['gender']) ?></td>
                <td><?= htmlspecialchars($row['hire_date']) ?></td>
                <td>
                    <?php
                    $birth_date = new DateTime($row['birth_date']);
                    $today = new DateTime();
                    echo $birth_date->diff($today)->y;
                    ?>
                </td>
                <td><?= htmlspecialchars($row['dept_no']) ?></td>
                <td>
                    <a class="btn btn-sm btn-secondary" href="fiche.php?emp_no=<?= urlencode($row['emp_no']) ?>">Voir fiche</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <nav class="d-flex justify-content-between">
        <a class="btn btn-outline-secondary <?= $page <= 1 ? 'disabled' : '' ?>"
           href="?<?= http_build_query(array_merge($_GET, ['page' => $page - 1])) ?>">⬅ Précédent</a>
        <a class="btn btn-outline-secondary <?= $result->num_rows < $limit ? 'disabled' : '' ?>"
           href="?<?= http_build_query(array_merge($_GET, ['page' => $page + 1])) ?>">Suivant ➡</a>
    </nav>

</main>

<footer class="bg-light text-center py-3 mt-4">
    <p class="mb-0">Projet Employees DB - Pagination et recherche</p>
</footer>

</body>
</html>
