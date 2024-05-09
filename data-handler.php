<?php
// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve data from POST request
    $data = $_POST["data"];
    $row = $_POST["row"];
    
    // Example of processing the data (you can modify this part based on your requirements)
    // Here, we'll simply echo the received data
    echo "Received Data: $data\n";
    echo "Row ID: $row\n";
    
    // You can perform database operations, file writing, or any other desired actions here
    // For example, you can update the database with the received data
    
    // Respond with HTTP status code 200 (OK) to indicate successful processing
    http_response_code(200);
} else {
    // Respond with HTTP status code 405 (Method Not Allowed) if the request method is not POST
    http_response_code(405);
    echo "Method Not Allowed";
}
?>
