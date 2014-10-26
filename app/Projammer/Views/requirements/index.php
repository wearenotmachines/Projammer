<table class="table">
	<thead>
	<tr>
		<th>Code</th>
		<th>Requirement</th>
		<th class="centre">Priority</th>
		<th class="centre">Complexity</th>
		<th class="centre">Actions</th>
	</tr>
	</thead>
	<tbody>
	<?foreach ($project->requirements AS $r) { ?>
		<tr>
			<td><?= $r->code; ?></td>
			<td><?= $r->name; ?></td>
			<td align="center"><?= $r->priority; ?></td>
			<td align="center"><?= $r->complexity; ?></td>
			<td></td>
		</tr>
	<? } ?>
	</tbody>
</table>
<?php

echo "<pre>";
echo $project->requirements;
echo "</pre>";
?>