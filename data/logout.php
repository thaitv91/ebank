<?php
session_start();
ini_set('display_errors','off');
include("condition.php");
session_unset();
echo "<script type=\"text/javascript\">";
echo "window.location = \"index.php\"";
echo "</script>";
