<?php namespace Projammer\Models;
use Form;
?>
<div class="editorContainer" ng-controller="ProjectsController">
	<a href="" ng-click="resetCurrentProject();showEditor = true">Create Project</a>
	<div class="newProject" ng-show="showEditor">
		<form>
		<input type="hidden" name="id" ng-model="currentProject.id" />
		<div>
			<label>Project Name</label>
			<input type="text" ng-model="currentProject.name" name="name" autocomplete="off" placeholder="the label for the project" />
		</div>
		<div>
			<label>Project Description</label>
			<textarea ng-model="currentProject.description" name="description" placeholder="a brief description"></textarea>
		</div>
		<div>
			<label>Project Status</label>
			<?= Form::select("status", array_combine(Project::getProjectStatuses(),Project::getProjectStatuses()), "presales", array("autocomplete"=>"off", "ng-model"=>"currentProject.status")); ?>
		</div>

		<button ng-click="updateProject()">Save</button>
		</form>
		<button ng-click="test()">Test</button>
	</div>
		{{currentProject}}
</div>