

jQuery(function($){

	var processFile = "assets/inc/ajax.inc.php";

	
	tinymce.init({
	    selector: "div#greeting",
	    inline: true,
	    plugins: [
	        "autolink lists link charmap anchor",
	        "searchreplace visualblocks code",
	        "insertdatetime paste"
	    ],
	    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link"
	});
	
	
	$("#greeting_edit>.admin").live("click", function(event){

		event.preventDefault();
		
		// Sets the action for the form submission
        var action = $(event.target).attr("name") || "edit_greeting";
        
        // Saves the value of the greeting_id input
        id = $("input[name=greeting_id]").val();
        
        // Creates an additional param for the ID if set
        id = ( id!=undefined ) ? "&greeting_id="+id : "";
        
        var data = "&text="+encodeURIComponent($("#greeting").html());
        
        $.ajax({
            type: "POST",
            url: processFile,
            data: "action="+action+id + data,
            success: function(data){
            	console.log("SUCCESS!!");
            },
            error: function(msg){
                alert(msg);
            }
        });
        
		
	});
	
});
