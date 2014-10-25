
angular.module('ng').filter("timeAgo", function() {
	return function(timestamp) {
		if (!timestamp) return '';
		return moment(timestamp).fromNow();
	}
});

var Projammer = angular.module("Projammer", []);

Projammer.factory('ProjectLoader', function($http, $q) {

	return {
		projects : [],
		loaded : false,
		load : $http.get("/api/project"),

		loadProjects: function() {
			var deferred = $q.defer();
			if (this.loaded) {
				deferred.resolve();
				return deferred.promise();
			};
			this.load.success(function(output) {
				this.projects = output.projects;
				this.loaded = true;
				return this.projects;
			});
			return this.load;
		},
		getProjects : function() {
			return projects;
		},	
		addProject : function(project) {
			projects.push(project);
		}
	}	
	
});

Projammer.controller('ProjectOverviewController', function($scope, $http, ProjectLoader) {

	ProjectLoader.loadProjects().success(function() {
		$scope.projects = ProjectLoader.getProjects()
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
	};

});

Projammer.controller('ProjectEditorController', ['$scope', '$http', function($scope, $http) {

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

 }]);