<?php
// filepath: helpers.php
function getAlert(): ?array {
    $alert = $_SESSION['alert'] ?? null;
    unset($_SESSION['alert']);
    return $alert;
}
?>