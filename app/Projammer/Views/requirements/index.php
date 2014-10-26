<? use Projammer\Models\Requirement; ?>
<div ng-controller="RequirementsController">
	<table class="table">
		<thead>
		<tr>
			<th>Code</th>
			<th>Requirement</th>
			<th class="centre">Priority</th>
			<th class="centre">Complexity</th>
			<th class="centre">Status</th>
			<th class="centre">Actions</th>
		</tr>
		</thead>
		<tbody>
		
			<tr ng-repeat="requirement in requirements">
			<input type="hidden" name="id" ng-model="requirement.id" />
			<input type="hidden" name="project_id" ng-model="requirement.project_id" />
				<td><input type="text" name="code" ng-model="requirement.code" ng-change="dirty(requirement)" /></td>
				<td><input type="text" name="name" ng-model="requirement.name" ng-change="dirty(requirement)" /></td>
				<td align="center"><?= Form::select("priority", Requirement::$priorities, null, array("ng-model"=>'requirement.priority', "ng-change"=>"dirty(requirement)")); ?></td>
				<td align="center"><?= Form::select("complexity", array_combine(Requirement::$complexities, array_map(function($e) { return ucfirst($e); }, Requirement::$complexities)), null, array("ng-model"=>"requirement.complexity", "ng-change"=>"dirty(requirement)" )); ?></td>
				<td align="center"><?= Form::select("status", array_combine(Requirement::$statuses, array_map(function($f) { return ucfirst($f); }, Requirement::$statuses)), null, array("ng-model"=>'requirement.status', "ng-change"=>"dirty(requirement)")); ?></td>
				<td><a class="btn btn-sm btn-default" ng-class="{'btn-danger': requirement.dirty}" href="" ng-click="saveRequirement(requirement)"><span class="glyphicon" ng-class="{'glyphicon-pencil': requirement.dirty}"></span> {{ requirement.dirty ? "Save" : "Saved" }}</a> <a href="" confirm-action="deleteRequirement(requirement)" class="btn btn-sm btn-danger"><span class="glyphicon glyphicon-trash"></span> Delete</a></td>
			</tr>
			
			<tr>
				<input type="hidden" name="project_id" ng-model="newRequirement.project_id" />
				<td><input type="text" name="code" ng-model="newRequirement.code" placeholder="code" ng-change="dirty(newRequirement)" /></td>
				<td><input type="text" name="name" ng-model="newRequirement.name" placeholder="requirement" ng-change="dirty(newRequirement)" /></td>
				<td align="center"><?= Form::select("priority", Requirement::$priorities, null, array("ng-model"=>'newRequirement.priority', "ng-change"=>"dirty(newRequirement)")); ?></td>
				<td align="center"><?= Form::select("complexity", array_combine(Requirement::$complexities, array_map(function($e) { return ucfirst($e); }, Requirement::$complexities)), null, array("ng-model"=>"newRequirement.complexity", "ng-change"=>"dirty(newRequirement)")); ?></td>
				<td align="center"><?= Form::select("status", array_combine(Requirement::$statuses, array_map(function($f) { return ucfirst($f); }, Requirement::$statuses)), null, array("ng-model"=>'newRequirement.status', "ng-change"=>"dirty(newRequirement)")); ?></td>
				<td>
					<a class="btn btn-sm btn-default" ng-class="{'btn-danger': newRequirement.dirty}" href="" ng-click="saveRequirement(newRequirement)"><span class="glyphicon" ng-class="{'glyphicon-pencil': newRequirement.dirty}"></span> Save</a>
					<a class="btn btn-sm btn-danger" href="" confirm-action="resetRequirement()"><span class="glyphicon glyphicon-remove"></span> Reset</a>
				</td>
			</tr>
		</tbody>	
	</table>
</div>