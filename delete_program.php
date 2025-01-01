<?php
require 'connect.php';

if (isset($_GET['program_id'])) {
    $program_id = $_GET['program_id'];

    $deleteSql = "DELETE FROM reduction_programs WHERE program_id = ?";
    $stmt = $conn->prepare($deleteSql);
    $stmt->bind_param("i", $program_id);
    $stmt->execute();
    $stmt->close();
}

header("Location: manage_programs.php");
exit;
