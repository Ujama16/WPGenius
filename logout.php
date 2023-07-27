<?php
session_start();
session_destroy();
header("Location: demoinedx.html");
exit();
?>
