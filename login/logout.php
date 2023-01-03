<?php
	session_start();

	unset($_SESSION['member']);
	unset($_SESSION['password_revalidation_token']);
	die("<script>location.href='../index.php';</script>");
?>