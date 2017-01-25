// Add Record
function addRecord() {
	// get values
	var first_name = $("#first_name").val();
	var last_name = $("#last_name").val();
	var email = $("#email").val();
	// Add record
	$.ajax({
		url : 'API/controller.php',
		type : 'POST',
		dataType : 'json',
		contentType : 'application/json',
		data : JSON.stringify({
			'first_name' : first_name,
			'last_name' : last_name,
			'email' : email
		}),
		success : function(result) {
			$("#add_new_record_modal").modal("hide");

			// read records again
			readRecords();

			// clear fields from the popup
			$("#first_name").val("");
			$("#last_name").val("");
			$("#email").val("");
		}
	});
}

// READ records
function readRecords() {
	$.get("API/controller.php", {}, function(data, status) {
		$(".records_content").html(data);
	});
}

function DeleteUser(id) {
	var conf = confirm("Are you sure, do you really want to delete User?");
	if (conf == true) {
		$.ajax({
			url : 'API/controller.php/' + id,
			type : 'DELETE',
			success : function(result) {
				readRecords();
			}
		});
	}
}

function GetUserDetails(id) {
	// Add User ID to the hidden field for furture usage
	$("#hidden_user_id").val(id);
	$.get("API/controller.php/" + id, {}, function(data, status) {
		// PARSE json data
		var user = JSON.parse(data);
		// Assing existing values to the modal popup fields
		$("#update_first_name").val(user.username);
		$("#update_last_name").val(user.name);
		$("#update_email").val(user.email);
	});
	// Open modal popup
	$("#update_user_modal").modal("show");
}

function UpdateUserDetails() {
	// get values
	var first_name = $("#update_first_name").val();
	var last_name = $("#update_last_name").val();
	var email = $("#update_email").val();

	// get hidden field value
	var id = $("#hidden_user_id").val();

	// Update the details by requesting to the server using ajax
	$.ajax({
		url : 'API/controller.php/' + id,
		type : 'PUT',
		dataType : 'json',
		contentType : 'application/json',
		data : JSON.stringify({
			'first_name' : first_name,
			'last_name' : last_name,
			'email' : email
		}),
		success : function(result) {
			// Do something with the result
			$("#update_user_modal").modal("hide");
			// reload Users by using readRecords();
			readRecords();
		}
	});

}

$(document).ready(function() {
	// READ recods on page load
	readRecords(); // calling function
});