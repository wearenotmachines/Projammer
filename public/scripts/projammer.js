// Projammer - Project Management for Programmers

var projammer = {
	
	hello : function() {
		toastr.info("You're using Projammer");
	}

};

//PROJECTS
projammer.projects = {};
//PROJECTS END

//DELIVERABLES

projammer.deliverables = {

	init : function() {
		$('[data-role="save-deliverable"]').on("click", projammer.deliverables.update);
	},
	
	update : function(e) {
		e.preventDefault();
		var trigger = $(e.target);
		var deliverableRow = trigger.closest("tr.deliverable-row");
		var deliverableData = deliverableRow.find(":input").serialize();
		console.log(deliverableData);
		toastr.info("Saving deliverable");
	}

}

//DELIVERABLES END

$(document).ready(function() {
	projammer.hello();
	projammer.deliverables.init();
});