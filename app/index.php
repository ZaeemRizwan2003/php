<?php
session_start();

// Check if the session for the admin is set
if (!isset($_SESSION['the_admin'])) {
    header("Location: ./login");
    exit();
}

include_once 'config/db.php';  // Including the database connection
include_once 'config/func.php';  // Including additional functions

$userID = $_SESSION['the_admin']['id'];

// Using prepared statements for security
$query = "SELECT * FROM users WHERE id = ?";
$stmt = $con->prepare($query);
$stmt->bind_param("i", $userID);  // Binding the userID parameter to prevent SQL injection
$stmt->execute();
$userInfo = $stmt->get_result()->fetch_assoc();  // Fetch the user information

$stmt->close();  // Close the statement

?><!doctype html>
<html lang="tr" dir="ltr">
<head>
    <?php require_once 'req/head.php'; ?>
    <?php require_once 'req/script.php'; ?>
</head>

<body class="">
    <div class="page">
        <div class="page-main">
            <?php require_once 'req/header.php'; ?>
            <?php
                if ($_SESSION['the_admin'] !== false) {
                    define("ADMIN", true);
                    $do = g('q');  // Get the query parameter 'q'

                    // Check if the file exists and include it; otherwise, load the default page
                    $pagePath = "pages/{$do}.php";
                    if (file_exists($pagePath)) {
                        require($pagePath);
                    } else {
                        require("pages/default.php");
                    }
                }
            ?>
        </div>
        <?php require_once 'req/footer.php'; ?>
    </div>
</body>
</html>
