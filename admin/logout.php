<?php
/**
 * Admin Logout Handler
 * Destroys session and redirects to admin login
 */
session_start();
session_destroy();
header('Location: index.php');
exit;

