<?= Form::open(array("route"=>"project.store")); ?>
	<div>
		<label for="projectName">Name</label>
		<input type="text" name="project[name]" id="projectName" placeholder="How do you refer to this project" value="<?= Input::old("project.name"); ?>">
	</div>
	<div>
		<label for="projectDescription">Description</label>
		<textarea name="project[description]" id="projectDescription" cols="30" rows="10" placeholder="Say something about this project"><?= Input::old("project.description"); ?></textarea>
	</div>
<?= Form::close(); ?>