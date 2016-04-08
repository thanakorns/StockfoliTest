<?php 
require_once "Graph.php";
	$myGraph = new Graph();
	$symbol = 'WIKI/FB';
	$myGraph->graphFiveDays($symbol);
	
$br_obj = $myGraph->br_obj;
$br_labels = array_reverse($myGraph->br_label_arr); //reverse the data
$br_values = array_reverse($myGraph->br_value_arr); //reverse the data
$br_labels = implode('","', $br_labels); //comma sep with double quotes around each
$br_values = implode(", ", $br_values); //comma sep
?>

<!doctype html>
<html>
	<head>
		<title> <?php echo '"'.$br_obj['name'].'"'; ?> </title>
		<script src="Chart.js"></script>
	</head>
	<body>
		<h1> <?php echo '"'.$br_obj['name'].'"'; ?> </h1>
		<div style="width:90%">
			<div>
				<canvas id="canvas" height="400" width="800"></canvas>
			</div>
		</div>


	<script>
		var lineChartData = {
			labels : [<?php echo '"'.$br_labels.'"'; ?>],
			datasets : [
				{
					label: <?php echo '"'.$br_obj['name'].'"'; ?>,
					fillColor : "rgba(151,187,205,0.3)",
					strokeColor : "#999",
					pointColor : "rgba(151,187,205,1)",
					pointStrokeColor : "#fff",
					pointHighlightFill : "#000",
					pointHighlightStroke : "rgba(151,187,205,1)",
					data : [<?php echo $br_values; ?>]
				}
			]

		}

	window.onload = function(){
		var ctx = document.getElementById("canvas").getContext("2d");
		window.myLine = new Chart(ctx).Line(lineChartData, {
			responsive: true
		});
	}


	</script>
	</body>
</html>

