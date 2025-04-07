<?php
include 'db.php';

$sql = "SELECT p.PropertyID, p.Address, p.Type, p.Size, p.Price, p.Status, p.ImageURL
        FROM property p
        WHERE p.Status = 'For Rent' OR p.Status = 'For Sale'";
$result = $conn->query($sql);

include 'home.php';
?>