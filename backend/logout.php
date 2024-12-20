<?php
session_start();
session_unset();
session_destroy();
header("Location: ../views/loginPAGE.php");
exit();
?>