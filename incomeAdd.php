<?php
	session_start();

    if ((!isset($_POST['amount'])) || (!isset($_POST['date'])) || (!isset($_POST['flexRadioDefault'])) || (!isset($_POST['comment'])))
	{
		header('Location: incomes.php');
		exit();
	}

    if(isset($_POST['amount'])){
        $isIncomeCorrect = true;
        $amount = round($_POST['amount'], 2);
        $date = $_POST['date'];
        $checkbox = $_POST['flexRadioDefault'];
        $comment = $_POST['comment'];

        if($amount > 1000000){
            $isIncomeCorrect = false;
			$_SESSION['e_amount'] = "Podana kwota musi być mniejsza niż 1 000 000 zł";
            header('Location: incomes.php');
        }

        if ((strlen($comment) > 1000))
		{
            $isIncomeCorrect = false;
			$_SESSION['e_comment'] = "Komentarz może zawierać do 1000 znaków";
            header('Location: incomes.php');
		}

        require_once "connect.php";
		mysqli_report(MYSQLI_REPORT_STRICT);

        try 
		{
			$connection = new mysqli($host, $db_user, $db_password, $db_name);
			
            if ($connection->connect_errno!=0)
			{
				throw new Exception(mysqli_connect_errno());
                header('Location: incomes.php');
			}
            else 
            {
                if ($isIncomeCorrect == true)
				{
                $userId = $_SESSION['userId'];

				if($connection->query("INSERT INTO incomes VALUES (NULL, '$userId', (SELECT id FROM incomes_category_assigned_to_users WHERE user_id = '$userId' AND name = '$checkbox'), '$amount','$date','$comment')"))
                {
                    $_SESSION['incomeAdded'] = "(Wydatek dodany pomyślnie)";
                    header('Location: mainmenu.php');
                }
                else
                {
                    throw new Exception(mysqli_connect_errno());
                    header('Location: incomes.php');
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