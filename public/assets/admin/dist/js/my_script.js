$(document).ready(function() {
	$("#checkAll").click(function() {
    	$(".checkSingle").prop("checked", this.checked);
  	});	

  	$('#title').keyup(function(e) {
    	var str = $(this).val().replace(/\s+/g, '-').toLowerCase();
    	$("#slug").val(str);
	});
});