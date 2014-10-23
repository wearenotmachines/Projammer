
angular.module('ng').filter("timeAgo", function() {
	return function(timestamp) {
		if (!timestamp) return '';
		return moment(timestamp).fromNow();
	}
});

function ProjectOverviewController($scope, $http) {

	$http.get("/api/project").success(function(output) {
		$scope.projects = output.projects;
	});

	$scope.updateProjectStatus = function(project) {
		$http.put("/project/"+project.id, { project : 
			{
				status : project.status 
			}	
		}).success(function(response) {
			project.updated_at = moment(response.updated_at).fromNow();
			project.updater = response.updater;
		});
	}


}

function ProjectEditorController($scope, $http) {

	$scope.project = {
		status : "presales"
	};

	$scope.createProject = function() {
		console.log($scope.project);
		console.log("Creating Project");
		$http.post("/api/project", { project : $scope.project }).success(function(output) {
			console.log(output);
		});
	}

}