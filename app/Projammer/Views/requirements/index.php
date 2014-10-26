<? use Projammer\Models\Requirement; ?>
<div ng-controller="RequirementsController">
	<table class="table">
		<thead>
		<tr>
			<th>Code</th>
			<th>Requirement</th>
			<th class="centre">Priority</th>
			<th class="centre">Complexity</th>
			<th class="centre">Actions</th>
		</tr>
		</thead>
		<tbody>
		
			<tr ng-repeat="requirement in requirements">
			<input type="hidden" name="id" ng-model="requirement.id" />
				<td><input type="text" name="code" ng-model="requirement.code" ng-change="dirty(requirement)" /></td>
				<td><input type="text" name="name" ng-model="requirement.name" ng-change="dirty(requirement)" /></td>
				<td align="center"><?= Form::select("priority", Requirement::$priorities, null, array("ng-model"=>'requirement.priority', "ng-change"=>"dirty(requirement)")); ?></td>
				<td align="center"><?= Form::select("complexity", array_combine(Requirement::$complexities, array_map(function($e) { return ucfirst($e); }, Requirement::$complexities)), null, array("ng-model"=>"requirement.complexity", "ng-change"=>"dirty(requirement)" )); ?></td>
				<td><a class="btn btn-sm btn-default" ng-class="{'btn-danger': requirement.dirty}" href=""><span class="glyphicon" ng-class="{'glyphicon-pencil': requirement.dirty}"></span> {{ requirement.dirty ? "Save" : "Saved" }}</a></td>
			</tr>

		</tbody>
	</table>
</div>