
angular.module('ng').filter("timeAgo", function() {
	return function(timestamp) {
		if (!timestamp) return '';
		return moment(timestamp).fromNow();
	}
});

var Projammer = angular.module("Projammer", []);
Projammer.directive('confirmAction', function() {
	return function(scope, element, attrs) {
		element.on("click", function(e) {
			e.preventDefault();
			$(this).hide();
			var span = $("<span>Are you sure? </span>");
			$(this).parent().append(span);
			var confirm = $('<a href="#" class="btn btn-xs btn-danger">Yes</a>');
			var deny = $('<a href="#" class="btn btn-xs btn-default">No</a>');
			$(this).parent().append(confirm);
			$(this).parent().append(" ");
			$(this).parent().append(deny);
			deny.on("click", function(f) {
				f.preventDefault();
				element.show();
				span.remove();
				confirm.remove();
				deny.remove();
			});
			confirm.on("click", function(g) {
				scope.$apply(attrs.confirmAction);	
			});
		});
	};

});

Projammer.factory('ProjectLoader', function($http, $q) {

	return {
		projects : [],
		currentProject : {},
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
		},
		
	}	
	
});

Projammer.controller('ProjectsController', function($rootScope, $scope, $http, ProjectLoader) {

	$rootScope.projects = [];

	ProjectLoader.loadProjects().success(function() {
		$rootScope.projects = ProjectLoader.getProjects()
	});
 	
 	$rootScope.currentProject = ProjectLoader.currentProject;
 	$rootScope.currentProject.status = "presales";

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

 	$scope.updateProject = function() {
 		console.log($rootScope.currentProject);
 		if ($rootScope.currentProject.id) {
 			$http.put("/api/project/"+$rootScope.currentProject.id, { project : $rootScope.currentProject}).success(function(output) {
 				$rootScope.currentProject.updated_at = moment($rootScope.updated_at).fromNow();
 			});
 		} else {
 			$http.post("/api/project", { project :$rootScope.currentProject }).success(function(output) {
 				ProjectLoader.addProject(output.project);
 			});
 		}	
 	};

 	$scope.editProject = function(project) {
 		$rootScope.currentProject = ProjectLoader.currentProject = project;
 	};

 	$scope.deleteProject = function(project) {
 		$http.delete("/api/project/"+project.id).success(function(output) {
 			$rootScope.projects.splice($rootScope.projects.indexOf(project), 1);
 		});	
 	};

 	$scope.resetCurrentProject = function() {
 		$rootScope.currentProject = { status : "presales" };
 	}

});