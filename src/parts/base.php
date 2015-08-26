<?
namespace feedfilter;

?><!doctype html>
<html>
	<head>
		<title><?=$args['title']?></title>
		<link rel="icon" type="image/png" href="<?=WWW_ROOT?>/favicon.ico">
		<link rel="stylesheet" type="text/css" media="screen,projection" href="<?=WWW_ROOT?>/static/css/screen.css">
	</head>
	<body id="page-id-<?=$part?>">
		<div id="page-wrap">
			<header id="page-header">
				<h1 class="header-title"><a href="<?=get_url()?>"><?=TOOL_NAME?></a> <span><?=$args['title']?></span></h1>
			</header>
			<?php if (!empty($_SESSION['messages'])) : ?>
			<ol id="messages">
				<li><?=join($_SESSION['messages'], '</li><li>')?></li>
			</ol>
			<?php 
			unset($_SESSION['messages']);
			endif; 
			?>
			<div id="content">
				<?php require $template_part; ?>
			</div>
			<footer id="page-footer">
				<hr>
				<p><a href="<?=TOOL_URL?>"><?=TOOL_NAME?></a> <?=TOOL_VERSION?></p>
			</footer>
		</div>
	</body>
</html>