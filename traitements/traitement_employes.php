<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

        session_start();
        include("../inc/fonction.php");
        $dept_no = $_GET['dept_no'];

        get_employe_department($dept_no);
        $header = "Location:../pages/employes.php?dept_no=%s";
        $header = sprintf($header, $dept_no);
        header($header);
?>