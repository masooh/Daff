<?php
require_once("File.php");

function get_connection()
{
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "moviedb";

// Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}

function insert_movie($file)
{

    $conn = get_connection();

    $sql = "INSERT INTO movies (source_path, filename, bytes)
    VALUES ('$file->source_path', '$file->filename', $file->bytes)";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}

?>
