<?php namespace Projammer\Models;
use Form;
?>
<div class="newProject" ng-controller="ProjectEditorController">
	<form>
	<div>
		<label>Project Name</label>
		<input type="text" ng-model="project.name" name="name" autocomplete="off" placeholder="the label for the project" value="TESTING" />
	</div>
	<div>
		<label>Project Description</label>
		<textarea ng-model="project.description" name="description" placeholder="a brief description"></textarea>
	</div>
	<div>
		<label>Project Status</label>
		<?= Form::select("status", array_combine(Project::getProjectStatuses(),Project::getProjectStatuses()), "presales", array("autocomplete"=>"off", "ng-model"=>"project.status")); ?>
	</div>

	<button ng-click="createProject()">Save</button>
	</form>
</div>