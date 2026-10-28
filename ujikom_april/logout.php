<?php
require_once 'functions/helper.php';
session_unset();
session_destroy();
header("Location: login.php");
exit;
?>
