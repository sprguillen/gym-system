<?php

$servername = 'localhost';
$username = 'root';
$password = '';
$database = 'gym_master';

$conn = new mysqli($servername, $username, $password, $database);
$time = time();
$current_date = date('Y-m-d');

$log_file = fopen($_SERVER['DOCUMENT_ROOT'] . '/gym-system/cron/log/' . $current_date . '-' . $time . '-log.txt', 'w');

if ($conn->connect_errno) {
	// die('Connection to ' . $servername . ' failed: ' . $conn->connect_error);
	fwrite($log_file, 'Connection to ' . $servername . ' failed: ' . $conn->connect_error);
}

$sql = "UPDATE membership SET status='Inactive' WHERE date_expired < '" . $current_date . "' AND status='Active'";

// $log_file = fopen('/log/' . $current_date . '-log.text', 'w');
if ($conn->query($sql) === TRUE) {
	if ($conn->affected_rows > 0) {
		fwrite($log_file, 'Membership updated successfully.');
	} else {
		fwrite($log_file, 'There is no expired member today.');
	}
} else {
	fwrite($log_file, 'Error updating membership: ' . $conn->error);
}

fclose($log_file);
$conn->close();
?>