<!DOCTYPE html>
<html moznomarginboxes mozdisallowselectionprint>
<head>
	<title>Rekap</title>
	<style type="text/css">
		.container{
			width: 980px;
			margin: 0 auto;
		}

		table, th, td {
			border: 1px solid black;
			border-collapse: collapse;
		}

		table tr td, table tr th{
			padding: 10px;
		}

		table tr td:nth-child(2),table tr td:nth-child(4){
			text-align: center;
		}

		.printbreak {
			page-break-after: always;
		}

		@page{size:auto; margin-bottom:30mm;margin-top:30mm;}
	</style>
	<script>
		window.print();
	</script>
</head>
<body>
	<?php
		define("BASE_PATH", true);
		include "lib/db_lib.php";


		<div class="printbreak">
				<div class="container">
					<table width='100%'>
									<tr align='center'>
										<th rowspan='2'>No</th>
										<th rowspan='2'>Nama</th>
										<th rowspan='2'>NPM</th>
										<th colspan='2'>PK</th>
										<th colspan='2'>OM</th>
										<th>IN</th>
									</tr>
									<tr align='center'>
										<th>H1</th>
										<th>H2</th>
										<th>H1</th>
										<th>H2</th>
									</tr>
					</table>
				</div>
		</div>
</body>
</html>
