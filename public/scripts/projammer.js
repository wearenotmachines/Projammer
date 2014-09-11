// Projammer - Project Management for Programmers

var projammer = {
	
	hello : function() {
		toastr.info("You're using Projammer");
	},

	fixFirefoxForms : function() {
		$("input[type=text],:checkbox,:radio,textarea").attr("autocomplete", "off");
	}

};

//PROJECTS
projammer.projects = {};
//PROJECTS END

//DELIVERABLES

projammer.deliverables = {

	init : function() {
		$('[data-role="save-deliverable"]').on("click", projammer.deliverables.update);
		$('table.deliverable tbody.sortable').sortable({
			placeholder: "sortable-placeholder",
			stop : function() {
				$('table.deliverable tr').each(function(index, element) {
					$(element).find("input[data-role=display_order]").val(index);
				})
			}
		});
	},
	
	update : function(e) {
		e.preventDefault();
		var trigger = $(e.target);
		var deliverableRow = trigger.closest("tr.deliverable-row");
		var deliverableID = trigger.data("deliverableId");
		var deliverableData = deliverableRow.find(":input").serialize();
		$.ajax({
			url : "/deliverable/"+deliverableID,
			type : "post",
			dataType : "json",
			data : deliverableData+"&_method=PUT",
			success : function(output) {
				console.log(output);
				toastr.clear();
				toastr.success("Updated");
			}
		});
		toastr.info("Saving deliverable");
	}

}

//DELIVERABLES END

$(document).ready(function() {
	projammer.fixFirefoxForms();
	projammer.hello();
	projammer.deliverables.init();
});