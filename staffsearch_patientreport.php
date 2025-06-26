<?php
require_once 'dbconn.php';

if (isset($_GET['query'])) {
    $query = mysqli_real_escape_string($conn, $_GET['query']);

    $sql = "SELECT * FROM patients 
            WHERE CONCAT(first_name, ' ', last_name) LIKE '%$query%' 
            OR patient_id LIKE '%$query%' 
            LIMIT 10";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        echo "<ul class='list-group'>";
        while ($row = mysqli_fetch_assoc($result)) {
            $full_name = $row['last_name'] . ", " . $row['first_name'];
            echo "<li class='list-group-item d-flex justify-content-between align-items-center'>
                    $full_name
                    <a href='staffprint_singlepatient.php?patient_id={$row['patient_id']}' target='_blank' class='btn btn-sm btn-outline-primary'>
                        <i class='bi bi-printer'></i> Print
                    </a>
                  </li>";
        }
        echo "</ul>";
    } else {
        echo "<p class='text-danger'>No matching patients found.</p>";
    }
}
?>
