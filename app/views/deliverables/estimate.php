
<table class="table deliverable">
	<thead>
		<th>Deliverable</th>
		<th>Note</th>
		<th>Required</th>
		<th>Time</th>
		<th>Cost</th>
		<th>Options</th>
		<th>Actions</th>
	</thead>
	<tbody class="sortable">
	<? foreach ($deliverables as $d) { ?>
		<tr data-state="clean" class="deliverable-row">
			<input type="hidden" name="deliverable[$<?= $d['id']; ?>][display_order]" value="<?= $d['display_order']; ?>" data-role="display_order" />
			<td><input class="form-control" type="text" name="deliverable[<?= $d->id; ?>][name]" data-deliverable-id="<?= $d['id']; ?>" data-role="deliverable-name" value="<?= $d->name; ?>" /></td>
			<td><textarea class="form-control" name="deliverable[<?= $d->id; ?>][note]" data-deliverable-id="<?= $d['id']; ?>" data-role="deliverable-note"><?= $d->note; ?></textarea></td>
			<td><input class="form-control" type="checkbox" name="deliverable[<?= $d->id; ?>][required]" data-deliverable-id="<?= $d['id']; ?>" data-role="deliverable-required" value="1" <?= $d->required ? 'checked="checked"' : ''; ?> /></td>
			<td><input class="form-control" type="text" name="deliverable[<?= $d->id; ?>][development_time]" data-role="deliverable-development_time" value="<?= $d->development_time; ?>"></td>
			<td><input class="form-control" type="text" name="deliverable[<?= $d->id; ?>][development_cost]" data-role="deliverable-development_cost" value="<?= $d->development_cost; ?>" /></td>
			<td></td>
			<td><button data-role="save-deliverable" data-deliverable-id="<?= $d->id; ?>" type="button" class="btn btn-default"><span class="glyphicon glyphicon-ok"></span> </button></td>
		</tr>
	<? } ?>
		<tr>
			<td><input class="form-control" type="text" name="deliverable[][name]" data-deliverable-id="<?= $d['id']; ?>" data-role="deliverable-name" /></td>
			<td><textarea class="form-control" type="text" name="deliverable[][note]" data-deliverable-id="<?= $d['id']; ?>" data-role="deliverable-note"></textarea></td>
			<td><input class="form-control" type="checkbox" name="deliverable[][required]" data-deliverable-id="<?= $d['id']; ?>" data-role="deliverable-required" value="1" checked='checked' /></td>
			<td><input class="form-control" type="text" name="deliverable[][development_time]" data-role="deliverable-development_time" /></td>
			<td><input class="form-control" type="text" name="deliverable[][development_cost]" data-role="deliverable-development_cost" /></td>
			<td></td>
			<td><button type="button" class="btn btn-default"><span class="glyphicon glyphicon-plus-sign"></span> </button></td>
		</tr>
	</tbody>
</table>