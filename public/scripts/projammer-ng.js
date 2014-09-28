
angular.module('ng').filter("timeAgo", function() {
	return function(timestamp) {
		if (!timestamp) return '';
		return moment(timestamp).fromNow();
	}
});

function ProjectsController($scope, $http) {

	$http.get("/projects").success(function(projects) {
		$scope.projects = projects;
	});

	$scope.updateProjectStatus = function(project) {
		$http.put("/project/"+project.id, { project : 
			{
				status : project.status 
			}	
		}).success(function(response) {
			project.updated_at = moment(response.updated_at).fromNow();
		});
	}


}