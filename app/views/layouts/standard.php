<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?= $title; ?></title>
	<?= ResourceLoader::getCSS(true); ?>
	<?= ResourceLoader::getScripts(true); ?>
</head>

<body>
	<?= $content; ?>
</body>
</html>