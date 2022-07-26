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
    <title>Dodaj przychód</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <nav class="navbar">
        <div class="container-fluid border-bottom border-light ms-md-5 me-md-5">
            <h1 class="display-5 text-light">Budżet osobisty</h1>
            <div class="text-light fs-5"><a class="nav-link text-light" href="mainmenu.php">Menu</a></div>
        </div>
    </nav>

    <section class="container mt-5 mb-5">
        <div class="row ">
            <div class="col-lg-6 col-md-8 col-11 m-auto bg-light p-4">
                <h2 class="display-6 text-center">Dodaj przychód</h2>
                <form action="incomeAdd.php" method="post">
                    <div class="col mt-3">
                        <label class="form-label" for="amount">Podaj kwotę:</label>
                        <input class="form-control" type="number" placeholder="Kwota" id="amount" min="0" step="0.01" name="amount" required>

                        <?php
                    if (isset($_SESSION['e_amount'])){
                        echo '<div style="color:red">'.$_SESSION['e_amount'].'</div>';
				        unset($_SESSION['e_amount']);
                    }
                    ?>

                    </div>
                    <div class="col mt-3">
                        <label class="form-label" for="date">Podaj date:</label>
                        <input class="form-control" type="date" id="date" name="date" required>
                    </div>
                    <div class="col mt-3">
                        <p>Wybierz kategorię:</p>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="Salary"
                                value="Salary" checked>
                            <label class="form-check-label" for="Salary">Wynagrodzenie</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="Interest"
                                value="Interest">
                            <label class="form-check-label" for="Interest">Odsetki bankowe</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="Allegro" value="Allegro">
                            <label class="form-check-label" for="Allegro">Sprzedaż na Allegro</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="Another"
                                value="Another">
                            <label class="form-check-label" for="Another">Inne</label>
                        </div>
                    </div>
                    <div class="col mt-3">
                        <label class="form-label" for="comment">Komentarz:</label>
                        <textarea class="form-control" id="comment" rows="3" name="comment"></textarea>

                        <?php
                    if (isset($_SESSION['e_comment'])){
                        echo '<div style="color:red">'.$_SESSION['e_comment'].'</div>';
				        unset($_SESSION['e_comment']);
                    }
                    ?>

                    </div>
                    <div class="d-grid gap-2 mt-5">
                        <button class="btn btn-outline-dark">Dodaj</button>
                        <button type="button" class="btn btn-outline-dark" id="btnCancel">Anuluj</button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <script>

const btnCancel = document.querySelector('#btnCancel');
const textA = document.querySelector('#comment');
const inputs = document.querySelectorAll('input');

btnCancel.addEventListener('click', function() {
    
    inputs.forEach(input => {
    input.value = "";
    });

    textA.value = "";
});

    </script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"
    integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"
    integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous">
    </script>

</body>

</html>