<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $score = 0;

    // Check answers for Question 1
    if ($_POST['q1'] === 'Paris') {
        $score++;
    }
    
    // Check answers for Question 2
    if ($_POST['q2'] === 'Mars') {
        $score++;
    }
    
    // Check answers for Question 3
    if ($_POST['q3'] === 'Blue Whale') {
        $score++;
    }

    // Create a database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "test";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Save user's score and name to the database
    $sql = "INSERT INTO questions (name, score) VALUES ('$name', $score)";

    if ($conn->query($sql) === TRUE) {
        echo "Your score has been saved!";

        // Retrieve and display user's score
        $user_id = $conn->insert_id; // Get the user's auto-generated ID
        
        $scoreQuery = "SELECT * FROM questions WHERE id = $user_id";
        $result = $conn->query($scoreQuery);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<h2>Your Score: " . $row['score'] . "</h2>";
            }
        } else {
            echo "<p>No scores found.</p>";
        }

        // Close the database connection
        $conn->close();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
