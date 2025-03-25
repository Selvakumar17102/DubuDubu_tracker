<?php
include("../include/connection.php");

if (isset($_POST['search'])) {
    $search = $conn->real_escape_string($_POST['search']);
    $query = "SELECT oemail FROM employee WHERE oemail LIKE '%$search%'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='email-option'>" . $row['oemail'] . "</div>";
        }
    } else {
        echo "<div class='email-option'>No results found</div>";
    }
}
?>
