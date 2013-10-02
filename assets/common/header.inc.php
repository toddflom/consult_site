<!DOCTYPE html
  PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
    <meta http-equiv="Content-Type"
          content="text/html;charset=utf-8" />
          
          <!-- iPhone icon + chromeless browser -->
		<meta name="apple-mobile-web-app-capable" content="yes" />

		<!-- iPhone homescreen icon -->
		<link rel="apple-touch-icon" href="assets/images/touch-icon-iphone.png" />
		<link rel="apple-touch-icon" sizes="76x76" href="assets/images/touch-icon-ipad.png" />
		<link rel="apple-touch-icon" sizes="120x120" href="assets/images/touch-icon-iphone-retina.png" />
		<link rel="apple-touch-icon" sizes="152x152" href="assets/images/touch-icon-ipad-retina.png" />

		<!-- Chrome Frame -->
		<meta http-equiv="X-UA-Compatible" content="chrome=1" />
		
		
    <title><?php echo $page_title; ?></title>
<?php foreach ( $css_files as $css ): ?>
    <link rel="stylesheet" type="text/css" media="screen,projection"
          href="assets/css/<?php echo $css; ?>" />
<?php endforeach; ?>
</head>

<body class="">
	<div class="pagewrapper">
		<div id="header">
			<div id="header_wrapper">
				<a class="clLogo" href="#"></a>
				<div id="header_nav">
					<a class="nav_item projects_view" href="#">NEW PROJECTS</a>&nbsp;&nbsp;/&nbsp;&nbsp; 
					<a class="nav_item news_view" href="#">IN THE NEWS</a>&nbsp;&nbsp;/&nbsp;&nbsp; 
					<a class="nav_item thought_view" href="#">THOUGHT LEADERSHIP</a>
				</div>
			</div>
		</div>