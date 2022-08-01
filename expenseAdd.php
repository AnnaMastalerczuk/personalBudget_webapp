<?php
	session_start();

    if ((!isset($_POST['amount'])) || (!isset($_POST['date'])) || (!isset($_POST['payment'])) || (!isset($_POST['category'])) || (!isset($_POST['comment'])))
	{
		header('Location: expenses.php');
		exit();
	}

    if(isset($_POST['amount'])){
        $isExpenseCorrect = true;
        $amount = round($_POST['amount'], 2);
        $date = $_POST['date'];
        $selectPayment = $_POST['payment'];
        $selectCategory = $_POST['category'];
        $comment = $_POST['comment'];

        if($amount > 1000000){
            $isExpenseCorrect = false;
			$_SESSION['e_amount'] = "Podana kwota musi być mniejsza niż 1 000 000 zł";
            header('Location: expenses.php');
        }

        if ((strlen($comment) > 1000))
		{
            $isExpenseCorrect = false;
			$_SESSION['e_comment'] = "Komentarz może zawierać do 1000 znaków";
            header('Location: expenses.php');
		}

        require_once "connect.php";
		mysqli_report(MYSQLI_REPORT_STRICT);

        try 
		{
			$connection = new mysqli($host, $db_user, $db_password, $db_name);
			
            if ($connection->connect_errno!=0)
			{
				throw new Exception(mysqli_connect_errno());
                header('Location: expenses.php');
			}
            else 
            {
                if ($isExpenseCorrect == true)
				{
                $userId = $_SESSION['userId'];
                // $userId=8;

				if($connection->query("INSERT INTO expenses VALUES (NULL, '$userId', (SELECT id FROM expenses_category_assigned_to_users WHERE user_id = '$userId' AND name = '$selectCategory'), (SELECT id FROM payment_methods_assigned_to_users WHERE user_id = '$userId' AND name = '$selectPayment'), '$amount','$date','$comment')"))
                {
                    $_SESSION['positionAdded'] = "(Pozycja dodana pomyślnie)";
                    header('Location: mainmenu.php');
                }
                else
                {
                    throw new Exception(mysqli_connect_errno());
                    header('Location: expenses.php');
                }
                }
					
            }

            $connection->close();
        }
        catch(Exception $e)
		{
			echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności!</span>';
			echo '<br />Informacja developerska: '.$e;
		}

    }

?>