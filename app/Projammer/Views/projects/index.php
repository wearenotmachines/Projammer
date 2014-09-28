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
			<td>{{project.name}}</td>
			<td><?= Form::select("project.status", $projectStatuses, null, array("autocomplete"=>"off", "ng-model"=>"project.status", "ng-change"=>"updateProjectStatus(project)")); ?></td>
			<td>{{project.creator.display_name}}</td>
			<td>{{ project.created_at | timeAgo }}</td>
			<td>{{ project.updated_at | timeAgo }}</td>
			<td>{{ project.updater.display_name }}</td>
		</tr>
	</tbody>
	</table>
</div>