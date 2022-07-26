<?php 
session_start();

if ((!isset($_SESSION['isLogin'])) || ($_SESSION['isLogin']==false))
{
    header('Location: index.php');
    exit();
}

?>


<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu główne</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <nav class="navbar">
        <div class="container-fluid border-bottom border-light ms-md-5 me-md-5">
            <h1 class="display-5 text-light">Budżet osobisty</h1>
        </div>
    </nav>

    <section class="container mt-5 mb-5">
        <div class="row ">
            <div class="col-lg-6 col-md-8 col-11 m-auto bg-light p-4">
                <h2 class="display-6 text-center">Menu</h2>
                <?php
                    if (isset($_SESSION['positionAdded'])){
                        echo '<div class="col text-center fs-5 mt-3">'.$_SESSION['positionAdded'].'</div>';
				        unset($_SESSION['positionAdded']);
                    }
                    ?>
                <div class="col text-center fs-5 mt-3">
                    <a href="incomes.php" class="text-decoration-none text-dark">Dodaj przychód</a>
                </div>
                <div class="col text-center fs-5 mt-3">
                    <a href="expenses.php" class="text-decoration-none text-dark">Dodaj wydatek</a>
                </div>
                <div class="col text-center fs-5 mt-3">
                    <a href="balance.php" class="text-decoration-none text-dark">Przeglądaj bilans</a>
                </div>
                <div class="col text-center fs-5 mt-3">
                    <a href="settings.php" class="text-decoration-none text-dark">Ustawienia</a>
                </div>
                <div class="col text-center fs-5 mt-3">
                    <a href="login.php" class="text-decoration-none text-dark">Wyloguj się</a>
                </div> 
            </div>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"
        integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"
        integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous">
    </script>

</body>

</html>