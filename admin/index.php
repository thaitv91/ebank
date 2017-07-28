<?php
ini_set("display_errors",'off');
session_start();
include("../config.php");
if($_SESSION['dennisn_admin_login'] != 1)
{
	include("login.php");
	die;
}
?>	
<!--<script type="text/javascript">
if(window.console.firebug)  { 
     document.body.innerHTML = "PLEASE DO NOT USE FIREBUG" 
};
</script>-->
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Ebank.Tv</title>

<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="font-awesome/css/font-awesome.css" rel="stylesheet">

<!-- Morris -->
<link href="css/plugins/morris/morris-0.4.3.min.css" rel="stylesheet">

<!-- Gritter -->
<link href="js/plugins/gritter/jquery.gritter.css" rel="stylesheet">

<link href="css/animate.css" rel="stylesheet">
<link href="css/style.css" rel="stylesheet">
<link href="css/plugins/datapicker/datepicker3.css" rel="stylesheet">
<script src="js/jquery-2.1.1.js"></script>
<script src="js/plugins/datapicker/bootstrap-datepicker.js"></script>
<script type="text/javascript">
var _gNow = new Date();
</script>
</head>
<body>
<div id="wrapper">
	<?php include "left.php"; ?>
	<div id="page-wrapper" class="gray-bg dashbard-1">
		<?php include "top.php"; ?>
		<?php include "middle.php"; ?>
	</div>
</div>

<!-- Mainly scripts -->

<script src="js/bootstrap.min.js"></script>
<script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

<!-- Flot -->
<script src="js/plugins/flot/jquery.flot.js"></script>
<script src="js/plugins/flot/jquery.flot.tooltip.min.js"></script>
<script src="js/plugins/flot/jquery.flot.spline.js"></script>
<script src="js/plugins/flot/jquery.flot.resize.js"></script>
<script src="js/plugins/flot/jquery.flot.pie.js"></script>

<!-- Peity -->
<script src="js/plugins/peity/jquery.peity.min.js"></script>
<script src="js/demo/peity-demo.js"></script>

<!-- Custom and plugin javascript -->
<script src="js/inspinia.js"></script>
<script src="js/plugins/pace/pace.min.js"></script>

<!-- jQuery UI -->
<script src="js/plugins/jquery-ui/jquery-ui.min.js"></script>

<!-- GITTER -->
<script src="js/plugins/gritter/jquery.gritter.min.js"></script>

<!-- EayPIE -->
<script src="js/plugins/easypiechart/jquery.easypiechart.js"></script>

<!-- Sparkline -->
<script src="js/plugins/sparkline/jquery.sparkline.min.js"></script>

<!-- Sparkline demo data  -->
<script src="js/demo/sparkline-demo.js"></script>

<!-- ChartJS-->
<script src="js/plugins/chartJs/Chart.min.js"></script>
<script src="/js/tinymce/tinymce.min.js"></script>
<script>
$(document).ready(function() {
    tinymce.init({
        selector: '.text-editor',
        height: 500,
        plugins: [
            'advlist autolink autosave autoresize link image lists charmap print preview hr anchor pagebreak spellchecker',
            'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking',
            'table contextmenu directionality emoticons template textcolor paste fullpage textcolor colorpicker textpattern'
        ],

        toolbar1: 'newdocument fullpage | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | styleselect formatselect fontselect fontsizeselect',
        toolbar2: 'cut copy paste | searchreplace | bullist numlist | outdent indent blockquote | undo redo | link unlink anchor image media code | insertdatetime preview | forecolor backcolor',
        toolbar3: 'table | hr removeformat | subscript superscript | charmap emoticons | print fullscreen | ltr rtl | spellchecker | visualchars visualblocks nonbreaking template pagebreak restoredraft',

        menubar: false,
        toolbar_items_size: 'small',
        style_formats: [{
            title: 'Bold text',
            inline: 'b'
        }, {
            title: 'Red text',
            inline: 'span',
            styles: {
                color: '#ff0000'
            }
        }, {
            title: 'Red header',
            block: 'h1',
            styles: {
                color: '#ff0000'
            }
        }, {
            title: 'Example 1',
            inline: 'span',
            classes: 'example1'
        }, {
            title: 'Example 2',
            inline: 'span',
            classes: 'example2'
        }, {
            title: 'Table styles'
        }, {
            title: 'Table row 1',
            selector: 'tr',
            classes: 'tablerow1'
        }],

        templates: [{
            title: 'Test template 1',
            content: 'Test 1'
        }, {
            title: 'Test template 2',
            content: 'Test 2'
        }],
        content_css: [
            '//fast.fonts.net/cssapi/e6dc9b99-64fe-4292-ad98-6974f93cd2a2.css',
            '//www.tinymce.com/css/codepen.min.css'
        ],
//		external_filemanager_path:"/filemanager/",
//		filemanager_title:"Responsive Filemanager" ,
//		external_plugins: { "filemanager" : "/filemanager/plugin.min.js"}
    });
});
</script>	
<script>
	$(document).ready(function() {
		setTimeout(function() {
			$.gritter.add({
				title: 'You have <?=inbox_message($id);?> new messages',
				text: 'Go to <a href="index.php?page=inbox" class="text-warning">Mailbox</a> to see who wrote to you.',
				time: 2000
			});
		}, 2000);


		$('.chart').easyPieChart({
			barColor: '#f8ac59',
//                scaleColor: false,
			scaleLength: 5,
			lineWidth: 4,
			size: 80
		});

		$('.chart2').easyPieChart({
			barColor: '#1c84c6',
			scaleLength: 5,
			lineWidth: 4,
			size: 80
		});

		var data1 = [
			[0,4],[1,8],[2,5],[3,10],[4,4],[5,16],[6,5],[7,11],[8,6],[9,11],[10,30],[11,10],[12,13],[13,4],[14,3],[15,3],[16,6]
		];
		var data2 = [
			[0,1],[1,0],[2,2],[3,0],[4,1],[5,3],[6,1],[7,5],[8,2],[9,3],[10,2],[11,1],[12,0],[13,2],[14,8],[15,0],[16,0]
		];
		$("#flot-dashboard-chart").length && $.plot($("#flot-dashboard-chart"), [
			data1, data2
		],
				{
					series: {
						lines: {
							show: false,
							fill: true
						},
						splines: {
							show: true,
							tension: 0.4,
							lineWidth: 1,
							fill: 0.4
						},
						points: {
							radius: 0,
							show: true
						},
						shadowSize: 2
					},
					grid: {
						hoverable: true,
						clickable: true,
						tickColor: "#d5d5d5",
						borderWidth: 1,
						color: '#d5d5d5'
					},
					colors: ["#1ab394", "#464f88"],
					xaxis:{
					},
					yaxis: {
						ticks: 4
					},
					tooltip: false
				}
		);

		var doughnutData = [
			{
				value: 300,
				color: "#a3e1d4",
				highlight: "#1ab394",
				label: "App"
			},
			{
				value: 50,
				color: "#dedede",
				highlight: "#1ab394",
				label: "Software"
			},
			{
				value: 100,
				color: "#b5b8cf",
				highlight: "#1ab394",
				label: "Laptop"
			}
		];

		var doughnutOptions = {
			segmentShowStroke: true,
			segmentStrokeColor: "#fff",
			segmentStrokeWidth: 2,
			percentageInnerCutout: 45, // This is 0 for Pie charts
			animationSteps: 100,
			animationEasing: "easeOutBounce",
			animateRotate: true,
			animateScale: false,
		};

		var ctx = document.getElementById("doughnutChart").getContext("2d");
		var DoughnutChart = new Chart(ctx).Doughnut(doughnutData, doughnutOptions);

		var polarData = [
			{
				value: 300,
				color: "#a3e1d4",
				highlight: "#1ab394",
				label: "App"
			},
			{
				value: 140,
				color: "#dedede",
				highlight: "#1ab394",
				label: "Software"
			},
			{
				value: 200,
				color: "#b5b8cf",
				highlight: "#1ab394",
				label: "Laptop"
			}
		];

		var polarOptions = {
			scaleShowLabelBackdrop: true,
			scaleBackdropColor: "rgba(255,255,255,0.75)",
			scaleBeginAtZero: true,
			scaleBackdropPaddingY: 1,
			scaleBackdropPaddingX: 1,
			scaleShowLine: true,
			segmentShowStroke: true,
			segmentStrokeColor: "#fff",
			segmentStrokeWidth: 2,
			animationSteps: 100,
			animationEasing: "easeOutBounce",
			animateRotate: true,
			animateScale: false,
		};
		var ctx = document.getElementById("polarChart").getContext("2d");
		var Polarchart = new Chart(ctx).PolarArea(polarData, polarOptions);

	});
</script>
</body>
</html>