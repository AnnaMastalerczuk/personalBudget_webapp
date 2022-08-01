<?php
	session_start();

    if ((!isset($_SESSION['isLogin'])) || ($_SESSION['isLogin']==false))
{
    header('Location: index.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dodaj wydatek</title>
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
                <h2 class="display-6 text-center">Dodaj wydatek</h2>
                <form action="expenseAdd.php" method="post">
                    <div class="col mt-3">
                        <label class="form-label" for="amount">Podaj kwotę:</label>
                        <input class="form-control" type="number" placeholder="Kwota" id="amount" min="0" step="0.01" name="amount" required>
                    </div>

                    <?php
                    if (isset($_SESSION['e_amount'])){
                        echo '<div style="color:red">'.$_SESSION['e_amount'].'</div>';
				        unset($_SESSION['e_amount']);
                    }
                    ?>

                    <div class="col mt-3">
                        <label class="form-label" for="date">Podaj date:</label>
                        <input class="form-control" type="date" id="date" name="date" required>
                    </div>
                    <div class="col mt-3">
                        <label class="form-label" for="payment">Wybierz sposób płatności:</label>
                        <select class="form-select" aria-label="Default select example" name="payment" id="payment">
                            <option value="Cash">Gotówka</option>
                            <option value="Debit Card">Karta debetowa</option>
                            <option value="Credit Card">Karta kredytowa</option>
                        </select>
                    </div>
                    <div class="col mt-3">
                        <label class="form-label" for="category">Wybierz kategorię:</label>
                        <select class="form-select" aria-label="Default select example" name="category" id="category">
                            <option value="Transport">Transport</option>
                            <option value="Books">Książki</option>
                            <option value="Food">Jedzenie</option>
                            <option value="Apartments">Mieszkanie</option>                            
                            <option value="Telecommunication">Telekomunikacja</option>
                            <option value="Health">Opieka zdrowotna</option>
                            <option value="Clothes">Ubranie</option>
                            <option value="Hygiene">Higienia</option>
                            <option value="Kids">Dzieci</option>
                            <option value="Recreation">Rozrywka</option>
                            <option value="Trip">Wycieczka</option>                                                
                            <option value="Savings">Oszczędności</option>
                            <option value="For Retirement">Emerytura</option>
                            <option value="Debt Repayment">Spłata długów</option>
                            <option value="Gift">Darowizna</option>
                            <option value="Another">Inne wydatki</option>
                        </select>
                    </div>
                    <div class="col mt-3">
                        <label class="form-label" for="comment">Komentarz:</label>
                        <textarea class="form-control" id="comment" rows="3" name="comment"></textarea>
                    </div>

                    <?php
                    if (isset($_SESSION['e_comment'])){
                        echo '<div style="color:red">'.$_SESSION['e_comment'].'</div>';
				        unset($_SESSION['e_comment']);
                    }
                    ?>

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
const inputData = document.querySelector('#date');

function leadingZero(i) {
    return (i < 10)? "0"+i : i;
}

let nowData = new Date();
let year = nowData.getFullYear();
let month = leadingZero(nowData.getMonth()+1);
let day = leadingZero(nowData.getDate());

inputData.value = `${year}-${month}-${day}`;

btnCancel.addEventListener('click', function() {
    
    inputs.forEach(input => {
    input.value = "";
    });
    inputData.value = `${year}-${month}-${day}`;
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