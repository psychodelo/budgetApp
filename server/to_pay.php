<?php

session_start();
require_once 'functions.php';


if (!isset($_SESSION['loggedin'])) {

    header('Location:index');
}
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'www1595_orcio';
$DATABASE_PASS = 'LDzBDurQVn';
$DATABASE_NAME = 'www1595_dbbudget';
// Try and connect using the info above.
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
    // If there is an error with the connection, stop the script and display the error.
    die ('Failed to connect to MySQL: ' . mysqli_connect_error());

}

function sql($con, $form) {
    $sql = "select DISTINCT c.name as category, td.comment, td.date_transaction, td.money 
                from todolist as td 
                    join category as c on c.id_category=td.id_category
                    where  id_user = '".$_SESSION['id']."'  and form = '".$form." '
        ";
    if(isset($_GET['month'])) {
        if($_GET['month'] == 'styczen')
        {

            $sql.= 'and month(date_transaction) =  1 or month(date_transaction) = "styczen"  ';
        }
        if($_GET['month'] == 'luty')
        {
            $sql.= 'and month(date_transaction) = 2   or month(date_transaction) = "luty" ';
        }
        if($_GET['month'] == 'marzec')
        {
            $sql.= 'and month(date_transaction) = 3 or month(date_transaction) = "marzec" ';
        }
        if($_GET['month'] == 'kwiecien')
        {
            $sql.= 'and month(date_transaction) =4  or month(date_transaction) = "kwiecien"';
        }
        if($_GET['month'] == 'maj')
        {
            $sql.= 'and month(date_transaction) = 5 or month(date_transaction) = "maj" ';
        }
        if($_GET['month'] == 'czerwiec')
        {
            $sql.= 'and month(date_transaction) =  6  or month(date_transaction) = "czerwiec" ';
        }
        if($_GET['month'] == 'lipiec')
        {
            $sql.= 'and month(date_transaction) =  7  or month(date_transaction) = "lipiec" ';
        }
        if($_GET['month'] == 'sierpien')
        {
            $sql.= 'and month(date_transaction) = 8  or month(date_transaction) = "sierpien" ';
        }
        if($_GET['month'] == 'wrzesien')
        {
            $sql.= 'and month(date_transaction) =  9  or month(date_transaction) = "wrzesien" ';
        }
        if($_GET['month'] == 'pazdziernik')
        {
            $sql.= 'and month(date_transaction) = 10 or month(date_transaction) = "pazdziernik" ';
        }
        if($_GET['month'] == 'listopad')
        {
            $sql.= 'and month(date_transaction) = 11  or month(date_transaction) = "listopad" ';
        }
        if($_GET['month'] == 'grudzien')
        {
            $sql.= 'and month(date_transaction) = 12  or month(date_transaction) = "grudzzien" ';
        }
    }
    else{
        $sql.= "and month(curdate()) and year(curdate())";
    }
}
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

$result = $con->query($sql);
if($result->num_rows > 0) {
    echo "table id='trans' style='width:auto;'>";
    echo "<tr class='trans'>";
    echo "<th>Kategoria                      
                  </th>";
    echo "<th>Co                    
                  </th>";

    echo "<th>Data                       
                  </th>";
    echo "<th>Kwota                    
                  </th>";
    echo "<th>Opcje                    
                  </th>";

    while ($row = $result->fetch_assoc()) {

        echo "<form action='' method='post' role='form'>";

        echo "<tr >";
        echo "<td >" . $row["category"] . "</td>" . "";
        echo "<td >" . $row["comment"] . "</td>";
        echo "<td >" . $row["date_transaction"] . "</td>" . "";
        echo "<td>" . $row["money"] . "</td>";
        echo "<td>".  "Edit/Delete" . "</td>";



        echo "</tr>";
        echo "</form>";
    }
    echo "</table>";
}
else {
    echo "brak danych :(";
}


?>