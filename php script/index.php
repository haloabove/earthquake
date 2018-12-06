<?php
$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "mainDB";

if(isset($_POST["Name"]) && isset($_POST["Description"]) &&  isset($_POST["Price"])) { 
    $name = $_POST['Name'];
    $description = $_POST['Description'];
    $price = $_POST['Price'];
}

try {

    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // prepare sql and bind parameters
    $stmt = $conn->prepare("INSERT INTO Products (name, description, price) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $description, $price);

    $stmt->execute();

    if(mysql_query($stmt)){
        echo "Registered";
    }else{
        echo "Error!". mysql_error();
    }
}
catch(PDOException $e)
    {
    echo "Error: " . $e->getMessage();
    }
$conn = null;
?>