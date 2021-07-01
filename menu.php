<?php
    require_once "connect.php";

     //Create connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);

     // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $pizza_query = "SELECT * FROM pizza;";
    $pizzas = mysqli_query($conn, $pizza_query);


    function calculate($con, $id_pizza, $id_rozmiar){
        $pizza_price_query = "SELECT calculate_pizza_price(". $id_pizza . "," . $id_rozmiar .");";
        $pizza_price = mysqli_query($con, $pizza_price_query);

        echo $pizza_price;
        return mysqli_fetch_array($pizza_price)[0];
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
                  <li class="active"><a href="menu.php">Menu<span class="sr-only">(current)</span></a></li>
                  <li><a href="zamowienie.php">Formularz zamówieniowy</a></li>
                </ul>
              </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
          </nav>
        <section class="menu">
            <table class="table">
                <thead>
                    <tr>
                    <th scope="col">Nazwa</th>
                    <th scope="col">Składniki</th>
                    <th scope="col">Mała(30cm)</th>
                    <th scope="col">Średnia(40cm)</th>
                    <th scope="col">Duża(50cm)</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    while($row = mysqli_fetch_array($pizzas)) {
                        echo "<tr>";
                        echo "<th>" . $row['nazwa'] . "</th>";
                        echo "<td>" . $row['skladniki'] . "</td>";
                        echo "<td>" . $row['cena'] . "zł</td>";
                        echo "<td>" . calculate($conn, $row['id'], 2). "zł</td>";
                        echo "<td>" . calculate($conn, $row['id'], 3). "zł</td>";

                        echo "</tr>";
                        //= "<option value='" . $row['id'] . "'>" . $row['nazwa'] . " " . $row['skladniki']. " " . $row['cena'] . "zl</option>"; // Print a single column data
                    }
                ?>
            
                </tbody>
                </table>
        </section>    
        <!-- skrypt do obslugi cookies -->
        <script type="text/javascript" src="https://cookiegenerator.eu/cookie.js?position=bottom&amp;skin=cookielaw1&amp;animation=shake&amp;box_radius=8&amp;delay=0&amp;msg_color=f4e9e9&amp;msg=Ta%20strona%20korzysta%20z%20ciasteczek%2C%20aby%20%C5%9Bwiadczy%C4%87%20us%C5%82ugi%20na%20najwy%C5%BCszym%20poziomie.%20Dalsze%20korzystanie%20ze%20strony%20oznacza%2C%20%C5%BCe%20zgadzasz%20si%C4%99%20na%20ich%20u%C5%BCycie.&amp;accept_text=Zgoda.&amp;accept_radius=5">
        </script>
    </body>
</html>