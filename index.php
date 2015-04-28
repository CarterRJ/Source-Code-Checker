<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Ryan Carter - UCL Computer Science</title>
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/lighter.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="css/index.css">
</head>
<?php
include "login/db-info.php";
include_once 'js/js.php';
include 'header.php';
?>
	<div id="top" class="jumbotron">
		<div class="container">
			<h1>Source code checker/marker</h1>
			<h2>Helping YOU achieve YOUR goals since 1995</h2>
			<p>
				<a href="https://github.com/CarterRJ/3rd-Year-Project-Automatic-Marking/archive/master.zip" class="btn btn-primary btn-lg">Download <span
					class="glyphicon glyphicon-circle-arrow-down"></span></a>
			</p>
		</div>
		<!-- /.container -->
	</div>
	<!-- /.jumbotron -->


	<div class="container">
		<div class="pasteBox">
			<form action="upload.php" method="post">
				<label for="sourcecode">Source code:</label>
				<textarea class="pasteBox" id="sourcecode" name="code"></textarea>
				<input type="submit" value="Submit">
			</form>
		</div>
		<div class="uploadCode">
			<form action="upload.php" method="post" enctype="multipart/form-data">
				<label class="uploadCode" for="fileToUpload">OR select file
					to upload: </label> <input class="uploadCode" type="file"
					name="fileToUpload" id="fileToUpload"> <input
					class="uploadCode" type="submit" value="Upload File" name="submit">
			</form>
		</div>
	</div>
	<div class="container">
		<h3 id="introduction" class="subhead">Introduction</h3>
		<p style="font-size: 20px; text-align: center">
		This tool allows you to quickly and easily create and mark programming 
		exercises electronically.<br>Students can upload exercise solutions and the application automatically 
		produces feedback on both the validity of the program output and the formatting of the source code. </p>
		<h3 id="features" class="subhead">Features</h3>
		<div class="row benefits">
			<div class="col-md-4 col-sm-6 benefit">
				<div class="benefit-ball">
					<span class="glyphicon glyphicon-gbp"></span>
				</div>
				<h3>Cheap</h3>
				<p>
				<ul>

					<li>This project was built using only free tools and software</li>
					<li>This project is open-source made with open-source software/libraries. </li>
				</ul>

				</p>
			</div>
			<!-- /.benefit -->

			<div class="col-md-4 col-sm-6 benefit">
			<div class="benefit-ball">
					<span class="glyphicon glyphicon-education"></span>
				</div>
				<h3>A Great Teaching Tool</h3>
				<p>
				<ul>

					<li>Simple enough to be operated by schoolchildren.</li>
					<li>The code used to program the hovercraft is simple enough
						for schoolchildren.</li>
				</ul>
				</p>
			</div>
			<!-- /.benefit -->

				</p>
			</div>
			<!-- /.benefit -->
		</div>
		<!-- /.row -->
	</div>
	<!-- /.container -->

	<div class="container">
		<h3 id="faqs" class="subhead">Frequently Asked Questions</h3>
		<div class="row faqs">
			<p class="col-md-4 col-sm-6">
				<strong>Who is it for?</strong> <br> 
				Teaching programming not only includes program correctness but good 
				code structure; even correct code can be bad code.<br><br>
				First year CS undergraduates (and beginner programmers) benefit from 
				reliable and consistent evaluation of their source code, whilst 
				alleviating the tedious task, for professors and teaching assistants, 
				of marking trivial programs.
			</p>
			<p class="col-md-4 col-sm-6">
				<strong>Why did you create it?</strong> <br>Teaching staff find it tedious, 
				repetitive and uninteresting to mark and grade small trivial programs written 
				by undergraduates.<br><br>
				Students find the grading of coursework to be too subjective and 
				inconsistent. It takes too long to receive feedback on their 
				submissions and it is difficult to know what the teaching staff expect 
				prior to submission. Students' primary concern is receiving better 
				feedback and achieving better grades.<br>
			</p>
			<p class="col-md-4 col-sm-6">
				<strong>How can get my hands the application?</strong><br>
				Simply click on the "<a href="#top">download</a>" link at the <a
					href="#top">top of the page</a> to donwload the latest version
					of the application.
			</p>
			<p class="col-md-4 col-sm-6">
				<strong>How can I get involved and support the community?</strong><br>
				Visit the <a href="https://github.com/CarterRJ/3rd-Year-Project-Automatic-Marking">
				GitHub page</a> and contribute. Create a branch, an issue, a pull request, anything.
				Join the community forum to discuss improvements, solutions and keep up to date with the
				latest developments. We welcome your contributions!
			</p>
		</div>
		<!-- /.faqs -->
	</div>
	<!-- /.container -->

	<div class="container-alternate">
		<div class="container">
			<h3 id="about" class="subhead">About Us</h3>
			<div class="row about">
				<div class="col-md-10 col-md-offset-1 text-center">

					<p>
						Ryan Carter (<a href="http://carterrj.wordpress.com/">http://carterrj.wordpress.com</a>)
					</p>

					<p>
						<em>Supervisor: </em>Dr. Graham Roberts
					</p>
				</div>
				<!-- /.col-md-10 -->
			</div>
			<!-- /.row -->
		</div>
		<!-- /.container -->
	</div>
	<!-- /.container-alternate -->

	<footer>
		<div class="container clearfix">
			<p class="pull-left">Copyright &copy; 2015</p>
			<p class="pull-right">
				<a href="http://Twitter.com/Carter_RJ">@Carter_RJ</a>
			</p>
		</div>
		<!-- /.container -->
	</footer>
</body>
</html>
