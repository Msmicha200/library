<!DOCTYPE html>
<html lang="en" class="">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="template/css/global.css">
	<link rel="stylesheet" href="template/css/pdfModal.css">
	<?php if ($_SERVER['REQUEST_URI'] == "/main"): ?>
		<title>Library</title>
		<link rel="stylesheet" href="template/css/main.css">
		<link rel="stylesheet" href="/template/css/uvmSearchSelect.css">
		<link rel="stylesheet" href="/template/css/uvmModal.css">
	<?php elseif (preg_match("(book)", $_SERVER['REQUEST_URI'])): ?>
		<title>Book</title>
		<link rel="stylesheet" href="template/css/book.css">
		<link rel="stylesheet" href="/template/css/uvmModal.css">
	<?php elseif ($_SERVER['REQUEST_URI'] == "/user"): ?>
		<title>User</title>
		<link rel="stylesheet" href="template/css/main.css">
	<?php elseif (preg_match("(resetPassword)", $_SERVER['REQUEST_URI'])): ?>
		<title>Reset Password</title>
		<link rel="stylesheet" href="/template/css/resetPassword.css">
	<?php elseif ($_SERVER['REQUEST_URI'] == "/login"): ?>
		<title>Login</title>
		<link rel="stylesheet" href="template/css/login.css">
	<?php elseif ($_SERVER['REQUEST_URI'] == "/admin"): ?>
		<title>Admin</title>
		<link rel="stylesheet" href="template/css/admin.css">
		<link rel="stylesheet" href="/template/css/uvmSearchSelect.css">
	<?php endif ?>
</head>
<body>