<?php
	session_start();

    if ((!isset($_SESSION['isLogin'])) || ($_SESSION['isLogin']==false))
{
    header('Location: index.php');
    exit();
}

    $userId = $_SESSION['userId'];

    $data = date("Y-m-d, H:i", mktime (0,0,0,10,15,1985));
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
    else if (!isset($_POST['dataChoice'])){
        $endDate = date("Y-m-d", mktime (0,0,0,$month,$currentMonthDaysNumber,$year));
        $startDate = date("Y-m-d", mktime (0,0,0,$month,'01',$year));
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
     <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

 
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

    <section>
        <div class="container">
            <div class="row">

<?php

function changeNameIncome($categoryName)
{
    switch($categoryName)
    {
        case "Salary": $categoryName = "Wypłata";
        break;
        case "Interest": $categoryName = "Odsetki";
        break;
        case "Allegro": $categoryName = "Allegro";
        break;
        case "Another": $categoryName = "Inne";
        break;
    }                  

   return $categoryName;

}

require_once "connect.php";
    mysqli_report(MYSQLI_REPORT_STRICT);

if (isset($dataError) && !$dataError)
{
    echo '<div class="container">';
        echo '<div class="row">';
            echo '<div class="text-light mt-4 mb-4">';
                echo '<h2 class="display-6">Data początkowa musi być wcześniejsza od daty końcowej. Podaj dane ponownie.</h2>';
            echo '</div>';  
        echo '</div>'; 
    echo '</div>'; 
    unset($dataError);   
} else 
{

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
        $incomesSqlChart = ("SELECT ind.name, SUM(inc.amount) AS sum FROM incomes inc, incomes_category_assigned_to_users ind WHERE inc.user_id='$userId' AND inc.date_of_income>='$startDate' AND inc.date_of_income<='$endDate' AND inc.user_id=ind.user_id AND inc.income_category_assigned_to_user_id = ind.id GROUP BY ind.id");
        $incomesSql = ("SELECT ind.name, inc.amount, inc.date_of_income, inc.income_comment FROM incomes inc, incomes_category_assigned_to_users ind WHERE inc.user_id='$userId' AND inc.date_of_income>='$startDate' AND inc.date_of_income<='$endDate' AND inc.user_id=ind.user_id AND inc.income_category_assigned_to_user_id = ind.id");
       
        $resultIncomes = $connection->query($incomesSql);
        $resultIncomesChart = $connection->query($incomesSqlChart);
        
        $rowNumberIncomes = $resultIncomes->num_rows;       

        if($rowNumberIncomes > 0)
        {
            $incomesSum = 0;
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
                                        echo '<th scope="col">Data</th>';
                                        echo '<th scope="col">Komentarz</th>';
                                    echo '</tr>';
                                echo '</thead>';
                                echo '<tbody>';
                                while($row = $resultIncomes->fetch_assoc())
                                {
                                    $categoryName = $row['name'];
                                    $categoryName = changeNameIncome($categoryName);

                                    echo '<tr>';
                                        echo '<td>'.$categoryName.'</td>';
                                        echo '<td>'.$row['amount'].'</td>';
                                        echo '<td>'.$row['date_of_income'].'</td>';
                                        echo '<td>'.$row['income_comment'].'</td>';
                                    echo '</tr>';   
                                    $incomesSum += $row['amount'];  
                                }
                                // $resultIncomes -> free_result();

                                while($row = $resultIncomesChart->fetch_assoc())
                                {
                                    $categoryName = $row['name'];
                                    $categoryName = changeNameIncome($categoryName);

                                    $nameArrayIncomes[] = $categoryName;    
                                    $sumArrayIncomes[] = $row['sum'];                               
                                }
                                // $resultIncomesChart -> free_result();

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
                            echo '<div class="piechart m-3">';
                                echo '<canvas id="myChartIn"></canvas>';
                        echo '</div>';
                    echo '</div>';
        }
        else if ($rowNumberIncomes == 0)
        {
            echo '<div class="container">';                    
                echo '<div class="text-light mt-2 mb-2">';
                    echo '<h2 class="display-6">Brak zapisanych przychodów w przedziale czasu od '.$startDate.' do '.$endDate.'</h2>';
                echo '</div>';
            echo '</div>';
        }
    }
    // $resultIncomes -> free_result(); 
    // $resultIncomesChart -> free_result(); 
    // $connection->close();

}
catch(Exception $e)
    {
        echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności!</span>';
        echo '<br />Informacja developerska: '.$e;
    }
?>                        

<?php   

function changeNameExpense($categoryName){
    switch($categoryName)
    {
        case "Transport": $categoryName = "Transport";
        break;
        case "Books": $categoryName = "Książki";
        break;
        case "Food": $categoryName = "Jedzenie";
        break;
        case "Apartments": $categoryName = "Mieszkanie";
        break;
        case "Telecommunication": $categoryName = "Telekomunikacja";
        break;
        case "Health": $categoryName = "Opieka zdrowotna";
        break;
        case "Clothes": $categoryName = "Ubrania";
        break;
        case "Hygiene": $categoryName = "Higiena";
        break;
        case "Kids": $categoryName = "Dzieci";
        break;
        case "Recreation": $categoryName = "Rozrywka";
        break;
        case "Trip": $categoryName = "Wycieczka";
        break;
        case "Savings": $categoryName = "Oszczedności";
        break;
        case "For Retirement": $categoryName = "Emerytura";
        break;
        case "Debt Repayment": $categoryName = "Spłata długów";
        break;
        case "Gift": $categoryName = "Darowizna";
        break;
        case "Another": $categoryName = "Inne";
        break;
    }

    return $categoryName;
}

function changeNamePayment($categoryPay){
    switch($categoryPay)
    {
        case "Cash": $categoryPay = "Gotówka";
        break;
        case "Debit Card": $categoryPay = "Karta debetowa";
        break;
        case "Credit Card": $categoryPay = "Karta kredytowa";
        break;
    }

    return $categoryPay;
}

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
            $expensesSqlChart = ("SELECT exd.name, SUM(ex.amount) AS sum FROM expenses ex, expenses_category_assigned_to_users exd WHERE ex.user_id='$userId' AND ex.date_of_expense>='$startDate' AND ex.date_of_expense<='$endDate' AND ex.user_id=exd.user_id AND ex.expense_category_assigned_to_user_id = exd.id GROUP BY exd.id");
            $expensesSql = ("SELECT exd.name, ex.amount, ex.date_of_expense, pay.name, ex.expense_comment FROM expenses ex, expenses_category_assigned_to_users exd, payment_methods_assigned_to_users pay WHERE ex.user_id='$userId' AND ex.date_of_expense>='$startDate' AND ex.date_of_expense<='$endDate' AND ex.user_id=exd.user_id AND ex.user_id=pay.user_id AND ex.payment_method_assigned_to_user_id = pay.id AND ex.expense_category_assigned_to_user_id = exd.id");
           
            $resultExpenses = $connection->query($expensesSql);
            $resultExpensesChart = $connection->query($expensesSqlChart);
           
            $rowNumberExpenses = $resultExpenses->num_rows;
    
            if($rowNumberExpenses > 0)
            {           
                $expensesSum = 0;   

                    echo '<div class="col-md-6 bg-light mb-3">';
                        echo '<h2 class="display-6">Bilans wydatków</h2>';
                        echo '<table class="table">';
                            echo '<thead>';
                                echo '<tr>';
                                    echo '<th scope="col">Kategoria</th>';
                                    echo '<th scope="col">Suma</th>';
                                    echo '<th scope="col">Data</th>';
                                    echo '<th scope="col">Sposób płatności</th>';
                                    echo '<th scope="col">Komentarz</th>';
                                echo '</tr>';
                            echo '</thead>';
                            echo '<tbody>';
                            while($row = $resultExpenses->fetch_array())
                            {
                                $categoryName = $row['0'];
                                $categoryPay = $row['3'];
                                $categoryName = changeNameExpense($categoryName);
                                $categoryPay = changeNamePayment($categoryPay);

                                echo '<tr>';
                                    echo '<td>'.$categoryName.'</td>';
                                    echo '<td>'.$row['amount'].'</td>';
                                    echo '<td>'.$row['date_of_expense'].'</td>';
                                    echo '<td>'.$categoryPay.'</td>';
                                    echo '<td>'.$row['expense_comment'].'</td>';
                                echo '</tr>';   
                                $expensesSum += $row['amount'];
                            }
                            // $resultExpenses -> free_result();  
                            
                            while($row = $resultExpensesChart->fetch_assoc())
                                {
                                    $categoryName = $row['name'];
                                    $categoryName = changeNameExpense($categoryName);
                                    
                                    $nameArrayExpenses[] = $categoryName;    
                                    $sumArrayExpenses[] = $row['sum'];                                   
                                }
                            // $resultExpensesChart -> free_result();

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
                        echo '<div class="piechart m-3">';
                            echo '<canvas id="myChartEx"></canvas>';
                        echo '</div>';
                    echo '</div>';
                    }
                    else if ($rowNumberExpenses == 0)
                    {
                        echo '<div class="container">';                    
                            echo '<div class="text-light mt-2 mb-2">';
                                echo '<h2 class="display-6">Brak zapisanych wydatków w przedziale czasu od '.$startDate.' do '.$endDate.'</h2>';
                            echo '</div>';
                        echo '</div>';
                    }
                }                

                // $connection->close();
            }
            catch(Exception $e)
                {
                    echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności!</span>';
                    echo '<br />Informacja developerska: '.$e;
                }

    ?>

<?php
    if (!$rowNumberIncomes == 0 && !$rowNumberExpenses == 0)
    {
        echo '<div class="text-light mt-4">';        
                    if ($incomesSum >= $expensesSum){
                        echo '<p class="statement fs-5">Gratulacje. Świetnie zarządzasz finansami!</p>';
                    } else
                    {
                        echo '<p class="statement fs-5">Uważaj, wpadasz w długi!</p>';
                    }  
            echo '<p class="fs-5">Suma przychodów: <span>'.$incomesSum.' zł</span></p>';
            echo '<p class="fs-5">Suma wydatków: <span>'.$expensesSum.' zł</span></p>';                         
        echo '</div>';
    }
        unset($incomesSum);
        unset($startDate);
        unset($endDate);                
        unset($expensesSum);

        $resultIncomes -> free_result(); 
        $resultIncomesChart -> free_result(); 
        $resultExpenses -> free_result(); 
        $resultExpensesChart -> free_result();
        $connection->close();

    }
?>
            </div>
        </div>
    </section>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const nameArrayIn = <?php echo json_encode($nameArrayIncomes); ?>;
const sumArrayIn = <?php echo json_encode($sumArrayIncomes); ?>;

const dataIn = {
  labels: nameArrayIn,
  datasets: [{
    label: 'Diagram przychodów',
    data: sumArrayIn,
    backgroundColor: [
        'rgb(255, 99, 132)',
        'rgb(154, 205, 50)',
        'rgb(255, 205, 86)',
        'rgb(75, 192, 192)' 
    ],
    hoverOffset: 4
  }]
};

  const configIn = {
    type: 'pie',
    data: dataIn,
  };

  const myChartIn = new Chart(
    document.getElementById('myChartIn'),
    configIn
  );

</script>

<script>
const nameArrayEx = <?php echo json_encode($nameArrayExpenses); ?>;
const sumArrayEx = <?php echo json_encode($sumArrayExpenses); ?>;

const dataEx = {
  labels: nameArrayEx,
  datasets: [{
    label: 'Diagram wydatków',
    data: sumArrayEx,
    backgroundColor: [
        'rgb(255, 99, 132)',
        'rgb(255, 159, 64)',
        'rgb(255, 205, 86)',
        'rgb(75, 192, 192)',
        'rgb(54, 162, 235)',
        'rgb(153, 102, 255)',
        'rgb(201, 203, 207)',
        'rgb(154, 205, 50)',
        'rgb(107, 142, 35)',
        'rgb(47 79 79)',
        'rgb(	112 128 144)',
        'rgb(192 192 192)',
        'rgb(165 42 42)',
        'rgb(160 82 45)',
        'rgb(65 105 225)',
        'rgb(100 149 237)'
    ],
    hoverOffset: 4
  }]
};

  const configEx = {
    type: 'pie',
    data: dataEx,
  };

  const myChartEx = new Chart(
    document.getElementById('myChartEx'),
    configEx
  );

</script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"
        integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"
        integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous">
    </script>
</body>

</html>