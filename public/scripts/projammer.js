// Projammer - Project Management for Programmers

var projammer = {
	
	hello : function() {
		toastr.info("You're using Projammer");
	},

	fixFirefoxForms : function() {
		$(":input").attr("autocomplete", "off");
		$('button').removeAttr("disabled");
	},

	/**
	 * Enable sorting to update display order on any element with a class of sortable
	 * Usage: Give the parent container a class of .sortable, include in each the sortable items an input with a data-role=display-order attribute, on sort stop the display-order input will be updated with the sort order from 1-n
	 * @return void;
	 */
	initSortables : function() {
		$('.sortable').sortable({
			stop : function(event, ui) {
				var origin = $(event.target).closest(".sortable");
				origin.find("input[data-role=display-order]").each(function(index, element) {
					$(element).val(index+1);
					$(element).trigger("change");
				});
			}
		});
		return;
	},

	/**
	 * Sets up a watch on all inputs of the monitored element, whenever a change event is fired the data-state is set to dirty, any monitored-button instances have their icon set to a question mark symbol until saved
	 * Usage: add a data-monitor-state property to any element you want to watch, optionally add a data-state property to the inputs to watch, this will get updated
	 * @return {[type]} [description]
	 */
	monitorState : function() {
		$('[data-monitor-state]').each(function(index, element) {
			var monitored = $(element);
			monitored.find(":input").on("change", function() {
				monitored.attr("data-state", "dirty");
				monitored.find("[data-monitored-button]>span").removeClass("glyphicon-ok-sign").addClass("glyphicon-question-sign");
			});
		});
	},

	cleanState : function(monitoredElement) {
		if (monitoredElement instanceof $) {
			monitoredElement.attr("data-state", "clean");
			monitoredElement.find("[data-monitored-button]>span").removeClass("glyphicon-question-sign").addClass("glyphicon-ok-sign");
		} else {
			$(monitoredElement).attr("data-state", "clean");
			$(monitoredElement).each(function(index, element) {
				var monitored = $(element);
				monitored.find("[data-monitored-button]>span").removeClass("glyphicon-question-sign").addClass("glyphicon-ok-sign");
			});
		}
	}

};

//PROJECTS
projammer.projects = {};
//PROJECTS END

//DELIVERABLES

projammer.deliverables = {

	init : function() {
		$('[data-role="save-deliverable"]').on("click", projammer.deliverables.update);
		$('[data-role=save-all]').ladda();
		$('[data-role=save-all]').on("click", projammer.deliverables.saveAll);
		projammer.AUTOSAVEDELIVERABLES = setInterval(function() {
			projammer.deliverables.autosave($('body').data("projectId"));
		}, 60000);	
	},
	
	update : function(e) {
		e.preventDefault();
		var trigger = $(e.target);
		var deliverableRow = trigger.closest("tr[data-role=deliverable]");
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
				projammer.cleanState(deliverableRow);
			}
		});
		toastr.info("Saving deliverable");
	},

	saveAll : function(e) {
		e.preventDefault();
		var trigger = $(e.target);
		var projectID = trigger.data("projectId");
		var deliverableData = $('tr[data-role=deliverable] :input').serialize();
		var l = Ladda.create(this);
		l.start();
		$.ajax({
			url : "/project/"+projectID+"/estimate/save",
			type : "post",
			dataType : "json",
			data : deliverableData,
			success : function(output) {
				l.stop();
				projammer.cleanState('tr[data-role=deliverable]');
			}
		})
	},

	autosave : function(projectID) {
		toastr.info("Saving data...");
		var deliverableData = $('tr[data-role=deliverable] :input').serialize();
		$.ajax({
			url : "/project/"+projectID+"/estimate/save",
			type : "post",
			dataType : "json",
			data : deliverableData,
			success : function(output) {
				toastr.clear();
				toastr.options.timeOut = 2000;
				toastr.success("Data saved");
				projammer.cleanState('tr[data-role=deliverable]');
			}
		})
	}


}

//DELIVERABLES END

$(document).ready(function() {
	projammer.initSortables();
	projammer.fixFirefoxForms();
	projammer.hello();
	projammer.deliverables.init();
	projammer.monitorState();
});