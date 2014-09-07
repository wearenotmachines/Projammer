<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Projects</title>
</head>
<body>
	<ul>
		<? foreach ($projects as $p) { ?>
			<li><a href="/project/<?= $p->id; ?>"><?= $p->name; ?></a></li>
		<? } ?>
	</ul>
</body>
</html>