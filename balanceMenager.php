<?php
	session_start();
    // $userId = $_SESSION['userId'];

    $userId = 8;

    $data=date("Y-m-d, H:i", mktime (0,0,0,10,15,1985));
    $year = date('Y');
    $month = date('m');

    $currentMonthDaysNumber = date('t', strtotime("MONTH"));
    $previousMonthDaysNumber = date('t', strtotime("-1 MONTH"));

    if(isset($_POST['dataChoice']))
    {
        $dateChoice = $_POST['dataChoice'];

        if($dateChoice == "Bieżący miesiąc")
        {
            $endDate = date("Y-m-d", mktime (0,0,0,$month,$currentMonthDaysNumber,$year));
            $startDate = date("Y-m-d", mktime (0,0,0,$month,'01',$year));
         
        } 
            else if($dateChoice == "Poprzedni miesiąc")
        {
            $endDate = date("Y-m-d", mktime (0,0,0,($month-1),$previousMonthDaysNumber,$year));
            $startDate = date("Y-m-d", mktime (0,0,0,($month-1),'01',$year));  

        }
        else if ($dateChoice == "Bieżący rok")
        {
            $endDate = date("Y-m-d", mktime (0,0,0,'12','31',$year));
            $startDate = date("Y-m-d", mktime (0,0,0,'01','01',$year));

        }          
    }
    else if(isset($_POST['startDate']) && isset($_POST['endDate']))
    {                           
        $startDate= $_POST['startDate'];
        $endDate = $_POST['endDate'];
        if ($startDate > $endDate){
            echo $_SESSION['e_date'] = '!Data początkowa musi być wcześniejsza od daty końcowej. Podaj dane ponownie!';
            header('Location: balance.php');
        }
    }
     
    require_once "connect.php";
    mysqli_report(MYSQLI_REPORT_STRICT);

    try 
    {
        $connection = new mysqli($host, $db_user, $db_password, $db_name);
        
        if ($connection->connect_errno!=0)
        {
            throw new Exception(mysqli_connect_errno());
            header('Location: balance.php');
        } 
        else 
        {

            // $startDate = $_SESSION['startDate'];
            // $endDate = $_SESSION['endDate'];
            $_SESSION['startDate'] = $startDate;
            $_SESSION['endDate'] = $endDate;

            $incomesSql = ("SELECT ind.name, SUM(inc.amount) AS sum FROM incomes inc, incomes_category_assigned_to_users ind WHERE inc.user_id='$userId' AND inc.date_of_income>='$startDate' AND inc.date_of_income<='$endDate' AND inc.user_id=ind.user_id AND inc.income_category_assigned_to_user_id = ind.id GROUP BY ind.id");
            $result = $connection->query($incomesSql);
            $rowNumber = $result->num_rows;
            if($rowNumber > 0)
            {

                echo $rowNumber;
                // $_SESSION['row'] = $result->fetch_assoc();

                // $row = $result->fetch_assoc();

                // for($i=0; $i < $rowNumber; $i++)
                //     {
                //         echo $row['name'];
                //         echo $row['sum'];
                //     }

                while($row = $result->fetch_assoc())
                    {       

                        $_SESSION['categoryName'] = $row['name'];
                        $_SESSION['sum'] = $row['sum'];
                        // echo $row['name'];
                        // echo $row['sum'];

                        // $result->free_result();

                        // $_SESSION['categoryName'] = $row['name'];
                        // $_SESSION['sum'] = $row['sum'];
                        // echo $row['name'];
                        // echo $row['sum'];
                    }                              
            }
        }
        $connection->close();
        unset($startDate);
        unset($endDate);
    }
    catch(Exception $e)
		{
			echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności!</span>';
			echo '<br />Informacja developerska: '.$e;
		}




  

?>