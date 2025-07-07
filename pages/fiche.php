<?php
    session_start();
    include("../inc/fonction.php");
    $emp_no = $_GET['emp_no'];
    $result = get_fiche_employe($emp_no);

    $info = null;
    $salaires = [];
    $titres = [];

    while ($row = mysqli_fetch_assoc($result)) {
        if (!$info) {
            $info = [
                'first_name' => $row['first_name'],
                'last_name' => $row['last_name'],
                'gender' => $row['gender'],
                'hire_date' => $row['hire_date'],
                'dept_no' => $row['current_dept_no']
            ];
        }

        // Ajouter salaire s'il y en a
        if (!empty($row['salary'])) {
            $salaires[] = [
                'salary' => $row['salary'],
                'from_date' => $row['salary_from'],
                'to_date' => $row['salary_to']
            ];
        }

        // Ajouter titre s'il y en a
        if (!empty($row['title'])) {
            $titres[] = [
                'title' => $row['title'],
                'from_date' => $row['title_from'],
                'to_date' => $row['title_to']
            ];
        }
        // ✅ Calcul du titre le plus long
      $longest_title = null;
      $longest_duration = -1;
      foreach ($titres as $titre) {
        $from = new DateTime($titre['from_date']);
        $to = new DateTime($titre['to_date']);
        $interval = $from->diff($to);
        $days = (int)$interval->format('%a');

        if ($days > $longest_duration) {
            $longest_duration = $days;
            $emploi_long = $titre['title'];
        }
    
    }}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Fiche employé <?= htmlspecialchars($emp_no) ?></title>
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<header class="bg-primary text-white p-3">
    <div class="container">
        <h1 class="h4">Fiche de l'employé n°<?= htmlspecialchars($emp_no) ?></h1>
    </div>
</header>

<main class="container my-4">
    
    <?php if ($info): ?>
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title"><?= htmlspecialchars($info['first_name'] . ' ' . $info['last_name']) ?></h5>
             <p>numero_deparetement: <?= htmlspecialchars($info['dept_no']) ?></p>
            <p>Sexe : <?= htmlspecialchars($info['gender']) ?></p>
            <p>Date d'embauche : <?= htmlspecialchars($info['hire_date']) ?></p>
            <p>Emploi le plus long:  <?= htmlspecialchars($emploi_long) ?></p>
            <a class="btn btn-warning mt-2" href="changement_departement.php?emp_no=<?= urlencode($emp_no) ?>">
            Changer de departement
            </a>
        </div>
    </div>
    <?php else: ?>
        <div class="alert alert-danger">Aucun employé trouvé.</div>
    <?php endif; ?>

    <div class="mb-4">
        <h4>💰 Historique des salaires</h4>
        <table class="table table-bordered">
            <thead class="table-secondary">
                <tr>
                    <th>Salaire</th>
                    <th>De</th>
                    <th>À</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($salaires as $salaire): ?>
                <tr>
                    <td><?= htmlspecialchars($salaire['salary']) ?> $</td>
                    <td><?= htmlspecialchars($salaire['from_date']) ?></td>
                    <td><?= htmlspecialchars($salaire['to_date']) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="mb-4">
        <h4>🧑‍💼 Historique des titres</h4>
        <table class="table table-bordered">
            <thead class="table-secondary">
                <tr>
                    <th>Titre</th>
                    <th>De</th>
                    <th>À</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($titres as $titre): ?>
                <tr>
                    <td><?= htmlspecialchars($titre['title']) ?></td>
                    <td><?= htmlspecialchars($titre['from_date']) ?></td>
                    <td><?= htmlspecialchars($titre['to_date']) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <a href="index.php" class="btn btn-secondary">⬅ Accueil</a>
</main>

<footer class="bg-light text-center py-3">
    <p class="mb-0">Projet Employees DB - ETU4221-4259</p>
</footer>

</body>
</html>