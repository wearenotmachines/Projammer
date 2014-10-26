<div class="projectsContainer" ng-controller="ProjectsController">
	<div class="allProjects">
		<table class="table table-striped">	
		<thead>
			<tr>
			<th>Project</th>
			<th>State</th>
			<th>Created By</th>
			<th>Created</th>
			<th>Last active</th>
			<th>Last updated by</th>
			<th></th>
			</tr>
		</thead>
		<tbody>
			<tr ng-repeat="project in projects">
				<td><a href="/project/{{project.id}}">{{project.name}}</a> <a href="" ng-click="editProject(project);$parent.showEditor=true" class="pull-right btn btn-primary btn-xs"><span class="glyphicon glyphicon-pencil"></span> Edit</a></td>
				<td><?= Form::select("project.status", $projectStatuses, null, array("autocomplete"=>"off", "ng-model"=>"project.status", "ng-change"=>"updateProjectStatus(project)")); ?></td>
				<td>{{project.creator.display_name}}</td>
				<td>{{ project.created_at | timeAgo }}</td>
				<td>{{ project.updated_at | timeAgo }}</td>
				<td>{{ project.updater.display_name }}</td>
				<td><a href="" confirm-action="deleteProject(project)" class="btn btn-sm btn-danger"><span class="glyphicon glyphicon-trash"></span> Delete this</a></td>
			</tr>
		</tbody>
		</table>
	</div>

		<a href="" class="btn btn-default" ng-click="resetCurrentProject();showEditor=true">Create Project</a>
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
				<?= Form::select("status", $projectStatuses, "presales", array("autocomplete"=>"off", "ng-model"=>"currentProject.status")); ?>
			</div>

			<button ng-click="updateProject()">Save</button>
			</form>
			<button ng-click="test()">Test</button>
		</div>
			<pre>
			{{currentProject}}
			</pre>

</div>