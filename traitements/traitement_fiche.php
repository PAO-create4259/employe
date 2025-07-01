<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

        session_start();
        include("../inc/fonction.php");
        $emp_no = $_GET['emp_no'];

        get_fiche_employe($emp_no);
        $header = "Location:../pages/fiche.php?emp_no=%s";
        $header = sprintf($header, $emp_no);
        header($header);
?>