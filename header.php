<?php
$siteroot = "/Source-Code-Checker/";
echo '<body>
		
	<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse"
				data-target=".navbar-ex1-collapse">
				<span class="icon-bar"></span> <span class="icon-bar"></span> <span
					class="icon-bar"></span>
			</button>
			<a class="navbar-brand nav-link" href="'.$siteroot.'#top">Ryan Carter - Source
				Code Checker</a>
		</div>
		<!-- /.navbar-header -->

		<div class="collapse navbar-collapse navbar-ex1-collapse">
			<ul class="nav navbar-nav navbar-right">
				<li><a href="'.$siteroot.'#features" class="nav-link">Features</a></li>
				<li><a href="'.$siteroot.'#faqs" class="nav-link">FAQs</a></li>
				<li><a href="'.$siteroot.'#about" class="nav-link">About</a></li>';
if (isset($_SESSION['Admin'])) {
	echo '<li><a href="'.$siteroot.'login/logout.php"><strong>Log out</strong></a></li>';
} else {
	
	echo '<li><a href="'.$siteroot.'login/index.php"><strong>Log in</strong></a></li>';
}
echo '
			</ul>
		</div>
		<!-- /.navbar-collapse -->
	</div>
	<!-- /.container --> </nav>
	<!-- /.navbar -->
	<div id="main">';

?>