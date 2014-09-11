<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?= $title; ?></title>
	<link rel="stylesheet" href="/vendor/jqueryui/jquery-ui.min.css" />
	<link rel="stylesheet" href="/vendor/bootstrap/css/bootstrap.min.css" />
	<link rel="stylesheet" href="/vendor/toastr/toastr.min.css" />
	<script type="text/javascript" src="/vendor/jquery.js"></script>
	<script type="text/javascript" src="/vendor/jqueryui/jquery-ui.min.js"></script>
	<script type="text/javascript" src="/vendor/bootstrap/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
	<?= $content; ?>
	</div>
</body>
<script type="text/javascript" src="/vendor/toastr/toastr.min.js"></script>
<script type="text/javascript" src="/scripts/projammer.js"></script>
</html>