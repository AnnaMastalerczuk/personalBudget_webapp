<?php 
session_start();

if ((isset($_SESSION['isLogin'])) && ($_SESSION['isLogin']==true))
{
    header('Location: mainmenu.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Budżet osobisty - zaloguj się</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="loginStyle.css">
</head>

<body>
    <nav class="navbar">
        <div class="container-fluid border-bottom border-light ms-md-5 me-md-5">
            <h1 class="display-5 text-light">Budżet osobisty</h1>
            <h2 class="display-6 text-light">Miej swoje wydatki pod kontrolą</h2>
        </div>
    </nav>

    <section class="container mt-5 mb-5">
        <div class="row">
            <div class="col-lg-6 col-md-8 col-11 m-auto bg-light p-4">
                <h2 class="display-6 text-center">Zaloguj się</h2>
                <form action="login.php" method="post">
                    <div class="col mt-3">
                        <label class="form-label" for="login">Podaj login:</label>
                        <input class="form-control" type="text" placeholder="Login" id="login" name="login" required>
                    </div>
                    <div class="col mt-3">
                        <label class="form-label" for="password">Podaj hasło:</label>
                        <input class="form-control" type="password" placeholder="Password" id="password" name="password" required>
                    </div>
                    <div class="d-grid gap-2 mt-5">
                        <button class="btn btn-outline-dark">Zaloguj się</button>
                    </div>
                    <div class="col text-center mt-5">
                        <a href="registration.php" class="text-decoration-none text-dark">Nie masz konta?
                            <span>Zarejestruj się</span></a>
                    </div>
                    <?php
                    if (isset($_SESSION['error']))
                    {
                        echo '<br />'.$_SESSION['error'];
                        unset($_SESSION['error']);
                    }

                    ?>
                </form>

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