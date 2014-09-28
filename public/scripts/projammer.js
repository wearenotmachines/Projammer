// Projammer - Project Management for Programmers
/**
 * Subfunctions are prefixed with _ to show that they are executed inside a callable function
 */

var projammer = {
	
	hello : function() {
		toastr.info("You're using Projammer");
	},

	/**
	 * Does what it says on the tin, adds the autocomplete=off to firefox and removes the disabled attribute from buttons on reload after a click
	 * @return {[type]} [description]
	 */
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
	 * Usage: add a data-monitor-state property to any element you want to watch, to monitor a save button to bind a cleanState function to, just add a button with a data-monitored-button property - containing a span to attach the icon to.
	 * Example: <tr data-monitor-state state="clean"......>...<button data-monitored-button=""...><span class="glyphicon glyphicon-ok-sign"></span></button>
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

	/**
	 * Resets the state of a monitored element to clean and restores the icon state of a monitored-button
	 * Usage: call the function passing an element or a selector string. The param should refer to an element that is a [data-monitor-state] element as it will reset the data-state to clean and attempt to lcate any monitored buttons to update these as well.
	 * @param  {[type]} monitoredElement either a jQuery object to target or a string for a jquery selector
	 * @return {[type]}                  [description]
	 */
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
		$('[data-role="create-deliverable"]').on("click", projammer.deliverables.create);

		$('[data-role=save-all]').ladda();
		$('[data-role=save-all]').on("click", projammer.deliverables.saveAll);
		projammer.AUTOSAVEDELIVERABLES = setInterval(function() {
			projammer.deliverables.autosave($('body').data("projectId"));
		}, 60000);	
	},

	/**
	 * Send data from a new estimate row to the controller to create a new Deliverable, to update the row with an id and then to insert a new deliverable row 
	 * @param  {[type]} e [description]
	 * @return {[type]}   [description]
	 */
	create : function(e) {
		e.preventDefault();
		var trigger = $(e.target);
		var deliverableRow = trigger.closest("tr[data-role=new-deliverable]");
		var deliverableData = deliverableRow.find(":input").serialize();
		$.ajax({
			type : "POST",
			url : "/deliverable",
			data : deliverableData,
			success : function(output) {
				output = JSON.parse(output);
				if (output.status) {
					projammer.deliverables._addNewDeliverableRow(deliverableRow.clone(), output.deliverable);
				} else {
					alert("handle this error");
				}
			}
		})
	},

	_addNewDeliverableRow : function(rowToClone, withData) {
		var targetTable = $('table[data-role=deliverables]');
		targetTable.find("tbody:first").append(rowToClone);
	},
	
	/**
	 * Send data from the estimate table row to the controller to be saved, uses _method=PUT to talk to a resource controller@update
	 * @param  {[type]} e [description]
	 * @return {[type]}   [description]
	 */
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

	/**
	 * Saves each row of the estimate table, uses conventional post, posts to deliverablecontroller@saveAll
	 * @param  {[type]} e [description]
	 * @return {[type]}   [description]
	 */
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

	/**
	 * Automated version of the saveAll function - not triggered by a button, saves estimate table to deliverablecontroller@saveAll, see init funcitn for co-ordination
	 * @param  {[type]} projectID [description]
	 * @return {[type]}           [description]
	 */
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