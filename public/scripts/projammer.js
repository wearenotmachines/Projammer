// Projammer - Project Management for Programmers

var projammer = {
	
	hello : function() {
		alert("Hello, you're looking sharp");
	}

};

//PROJECTS
projammer.projects = {};
//PROJECTS END

//DELIVERABLES

projammer.deliverables = {
	
}

//DELIVERABLES END

$(document).ready(function() {
	projammer.hello();
});