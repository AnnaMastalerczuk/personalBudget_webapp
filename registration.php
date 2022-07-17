<?php
	session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zarejestruj się</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">   
    <link rel="stylesheet" href="registration.css">
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
                <h2 class="display-6 text-center">Zarejestruj się</h2>
                <form action="regist.php" method="post">
                    <div class="col mt-3">
                        <label class="form-label" for="login">Podaj login:</label>
                        <input class="form-control" type="text" placeholder="Login" id="login" name="login" required>
                    </div>

                    <?php
                    if (isset($_SESSION['e_login'])){
                        echo '<div style="color:red">'.$_SESSION['e_login'].'</div>';
				        unset($_SESSION['e_login']);
                    }
                    ?>

                    <div class="col mt-3">
                        <label class="form-label" for="password">Podaj hasło:</label>
                        <div class="input-group mb-3">
                        <input class="form-control" type="password" placeholder="Password" id="password" name="password" required>
                        <i class="input-group-text bi bi-eye-slash" id="togglePassword"></i>
                        </div>                        
                    </div>

                    <?php
                    if (isset($_SESSION['e_pass'])){
                        echo '<div style="color:red">'.$_SESSION['e_pass'].'</div>';
				        unset($_SESSION['e_pass']);
                    }
                    ?>

                    <div class="col mt-3">
                        <label class="form-label" for="email">Podaj mail:</label>
                        <input class="form-control" type="email" placeholder="E-mail" id="email" name="email" required>
                    </div>

                    <?php
                    if (isset($_SESSION['e_email'])){
                        echo '<div style="color:red">'.$_SESSION['e_email'].'</div>';
				        unset($_SESSION['e_email']);
                    }
                    ?>

                    <!-- <div class="col mt-3">
                        <label class="form-label" for="surname">Podaj nazwisko:</label>
                        <input class="form-control" type="text" placeholder="Nazwisko" id="surname" required>
                    </div> -->
                    <div class="d-grid gap-2 mt-5">
                        <button class="btn btn-outline-dark">Zarejestruj się</button>
                    </div>
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
    <script src="script.js"></script>
</body>

</html>