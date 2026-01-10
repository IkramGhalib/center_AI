<?php
function authenticate($permission = 'can_view')
{
    if (!isset($_SESSION['employee'])) {
        header("Location: login.php");
        exit;
    }

    if (
        !isset($_SESSION['employee'][$permission]) ||
        $_SESSION['employee'][$permission] != 1
    ) {
        header("Location: unauthorized.php");
        exit;
    }
}
