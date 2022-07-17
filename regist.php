<?php
	session_start();

    if ((!isset($_POST['login'])) || (!isset($_POST['password'])) || (!isset($_POST['email'])))
	{
		header('Location: registration.php');
		exit();
	}

    if(isset($_POST['email']))
    {
        $isRegistrationCorrect = true;
        $login = $_POST['login'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $emailB = filter_var($email, FILTER_SANITIZE_EMAIL);

        if ((strlen($login) < 3) || (strlen($login) > 20))
		{
			$isRegistrationCorrect = false;
			$_SESSION['e_login'] = "Login musi posiadać od 3 do 20 znaków";
            header('Location: registration.php');
		}

        if (ctype_alnum($login) == false)
		{
			$isRegistrationCorrect = false;
			$_SESSION['e_login'] = "Login może składać się tylko z liter i cyfr (bez polskich znaków)";
            header('Location: registration.php');
		}
		
		if ((filter_var($emailB, FILTER_VALIDATE_EMAIL) == false) || ($emailB != $email))
		{
			$isRegistrationCorrect = false;
			$_SESSION['e_email'] = "Podaj poprawny adres e-mail!";
            header('Location: registration.php');
		}

        if ((strlen($password) < 6) || (strlen($password) > 20))
		{
			$isRegistrationCorrect = false;
			$_SESSION['e_pass'] = "Hasło musi posiadać od 6 do 20 znaków";
            header('Location: registration.php');
		}

        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        require_once "connect.php";
		mysqli_report(MYSQLI_REPORT_STRICT);

        try 
		{
			$connection = new mysqli($host, $db_user, $db_password, $db_name);
			if ($connection->connect_errno!=0)
			{
				throw new Exception(mysqli_connect_errno());
                header('Location: registration.php');
			}
			else
			{
				if($result = $connection->query("SELECT id FROM users WHERE email='$email'"))
                {
                    $mailNumbers = $result->num_rows;

                    if($mailNumbers > 0)
                    {
                        $isRegistrationCorrect = false;
                        $_SESSION['e_email']="Istnieje już konto przypisane do tego adresu e-mail";
                        header('Location: registration.php');
                    }		
                } else 
                {
                    throw new Exception($connection->error);
                    header('Location: registration.php');
                }
				
				if ($result = $connection->query("SELECT id FROM users WHERE username='$login'"))
                {
                    $loginNumbers = $result->num_rows;
				
                    if($loginNumbers > 0)
				    {
					    $isRegistrationCorrect = false;
					    $_SESSION['e_login']="Istnieje już gracz o takim loginie. Podaj inny login.";
                        header('Location: registration.php');
				    }

                } else
                {
                    throw new Exception($connection->error);
                    header('Location: registration.php');
                }				
				
				if ($isRegistrationCorrect == true)
				{
					if ($connection->query("INSERT INTO users VALUES (NULL, '$login', '$password_hash', '$email')"))
					{
                        if(($connection->query("INSERT INTO incomes_category_assigned_to_users (user_id, name) SELECT u.id, i.name FROM incomes_category_default AS i, users AS u WHERE u.username = '$login'"))
                        && ($connection->query("INSERT INTO expenses_category_assigned_to_users (user_id, name) SELECT u.id, e.name FROM expenses_category_default AS e, users AS u WHERE u.username = '$login'"))
                        && ($connection->query("INSERT INTO payment_methods_assigned_to_users (user_id, name) SELECT u.id, p.name FROM payment_methods_default AS p, users AS u WHERE u.username = '$login'")))
                        {
                            $_SESSION['registerCorrect'] = true;
						    header('Location: index.php');
                        } 
                        else 
                        {
                            $connection->query("DELETE FROM users WHERE username = '$login'");
                            throw new Exception($connection->error);
                            header('Location: registration.php');                            
                        }
						
					} 
                    else
					{
						throw new Exception($connection->error);
                        header('Location: registration.php');
					}					
				}				
				$connection->close();
			}
			
		}
        catch(Exception $e)
		{
			echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności!</span>';
			echo '<br />Informacja developerska: '.$e;
		}

    }

?>