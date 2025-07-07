<?php
    require("connexion.php");
    //changement
function get_department_manager(){
    $sql = "
    SELECT d.dept_no, d.dept_name,
           CONCAT(e.first_name, ' ', e.last_name) AS manager_name,
           dm.to_date,
           (
                   SELECT COUNT(*) 
                   FROM dept_emp de
                   WHERE de.dept_no = d.dept_no
               ) AS employee_count
    FROM departments d
    JOIN dept_manager dm ON d.dept_no = dm.dept_no
    JOIN employees e ON dm.emp_no = e.emp_no
    WHERE dm.to_date ='9999-01-01'";
    $result = mysqli_query(dbconnect(),$sql);
    return $result;
}


function get_employe_department($dept_no){
    $sql = "
    SELECT e.emp_no, e.first_name, e.last_name, e.gender, e.hire_date
    FROM employees e
    JOIN dept_emp de ON e.emp_no = de.emp_no
    WHERE de.dept_no = '$dept_no'"; 
    $result = mysqli_query(dbconnect(), $sql);
    return $result;
}
function get_fiche_employe($emp_no){
    $sql="SELECT 
    e.emp_no,
    e.first_name,
    e.last_name,
    e.gender,
    e.hire_date,
    s.salary,
    s.from_date AS salary_from,
    s.to_date AS salary_to,
    t.title,
    t.from_date AS title_from,
    t.to_date AS title_to
FROM employees e
LEFT JOIN salaries s ON e.emp_no = s.emp_no
LEFT JOIN titles t ON e.emp_no = t.emp_no
WHERE e.emp_no = $emp_no AND s.emp_no = $emp_no
ORDER BY s.from_date DESC, t.from_date DESC";
$result = mysqli_query(dbconnect(), $sql);
    return $result;
}
    function get_departments() {
    $conn = dbconnect();
    $result = $conn->query("SELECT dept_no, dept_name FROM departments");
    $departments = [];
    while ($row = $result->fetch_assoc()) {
        $departments[] = $row;
    }
    return $departments;
}

function search_employees($dept_no, $name, $age_min, $age_max, $offset = 0, $limit = 20) {
    $conn = dbconnect();
    $conditions = [];
    $params = [];
    $types = '';

    $sql = "
        SELECT e.emp_no, e.first_name, e.last_name, e.gender, e.hire_date, e.birth_date, de.dept_no
        FROM employees e
        JOIN dept_emp de ON e.emp_no = de.emp_no
        WHERE de.to_date = '9999-01-01'
    ";

    if ($dept_no) {
        $sql .= " AND de.dept_no = ?";
        $params[] = $dept_no;
        $types .= 's';
    }

    if ($name) {
        $sql .= " AND (e.first_name LIKE ? OR e.last_name LIKE ?)";
        $like = "%$name%";
        $params[] = $like;
        $params[] = $like;
        $types .= 'ss';
    }

    if ($age_min) {
        $sql .= " AND TIMESTAMPDIFF(YEAR, e.birth_date, CURDATE()) >= ?";
        $params[] = $age_min;
        $types .= 'i';
    }

    if ($age_max) {
        $sql .= " AND TIMESTAMPDIFF(YEAR, e.birth_date, CURDATE()) <= ?";
        $params[] = $age_max;
        $types .= 'i';
    }

    $sql .= " ORDER BY e.emp_no LIMIT ?, ?";
    $params[] = $offset;
    $params[] = $limit;
    $types .= 'ii';

    $stmt = $conn->prepare($sql);
    if ($params) {
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    return $stmt->get_result();
}



?>