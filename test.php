<?php
	session_start();

    $userId = 8;

    require_once "connect.php";
    mysqli_report(MYSQLI_REPORT_STRICT);
    $connection = new mysqli($host, $db_user, $db_password, $db_name);

    // $startDate = strtotime(date('Y-m-d'));
    $startDate = date('t', strtotime("-1 MONTH"));

     $year = date('Y');
    $month = date('m');
   $day= date('d');
   $ab = date('t', strtotime("MONTH"));
   $ac = date('t', strtotime("-5 MONTH"));
   $startDate = date("Y-m-d", mktime (0,0,0,$month-5,$ac,$year));
    $endDate = date("Y-m-d", mktime (0,0,0,$month,'15',$year));

    // $startDateM = mktime($startDate);
 
    // $startDate = strtotime(date('Y-m-d', ));

    echo 'startdate: '.$startDate;
    echo 'enddate: '.$endDate;
    // echo $startDateM;


    // $incomesSql = ("SELECT ind.name, SUM(inc.amount) AS sum FROM incomes inc, incomes_category_assigned_to_users ind WHERE inc.user_id=$userId AND inc.date_of_income>=$startDate AND inc.date_of_income<=$endDate AND inc.user_id=ind.user_id AND inc.income_category_assigned_to_user_id = ind.id GROUP BY ind.id");
    $incomesSql = ("SELECT ind.name, SUM(inc.amount) AS sum FROM incomes inc, incomes_category_assigned_to_users ind WHERE inc.user_id=$userId AND (DATE(inc.date_of_income) BETWEEN '$startDate' AND '$endDate') AND inc.user_id=ind.user_id AND inc.income_category_assigned_to_user_id = ind.id GROUP BY ind.id");

    $result = $connection->query($incomesSql);
        $rowNumber = $result->num_rows;
 
            while($row = $result->fetch_assoc())
            {                 
                $_SESSION['categoryName'] = $row['name'];
                $_SESSION['sum'] = $row['sum'];
                echo $row['name'];
                echo $row['sum'];
            }            
                       


            // if($rowNumber > 0)
            //     {
            //         while($row = $result->fetch_assoc())
            //         {                 
            //             $_SESSION['categoryName'] = $row['name'];
            //             $_SESSION['sum'] = $row['sum'];
            //             echo $row['name'];
            //             echo $row['sum'];
            //         }            
                               
            //     }
