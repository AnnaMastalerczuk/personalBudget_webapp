<?php
	session_start();
    $zmienna = $_POST['currentMonth'];
    echo $zmienna;
    $zmienna2 = $_POST['previousMonth'];
    echo $zmienna2;
    $zmienna3 = $_POST['currentYear'];
    echo $zmienna3;
    $dateStart = $_POST['startDate'];
    echo $dateStart;
    $dateEnd = $_POST['endDate'];
    echo $dateEnd;

?>