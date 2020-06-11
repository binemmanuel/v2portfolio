<?php
/**
 * This script is responsible for
 * establishing a connection to the
 * database.
 * 
 * @package Bin Emmanuel
 * @author  Bin Emmanuel https://github.com/binemmanuel
 * @license GNU GENERAL PUBLIC LICENSE https://www.gnu.org/licenses/
 * @link    https://github.com/dragon-programming/forum
 * 
 * @version	1.0
 */
try {
	// Enable SQL error reporting.
	mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

	// Establish the connection.
	$conn = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME);

	// Set character ser to UTF-8.
	$conn->set_charset(CHARSET);

} catch (\mysqli_sql_exception  $e) {
	// Check if there was an error when trying to establish the connection.
	// if ($conn->connect_error)
    // trigger_error($conn->connect_error, E_USER_WARNING);
    ?>
    <pre>
    	<?php throw new \mysqli_sql_exception($e->getMessage(), $e->getCode()) // Throw error message. ?>
    	
    </pre>
	<?php
}