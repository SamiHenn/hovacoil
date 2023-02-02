require(["jquery", "../../dist/jquery.validate"], function($) {

	$.validator.setDefaults({
        ignore: ['readonly'],
		submitHandler: function() { alert("submitted!"); }
	});

	// validate the comment form when it is submitted
	$("#commentForm").validate();
});