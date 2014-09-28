<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?= $title; ?></title>
	<link rel="stylesheet" href="/css/main.css" />
	<link rel="stylesheet" href="/vendor/jqueryui/jquery-ui.min.css" />
	<link rel="stylesheet" href="/vendor/bootstrap/css/bootstrap.min.css" />
	<script type="text/javascript" src="/vendor/jquery.js"></script>
	<script type="text/javascript" src="/vendor/jqueryui/jquery-ui.min.js"></script>
	<script type="text/javascript" src="/vendor/bootstrap/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="/vendor/date/moment.min.js"></script>
</head>
<body <?= isset($project) ? "data-project-id='".$project->id."'" : ""; ?><?= isset($bodyClass) ? " class='".$bodyClass."'" : ""; ?>>
<div class="container" ng-app>
	<div id="header">
		<div id="navigation"></div>
		<div id="userContext">
			<? if (Auth::check()) { ?>
				<p>Hello <?= Auth::user()->display_name; ?> - <a href="/logout">Log out</a></p>
			<? } else { ?>
				<p>You are not logged in - <a href="/login">log in</a></p>
			<? } ?>
	</div>
	<div id="messages">
	<? if (!empty(Session::get("message"))) { ?>
	<p class="message"><?= Session::get("message"); ?></p>
	<? } ?>
	</div>
	<?= $content; ?>
	</div>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/angularjs/1.2.25/angular.min.js"></script>
	<script type="text/javascript" src="/scripts/projammer-ng.js"></script>
</body>

</html>