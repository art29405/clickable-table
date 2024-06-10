<?php
// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Retrieve data from POST request
    $AppName = $_POST["AppName"];
    $header = $_POST["header"];
    $row = $_POST["row"];
    $data = $_POST["data"];
    $previousData = $_POST["previousData"] ?? '';
    $activeCheckboxState = isset($_POST['ActiveCheckboxState']) ? $_POST['ActiveCheckboxState'] : null;

    // Example of processing the data (you can modify this part based on your requirements)
    // Here, we'll simply echo the received data
    echo "AppName: $AppName\n";
    echo "header: $header\n";
    echo "Row ID: $row\n";
    echo "Received Data: $data\n";
    echo "Previous Data: $previousData\n";

    if (isset($_POST["AppName"]) && $_POST["AppName"] === "AppName") {
        $header = $_POST["header"] ?? '';
        $row = $_POST["row"] ?? '';
        $data = $_POST["data"] ?? '';
        $previousData = $_POST["previousData"] ?? '';

        // Validate the inputs
        if (!is_numeric($row) || empty($header) || empty($data)) {
            http_response_code(400); // Bad Request
            echo "Invalid input";
            exit;
        }

        // Map headers to database columns
        $headerMap = [
            "Column1" => "dbColumn1",
            "Column2" => "dbColumn2",
            "Column3" => "dbColumn3"
        ];

        if (array_key_exists($header, $headerMap)) {
            $column = $headerMap[$header];

            include 'config.php'; // Database connection config

            // Establish a database connection using MySQLi
            $con = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName_ipaddress);
            if (mysqli_connect_errno()) {
                http_response_code(500); // Internal Server Error
                echo "Failed to connect to the database: " . mysqli_connect_error();
                exit;
            }

            // Fetch current data from the database
            $stmt = $con->prepare("SELECT `$column` FROM `iptable` WHERE `no` = ?");
            if ($stmt) {
                $stmt->bind_param('i', $row);
                if ($stmt->execute()) {
                    $stmt->store_result();
                    if ($stmt->num_rows == 1) {
                        $stmt->bind_result($currentData);
                        $stmt->fetch();

                        // Compare current data with previousData
                        if ($currentData !== $previousData) {
                            http_response_code(409); // Conflict
                            echo "Data has been modified since retrieval. Please refresh and try again.";
                            exit;
                        }
                    } else {
                        http_response_code(404); // Not Found
                        echo "Record not found";
                        exit;
                    }
                } else {
                    http_response_code(500); // Internal Server Error
                    echo "Failed to execute the query";
                    exit;
                }
                $stmt->close();
            } else {
                http_response_code(500); // Internal Server Error
                echo "Failed to prepare the query";
                exit;
            }

            // Use prepared statement to update the data
            $stmt = $con->prepare("UPDATE `table` SET `$column` = ? WHERE `no` = ?"); // Assume 'no' is key
            if ($stmt) {
                $stmt->bind_param('si', $data, $row);
                if ($stmt->execute()) {
                    http_response_code(200); // OK
                } else {
                    http_response_code(500); // Internal Server Error
                    echo "Failed to execute the query";
                }
                $stmt->close();
            } else {
                http_response_code(500); // Internal Server Error
                echo "Failed to prepare the query";
            }

            // Close the database connection
            mysqli_close($con);
        } else {
            http_response_code(400); // Bad Request
            echo "Invalid header";
        }
    } elseif ($activeCheckboxState !== null) {
        // Process checkbox state change
        // Here, you would typically save the state to a database or perform other actions
        // For demonstration purposes, we'll just create a response message
        $response = array();
        $response['message'] = "Checkbox state saved successfully";
        $response['row'] = $row;
        $response['activeCheckboxState'] = $activeCheckboxState;
        echo json_encode($response);
    } else {
        http_response_code(400); // Bad Request
        echo "Invalid AppName or missing parameters";
    }

    // Check if it's a delete request
    if (isset($_POST["deleteRow"])) {
        // Include database configuration
        include 'config.php';

        // Extract row ID from the request
        $rowId = $_POST["rowId"];

        // Validate row ID
        if (!is_numeric($rowId)) {
            http_response_code(400); // Bad Request
            echo "Invalid row ID";
            exit;
        }

        // Establish a database connection using MySQLi
        $con = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);
        if (mysqli_connect_errno()) {
            http_response_code(500); // Internal Server Error
            echo "Failed to connect to the database: " . mysqli_connect_error();
            exit;
        }

        // Use prepared statement to delete the row
        $stmt = $con->prepare("DELETE FROM `tableName` WHERE `no` = ?");
        if ($stmt) {
            $stmt->bind_param('i', $rowId);

            // Execute the statement
            if ($stmt->execute()) {
                http_response_code(200); // OK
            } else {
                http_response_code(500); // Internal Server Error
                echo "Failed to delete the row";
            }

            $stmt->close();
        } else {
            http_response_code(500); // Internal Server Error
            echo "Failed to prepare the query";
        }

        // Close the database connection
        mysqli_close($con);

        // End the script after deleting the row
        exit;
    }




} else {
    // Respond with HTTP status code 405 (Method Not Allowed) if the request method is not POST
    http_response_code(405);
    echo "Method Not Allowed";
    
}

?>