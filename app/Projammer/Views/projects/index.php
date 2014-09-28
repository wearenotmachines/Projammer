<div class="allProjects" ng-controller="ProjectsController">
	<table class="table table-striped">	
	<thead>
		<tr>
		<th>Project</th>
		<th>State</th>
		<th>Created By</th>
		<th>Created</th>
		<th>Last active</th>
		</tr>
	</thead>
	<tbody>
		<tr ng-repeat="project in projects">
			<td>{{project.name}}</td>
			<td><?= Form::select("project.status", array_combine($projectStatuses, $projectStatuses), null, array("autocomplete"=>"off", "ng-model"=>"project.status", "ng-change"=>"updateProjectStatus(project)")); ?></td>
			<td>{{project.creator.display_name}}</td>
			<td>{{ project.created_at | timeAgo }}</td>
			<td>{{ project.updated_at | timeAgo }}</td>
		</tr>
	</tbody>
	</table>
</div>