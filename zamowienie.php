<?php
    require_once "connect.php";

    //Create connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Getting pizzas
    $query_pizza = "SELECT * FROM pizza;";
    $pizzas = mysqli_query($conn, $query_pizza);

    // Getting sizes
    $query_sizes = "SELECT * FROM rozmiar;";
    $sizes = mysqli_query($conn, $query_sizes);

    // Getting dough
    $query_dough = "SELECT * FROM ciasto;";
    $dough = mysqli_query($conn, $query_dough); 
    
    // Getting additives
    $query_additives = "SELECT * FROM dodatki;";
    $additives = mysqli_query($conn, $query_additives);
    $additivesRows = mysqli_fetch_all($additives);
    

    // Getting waiter
    $query_waiter = "SELECT * FROM kelner;";
    $waiter = mysqli_query($conn, $query_waiter);

    function fillSelectWithAdditives($rows) {
        $result = "";

        foreach($rows as $row) {
            $result .= '<option value="' . $row[0] . '">' . $row[1] . ' ' . $row[2]. 'zl</option>';
        }

        return $result;
    }
    
?>
    
<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="UTF-8">
        <title>Pizzeria</title>
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
        <link href="https://use.fontawesome.com/releases/v5.0.8/css/all.css" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
            integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
            crossorigin="anonymous"></script>

        <script defer src="https://use.fontawesome.com/releases/v5.0.2/js/all.js"></script>
        <script src="http://code.jquery.com/jquery-3.0.0.js"></script>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="css/style.css">    

        <script>
            $(document).ready(function(e){
                //Variables
                var add = '<select class="form-control additional-field" name="dodatki"><?php echo fillSelectWithAdditives($additivesRows); ?></select>'
        
                //Add rows to the form
                $("#add").click(function(e){
                    $("#additional-additives").append(add);
                });

                //Remove rows from the form

                //Populate values from the first row
            });
        </script>
    </head>
    <body>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
              <!-- Brand and toggle get grouped for better mobile display -->
              <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                  <span class="sr-only">Toggle navigation</span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.html">Pizzeria</a>
              </div>
          
              <!-- Collect the nav links, forms, and other content for toggling -->
              <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="menu.php">Menu</a></li>
                    <li class="active"><a href="zamowienie.php">Formularz zamówieniowy<span class="sr-only">(current)</span></a></li>
                </ul>
              </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
          </nav>
        <section> 
        <form action="form.php" method="post">  


        <?php
            // render pizzas select
            if ($pizzas) {
                echo '<div class="form-group">';
                echo '<label for="pizza">Rodzaj pizzy:</label>';
                echo '<select class="form-control" id="pizza" name="pizza">';
                while($row = mysqli_fetch_array($pizzas)) {
                    echo "<option value='" . $row['id'] . "'>" . $row['nazwa'] . " " . $row['skladniki']. " " . $row['cena'] . "zl</option>";
                }
                echo '</select>';
                echo '</div>';
            }

            // render sizes select
            if ($sizes) {
                echo '<div class="form-group">';
                echo '<label for="size">Wybór rozmiaru:</label>';
                echo '<select class="form-control" id="size" name="rozmiar">';
                while($row = mysqli_fetch_array($sizes)) {
                    echo "<option value='" . $row['id'] . "'>" . $row['nazwa'] . " " . $row['srednica_cm']. "cm</option>";
                }
                echo '</select>';
                echo '</div>';
            }

            // render dough select
            if ($dough) {
                echo '<div class="form-group">';
                echo '<label for="dough">Wybór ciasta:</label>';
                echo '<select class="form-control" id="dough" name="ciasto">';
                while($row = mysqli_fetch_array($dough)) {
                    echo "<option value='" . $row['id'] . "'>" . $row['typ_ciasta'] . "</option>";
                }
                echo '</select>';
                echo '</div>';
            }

            // render additives select
            if ($additives) {
                echo '<div class="form-group">';
                echo '<label for="additives">Dodatki:</label>';
                echo '<select class="form-control" id="additives" name="dodatki">';
                echo fillSelectWithAdditives($additivesRows);
                echo '</select>';
                echo '</div>';
            }
           

        ?>
            <div id="additional-additives">
            </div>
            <div class="form-group">
                <a href="#" id="add">+</a>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="dodatki_ilosc" id="dodatki_ilosc" value="zwykle" checked>
                    <label class="form-check-label" for="dodatki_ilosc">
                        Zwykłe
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="dodatki_ilosc" id="dodatki_ilosc" value="podwojone">
                    <label class="form-check-label" for="dodatki_ilosc">
                        Podwojone
                    </label>
                </div>
            </div>
        
        <?php
            // render waiter select
            if ($waiter) {
                echo '<div class="form-group">';
                echo '<label for="waiter">Kelner:</label>';
                echo '<select class="form-control" id="waiter" name="kelner">';
                while($row = mysqli_fetch_array($waiter)) {
                    echo "<option value='" . $row['id'] . "'>" . $row['imie'] . " " . $row['nazwisko']. "</option>";
                }
                echo '</select>';
                echo '</div>';
            }


        ?>

            <div class="form-group">
                <label for="nr_stolika">Numer stolika:</label>
                <input type="number" name="nr_stolika" class="form-control" id="nr_stolika" placeholder="Wybierz numer stolika" min="1" max="10" required>
            </div>
            
            
            <button type="submit" name="submit" class="btn btn-primary">Złóż zamówienie</button>
        </form>

        </section>
        <!-- skrypt do obslugi cookies -->
        <script type="text/javascript" src="https://cookiegenerator.eu/cookie.js?position=bottom&amp;skin=cookielaw1&amp;animation=shake&amp;box_radius=8&amp;delay=0&amp;msg_color=f4e9e9&amp;msg=Ta%20strona%20korzysta%20z%20ciasteczek%2C%20aby%20%C5%9Bwiadczy%C4%87%20us%C5%82ugi%20na%20najwy%C5%BCszym%20poziomie.%20Dalsze%20korzystanie%20ze%20strony%20oznacza%2C%20%C5%BCe%20zgadzasz%20si%C4%99%20na%20ich%20u%C5%BCycie.&amp;accept_text=Zgoda.&amp;accept_radius=5">
        </script>
    </body>
</html>
