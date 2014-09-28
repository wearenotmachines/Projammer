<?= $contextNavigation; ?>
<div class="container">
<h2>Create a new project</h2>
<?= Form::open(array("route"=>"project.store")); ?>
	<h3><?= Form::text("project[name]", Input::old("project.name"), array("placeholder"=>"Project Name")); ?><span class="alert alert-error"><?= $errors->first("name"); ?></span></h3>

	<?= Form::textarea("project[description]", Input::old("project.description"), array("placeholder"=>"Description", "autocomplete"=>"off")); ?>
	<div>
	<?= Form::label("Project Status"); ?>
	<?= Form::select("project[status]", $projectStatuses); ?>
	</div>
	<div>
	<?= Form::label("Client"); ?>
	<?= Form::select("project[client_id]", $clients); ?>
	</div>
	<?= Form::button("Next", array("type"=>"submit", "class"=>"btn btn-primary")); ?>
<?= Form::close(); ?>
</div>