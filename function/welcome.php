<?php
//session_start();
include('condition.php');
include("user_name.php");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>User Panel</title>
<link rel="stylesheet" type="text/css" href="../css/style.css" />
</head>
<body> 
<h2>Welcome to Royal Trader Group</h2>
	<div class="entry">
	<div id="content" class="narrowcolumn">
<h3>Hello <?php print $name; ?>,</h3>
</div>
<div id="content" class="narrowcolumn"><div class="comment odd alt thread-odd thread-alt depth-1"  style="width:90%">
<?php
print $message;
?>
</div>
<h3>
Director <br />
Royal Trader Group</h3>
</div>
</div>
</div>
</body>
</html>