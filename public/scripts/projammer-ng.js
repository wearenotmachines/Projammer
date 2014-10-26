
angular.module('ng').filter("timeAgo", function() {
	return function(timestamp) {
		if (!timestamp) return '';
		return moment(timestamp).fromNow();
	}
});

var Projammer = angular.module("Projammer", ['ProjectManager', 'Utilities', 'RequirementsManager']);
var utilities = angular.module('Utilities', []);
var projectmanager = angular.module('ProjectManager', ['Utilities']);
var reqs = angular.module('RequirementsManager', ['Utilities']);
var reqUtils = angular. module('RequirementUtilities', ['Utilities', 'RequirementsManager']);

/**
 * A reusable "Are you sure?"
 * @return void
 * @usage add the directive confirm-action="function to call on clicking 'yes' goes here"
 */
utilities.directive('confirmAction', function() {
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
				span.remove();
				confirm.remove();
				deny.remove();
				element.show();
			});
		});
	};

});

projectmanager.factory('ProjectLoader', function($http, $q) {

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

projectmanager.controller('ProjectsController', function($rootScope, $scope, $http, ProjectLoader) {
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

reqs.controller('RequirementsController', function($window, $http, $scope) {

	$scope.requirements = $window.requirements;
	$scope.currentProject = $window.project.id;
	$scope.newRequirement = { "project_id" : $scope.currentProject, "priority" : "M", "status" : "proposed", "complexity" : "hours"};
	if ($scope.requirements==undefined) alert("not set");

	$scope.dirty = function(r) {
		r.dirty = true;
	};

	$scope.saveRequirement = function(requirement) {
		cleanedRequirement = _.pick(requirement, ["code", "project_id", "name", "status", "complexity", "priority"]);
		if (requirement.id!=undefined) {
			$http.put("/api/requirement/"+requirement.id, { requirement : cleanedRequirement})
				 .success(function(output) {
				 	requirement.dirty = false;
				 });
		} else {
			$http.post("/api/requirement", {requirement : cleanedRequirement })
				 .success(function(output){
					requirement = output.requirement;
					requirement.dirty = false;
					requirements.push(requirement);
					$scope.newRequirement = { "project_id" : $scope.currentProject, "priority" : "M", "status" : "proposed", "complexity" : "hours"};
				});
		}
	};

	$scope.deleteRequirement = function(requirement) {
		$http.delete("/api/requirement/"+requirement.id)
		     .success(function(output) {
		     	$scope.requirements.splice($scope.requirements.indexOf(requirement), 1);
		     });
	},

	$scope.resetRequirement = function() {
		$scope.newRequirement = { "project_id" : $scope.currentProject, "priority" : "M", "status" : "proposed", "complexity" : "hours"};
	}

});