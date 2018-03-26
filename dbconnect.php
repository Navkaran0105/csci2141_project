

<?php
// file taken directly from https://teamtreehouse.com/community/how-do-you-store-your-mysql-user-credentials-in-a-secure-way

// Define connection as a static variable, to avoid connecting more than once 
static $connection;

function db_connect() {
    
    // Try and connect to the database, if a connection has not been established yet
    if(!isset($connection)) {
        // Load configuration as an array. Use the actual location of your configuration file
        $config = parse_ini_file('config.ini'); 
        $connection = mysqli_connect($config['servername'],$config['username'],$config['password'],$config['dbname']);
    }

        // If connection was not successful, handle the error
    if($connection === false) {
            // Handle error - notify administrator, log to a file, show an error screen, etc.
        return mysqli_connect_error(); 
    }
    return $connection;
}

// Connect to the database
$connection = db_connect();

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// prints a table with more than two columns to an option list, choosing the second column
function printMultiQueryToOptionList($query) {

    $connection = db_connect();
    // http://php.net/manual/en/mysqli-result.fetch-row.php
    if ($result = mysqli_query($connection, $query)) {

    /* fetch associative array */
    
    while ($row = mysqli_fetch_row($result)) {
        printf ("<option value='%s' name='%s'>%s</option>", $row[0], $row[0], $row[1]);
    }
    

    /* free result set */
    mysqli_free_result($result);
    }


    $connection = db_connect();
    if ($stmt = $connection->prepare($query)) {

    /* execute statement */
    $stmt->execute();

    /* bind result variables */
    $stmt->bind_result($name, $code);

    /* fetch values */
    while ($stmt->fetch()) {
        
    }

    /* close statement */
    $stmt->close();
} else {echo "Error: " . $connection->error;}
}

function printQueryToTableWithHeaders($query, $table) {
    $connection = db_connect();
    // http://php.net/manual/en/mysqli-result.fetch-row.php
    if ($result = mysqli_query($connection, "show columns from " . $table)) {

    /* fetch associative array */
    echo("<tr>");
    while ($row = mysqli_fetch_row($result)) {
        
            for($i = 0; $i < count($row); $i++) {
                if (($i % 6) == 0) echo "<td>" . $row[$i] . "</td>";
            }
        
    }
    echo("</tr>");

    /* free result set */
    mysqli_free_result($result);

    printQueryToTable($query);
    }
}
function printQueryToTable($query) {
    $connection = db_connect();
    // http://php.net/manual/en/mysqli-result.fetch-row.php
    if ($result = mysqli_query($connection, $query)) {

    /* fetch associative array */
    
    while ($row = mysqli_fetch_row($result)) {
        echo("<tr>");
            for($i = 0; $i < count($row); $i++) {
                echo "<td>" . $row[$i] . "</td>";
            }
        echo("</tr>");
    }
    

    /* free result set */
    mysqli_free_result($result);
    }
}


?> 

