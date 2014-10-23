<div class="allProjects" ng-controller="ProjectOverviewController">
	<table class="table table-striped">	
	<thead>
		<tr>
		<th>Project</th>
		<th>State</th>
		<th>Created By</th>
		<th>Created</th>
		<th>Last active</th>
		<th>Last updated by</th>
		</tr>
	</thead>
	<tbody>
		<tr ng-repeat="project in projects">
			<td><a href="/projects/edit/{{project.id}}">{{project.name}}</a></td>
			<td><?= Form::select("project.status", $projectStatuses, null, array("autocomplete"=>"off", "ng-model"=>"project.status", "ng-change"=>"updateProjectStatus(project)")); ?></td>
			<td>{{project.creator.display_name}}</td>
			<td>{{ project.created_at | timeAgo }}</td>
			<td>{{ project.updated_at | timeAgo }}</td>
			<td>{{ project.updater.display_name }}</td>
		</tr>
	</tbody>
	</table>
</div>
<div class="newProject" ng-controller="ProjectEditorController">
	<form>
	<div>
		<label>Project Name</label>
		<input type="text" ng-model="project.name" name="name" placeholder="the label for the project" />
	</div>
	<div>
		<label>Project Description</label>
		<textarea ng-model="project.description" name="description" placeholder="a brief description"></textarea>
	</div>
	<div>
		<label>Project Status</label>
		<?= Form::select("status", $projectStatuses, "presales", array("autocomplete"=>"off", "ng-model"=>"project.status")); ?>
	</div>
	<button ng-click="createProject()">Save</button>
	</form>
</div>