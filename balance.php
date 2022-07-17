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
            <div class="nav-item dropdown">                
                <p class="nav-link dropdown-toggle text-light fs-5" id="navbarDropdown" role="button"
                    data-bs-toggle="dropdown" aria-expanded="false">Wybierz zakres dat</p>
                    <form action="balanceMenager.php" method="post" class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <input class="dropdown-item" type="submit" name="currentMonth" value="Bieżący miesiąc"></input>
                        <input class="dropdown-item" type="submit" name="previousMonth" value="Poprzedni miesiąc"></input>
                        <input class="dropdown-item" type="submit" name="currentYear" value="Bieżący rok"></input>
                        <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#exampleModal">Niestandardowy</button>                   
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
                            <form action="balanceMenager.php" method="post" class="modal-body">
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
            <div class="text-light mt-2">
                <p class="fs-5">Suma przychodów: <span>0.00</span></p>
                <p class="fs-5">Suma wydatków: <span>0.00</span></p>
                <p class="statement fs-5">Gratulacje. Świetnie zarządzasz finansami!</p>
                <p class="statement fs-5">Uważaj, wpadasz w długi!</p>
            </div>
            <div class="row">
                <div class="col-md-6 bg-light mb-3">
                    <h2 class="display-6">Bilans przychodów</h2>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Kategoria</th>
                                <th scope="col">Suma</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Wynagrodzenie</td>
                                <td>0.00</td>
                            </tr>
                            <tr>
                                <td>Odsetki bankowe</td>
                                <td>0.00</td>
                            </tr>
                            <tr>
                                <td>Sprzedaż na Allegro</td>
                                <td>0.00</td>
                            </tr>
                            <tr>
                                <td>Inne</td>
                                <td>0.00</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td>Suma</td>
                                <td>0.00</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="col-md-6 diagram bg-light mb-3">
                    <h2 class="display-6">Diagram przychodów</h2>
                    <div class="piechart m-3">
                        <img src="img/markus-spiske-jgOkEjVw-KM-unsplash.jpg" class="img-fluid" alt="">
                    </div>
                </div>
                <div class="col-md-6 bg-light mb-3">
                    <h2 class="display-6">Bilans wydatków</h2>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Kategoria</th>
                                <th scope="col">Suma</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Jedzenie</td>
                                <td>0.00</td>
                            </tr>
                            <tr>
                                <td>Mieszkanie</td>
                                <td>0.00</td>
                            </tr>
                            <tr>
                                <td>Transport</td>
                                <td>0.00</td>
                            </tr>
                            <tr>
                                <td>Telekomunikacja</td>
                                <td>0.00</td>
                            </tr>
                            <tr>
                                <td>Opieka zdrowotna</td>
                                <td>0.00</td>
                            </tr>
                            <tr>
                                <td>Ubrania</td>
                                <td>0.00</td>
                            </tr>
                            <tr>
                                <td>Higiena</td>
                                <td>0.00</td>
                            </tr>
                            <tr>
                                <td>Dzieci</td>
                                <td>0.00</td>
                            </tr>
                            <tr>
                                <td>Rozrywka</td>
                                <td>0.00</td>
                            </tr>
                            <tr>
                                <td>Wycieczka</td>
                                <td>0.00</td>
                            </tr>
                            <tr>
                                <td>Szkolenia</td>
                                <td>0.00</td>
                            </tr>
                            <tr>
                                <td>Książki</td>
                                <td>0.00</td>
                            </tr>
                            <tr>
                                <td>Oszczędności</td>
                                <td>0.00</td>
                            </tr>
                            <tr>
                                <td>Emerytura</td>
                                <td>0.00</td>
                            </tr>
                            <tr>
                                <td>Spłata długów</td>
                                <td>0.00</td>
                            </tr>
                            <tr>
                                <td>Darowizna</td>
                                <td>0.00</td>
                            </tr>
                            <tr>
                                <td>Inne wydatki</td>
                                <td>0.00</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td>Suma</td>
                                <td>0.00</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="col-md-6 diagram bg-light mb-3">
                    <h2 class="display-6">Diagram wydatków</h2>
                    <div class="piechart m-3"><img src="img/markus-spiske-jgOkEjVw-KM-unsplash.jpg" class="img-fluid"
                            alt=""></div>
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