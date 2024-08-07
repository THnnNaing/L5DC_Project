<?php 

include('../dbconnect.php');

 ?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Countdown Redirect</title>
	<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-yellow-200 text-center flex items-center justify-center min-h-screen">
	<div class="bg-white p-6 rounded-lg shadow-lg">
		<h1 class="text-2xl font-bold text-yellow-300">Still Count Down Ten Minutes</h1>
		<p class="mt-4">
			You will be redirected back to the Login Page after ten minutes
			<span id="countdown" class="font-mono text-xl text-yellow-400">600</span> seconds
		</p>
	</div>

	<script type="text/javascript">
		var seconds = 600;

		function updateCountdown() {
			document.getElementById('countdown').textContent = seconds;
			seconds--; 
			if (seconds < 0) {
				window.location.href = 'adminlogin.php';
			}
		}
		setInterval(updateCountdown, 1000); 
	</script>
</body>
</html>
