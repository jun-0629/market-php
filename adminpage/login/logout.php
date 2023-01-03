<?php
	session_start();

	unset($_SESSION['admin']);
	die("<script>location.href='login.php';</script>");
?>