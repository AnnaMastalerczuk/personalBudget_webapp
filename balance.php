<?php
	session_start();

    if ((!isset($_SESSION['isLogin'])) || ($_SESSION['isLogin']==false))
{
    header('Location: index.php');
    exit();
}

    // $userId = 8;
    $userId = $_SESSION['userId'];

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
            $dataError = false;
        }
    }     

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bilans</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="balance.css">
</head>

<body>
    <nav class="navbar">
        <div class="container-fluid border-bottom border-light ms-md-5 me-md-5">
            <h1 class="display-5 text-light">Budżet osobisty</h1>
            <div class="text-light fs-5"><a class="nav-link text-light" href="mainmenu.php">Menu</a></div>
            <div class="nav-item dropdown">                
                <div class="nav-link dropdown-toggle text-light fs-5" id="navbarDropdown" role="button"
                    data-bs-toggle="dropdown" aria-expanded="false">Wybierz zakres dat</div>
                    <form method="post" class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <input class="dropdown-item" type="submit" name="dataChoice" value="Bieżący miesiąc"></input>
                        <input class="dropdown-item" type="submit" name="dataChoice" value="Poprzedni miesiąc"></input>
                        <input class="dropdown-item" type="submit" name="dataChoice" value="Bieżący rok"></input>
                        <input class="dropdown-item" data-bs-toggle="modal" data-bs-target="#exampleModal" value="Niestandardowy"></input>
                    </form>
            </div>

                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header">
                                <h5 class="modal-title display-6 fs-4" id="exampleModalLabel">Podaj datę początkową i końcową:</h5>
                            </div>
                            <form method="post" class="modal-body">
                                <div>
                                    <label class="form-label" for="start-date">Podaj datę początkową:</label>
                                    <input class="form-control" type="date" id="start-date" name="startDate">
                                </div>
                                <div class="mt-3">
                                    <label class="form-label" for="end-date">Podaj datę końcową:</label>
                                    <input class="form-control" type="date" id="end-date" name="endDate">
                                </div>                            
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Anuluj</button>
                                    <button class="btn btn-outline-dark">Zapisz</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
        </div>
    </nav>

<?php

    if (isset($dataError) && !$dataError){
        echo '<div class="container">';
            echo '<div class="row">';
                echo '<div class="text-light mt-4 mb-4">';
                    echo '<h2 class="display-6">Data początkowa musi być wcześniejsza od daty końcowej. Podaj dane ponownie.</h2>';
                echo '</div>';  
            echo '</div>'; 
        echo '</div>'; 
        unset($dataError);   
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

    if (isset($startDate) && isset($endDate))
    {
        $incomesSql = ("SELECT ind.name, SUM(inc.amount) AS sum FROM incomes inc, incomes_category_assigned_to_users ind WHERE inc.user_id='$userId' AND inc.date_of_income>='$startDate' AND inc.date_of_income<='$endDate' AND inc.user_id=ind.user_id AND inc.income_category_assigned_to_user_id = ind.id GROUP BY ind.id");
        $expensesSql = ("SELECT exd.name, SUM(ex.amount) AS sum FROM expenses ex, expenses_category_assigned_to_users exd WHERE ex.user_id='$userId' AND ex.date_of_expense>='$startDate' AND ex.date_of_expense<='$endDate' AND ex.user_id=exd.user_id AND ex.expense_category_assigned_to_user_id = exd.id GROUP BY exd.id");
        $resultIncomes = $connection->query($incomesSql);
        $resultExpenses = $connection->query($expensesSql);
        $rowNumberIncomes = $resultIncomes->num_rows;
        $rowNumberExpenses = $resultExpenses->num_rows;

        if($rowNumberIncomes > 0 || $rowNumberExpenses > 0)
        {
            $incomesSum = 0;
            $expensesSum = 0;

            echo '<section>';
                echo '<div class="container">';
                    echo '<div class="row">';
                        echo '<div class="text-light mt-2 mb-2">';
                        echo '<h2 class="display-6">Bilans od '.$startDate.' do '.$endDate.'</h2>';
                        echo '</div>';
                        echo '<div class="col-md-6 bg-light mb-3">';
                            echo '<h2 class="display-6">Bilans przychodów</h2>';
                            echo '<table class="table">';
                                echo '<thead>';
                                    echo '<tr>';
                                        echo '<th scope="col">Kategoria</th>';
                                        echo '<th scope="col">Suma [zł]</th>';
                                    echo '</tr>';
                                echo '</thead>';
                                echo '<tbody>';
                                while($row = $resultIncomes->fetch_assoc())
                                {                         
                                    echo '<tr>';
                                        echo '<td>'.$row['name'].'</td>';
                                        echo '<td>'.$row['sum'].'</td>';
                                    echo '</tr>';   
                                    $incomesSum += $row['sum'];  
                                }
                                $resultIncomes -> free_result();                   
                                echo '</tbody>';
                                echo '<tfoot>';
                                    echo '<tr>';
                                        echo '<td>Suma</td>';
                                        echo '<td>'.$incomesSum.'</td>';                                        
                                    echo '</tr>';
                                echo '</tfoot>';
                            echo '</table>';
                        echo '</div>';
                        echo '<div class="col-md-6 diagram bg-light mb-3">';
                            echo '<h2 class="display-6">Diagram przychodów</h2>';
                            echo '<div class="piechart m-3"><img src="img/markus-spiske-jgOkEjVw-KM-unsplash.jpg" class="img-fluid" alt=""></div>';
                        echo '</div>';

                        echo '<div class="col-md-6 bg-light mb-3">';
                        echo '<h2 class="display-6">Bilans wydatków</h2>';
                        echo '<table class="table">';
                            echo '<thead>';
                                echo '<tr>';
                                    echo '<th scope="col">Kategoria</th>';
                                    echo '<th scope="col">Suma</th>';
                                echo '</tr>';
                            echo '</thead>';
                            echo '<tbody>';
                            while($row = $resultExpenses->fetch_assoc())
                            {                         
                                echo '<tr>';
                                    echo '<td>'.$row['name'].'</td>';
                                    echo '<td>'.$row['sum'].'</td>';
                                echo '</tr>';   
                                $expensesSum += $row['sum'];  
                            }
                            $resultExpenses -> free_result();                   
                            echo '</tbody>';
                            echo '<tfoot>';
                                echo '<tr>';
                                    echo '<td>Suma [zł]</td>';
                                    echo '<td>'.$expensesSum.'</td>';                                    
                                echo '</tr>';
                            echo '</tfoot>';
                        echo '</table>';
                    echo '</div>';
                    echo '<div class="col-md-6 diagram bg-light mb-3">';
                        echo '<h2 class="display-6">Diagram wydatków</h2>';
                        echo '<div class="piechart m-3"><img src="img/markus-spiske-jgOkEjVw-KM-unsplash.jpg" class="img-fluid" alt=""></div>';
                    echo '</div>';                
                echo '</div>';
                
                echo '<div class="text-light mt-4">';
                    if ($incomesSum > $expensesSum){
                        echo '<p class="statement fs-5">Gratulacje. Świetnie zarządzasz finansami!</p>';
                    } else
                    {
                        echo '<p class="statement fs-5">Uważaj, wpadasz w długi!</p>';
                    }  
                    echo '<p class="fs-5">Suma przychodów: <span>'.$incomesSum.' zł</span></p>';
                    echo '<p class="fs-5">Suma wydatków: <span>'.$expensesSum.' zł</span></p>';                 
                echo '</div>';
            echo '</div>';
        echo '</section>';
        } else if ($rowNumberIncomes == 0 && $rowNumberExpenses == 0)
        {
            echo '<div class="container">';                    
                echo '<div class="text-light mt-2 mb-2">';
                    echo '<h2 class="display-6">Brak zapisanych przychodów i wydatków w przedziale czasu od '.$startDate.' do '.$endDate.'</h2>';
                echo '</div>';
            echo '</div>';
        }
    }
}
    $connection->close();
    unset($startDate);
    unset($endDate);
    unset($incomesSum);
    unset($expensesSum);

}
catch(Exception $e)
    {
        echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności!</span>';
        echo '<br />Informacja developerska: '.$e;
    }
    
?>       

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"
        integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"
        integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous">
    </script>
</body>

</html>