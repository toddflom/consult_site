

// Makes sure the document is ready before executing scripts
jQuery(function($){
	
	// File to which AJAX requests should be sent
	var processFile = "assets/inc/ajax.inc.php";
	
	// Functions to manipulate the modal window
	var fx = {	
						
		// Checks for a modal window and returns it, or
        // else creates a new one and returns that
        "initModal" : function() {
            // If no elements are matched, the length
            // property will be 0
            if ( $(".modal-window").length==0 )
            {
                // Creates a div, adds a class, and
                // appends it to the body tag
                return $("<div>")
                        .hide()
                        .addClass("modal-window")
                        .appendTo(".modal-center");
            }
            else
            {
                // Returns the modal window if one
                // already exists in the DOM
            	$(".modal-window").html(""); // removes any content that was in the modal already
                return $(".modal-window");
            }
            
        },
        
		// Checks for a modal search window and returns it, or
        // else creates a new one and returns that
        "initSearchModal" : function() {
            // If no elements are matched, the length
            // property will be 0
            if ( $(".modal-search-window").length==0 )
            {
                // Creates a div, adds a class, and
                // appends it to the body tag
                return $("<div>")
                        .hide()
                        .addClass("modal-search-window")
                        .appendTo(".aspectwrapper"); //"body");
            }
            else
            {
                // Returns the modal window if one
                // already exists in the DOM
                return $(".modal-search-window");
            }
            
        },
		
     // Adds the window to the markup and fades it in
        "boxin" : function(data, modal) {
            // Loads data into the modal window and
            // appends it to the body element
            modal
                .hide()
                .append(data)
                .appendTo(".modal-center");

            // Fades in the modal window // and overlay
            // $(".modal-window") //,.modal-overlay")
            modal
                .fadeIn("fast");
        },
        
        "boxinsearch" : function(data, modal) {
           modal
                .hide()
                .append(data)
                .appendTo(".aspectwrapper");
            modal
                .fadeIn("fast");
        },
        
            
		// Fades out the window and removes it from the DOM
	    "boxout" : function(event) {
            // If an event was triggered by the element
            // that called sthis function, prevents the
            // default action from firing
            if ( event!=undefined )
            {
                event.preventDefault();
            }

            // Removes the active class from all links
            $("<a>").removeClass("active");

            // Fades out the modal window, then removes
            // it from the DOM entirely
            
            if ($("#login_modal").length) {
	            $("#login_modal")
		            .fadeOut("fast", function() {
		                $(this).remove();
		            }
		        );
	        }
            if ($(".modal-step-window").length) {
	            $(".modal-step-window")
		            .fadeOut("fast", function() {
		                $(this).remove();
		            }
		        );
	        }
            if ($(".modal-search-window").length) {
	            $(".modal-search-window")
		            .fadeOut("fast", function() {
		                $(this).remove();
		            }
		        );
	        }
	    },
	    

	    // Adds a new step to the markup after saving
        "addstep" : function(data, formData){
	    	// Converts the query string to an object
	        var entry = fx.deserialize(formData);
	        
	        //   console.log(entry.ordering_number + ". " + entry.step_name);
	        
	        var x = parseInt(data,10); // have to do this to get rid of the leading space, don't konw why it has a leading space
	        
	        // Adds new li and step link
	        $("<li>")
	       	.append('<strong>' + entry.ordering_number 
	        			+ '.</strong> <a href="view.php?step_id=' 
	        			+ x + '">' + entry.step_name + "</a>")
	        	.insertAfter($('.steps>li:last'));
	       
        },
        
        
        // Removes a step from the markup after deletion
        "removestep" : function()
        {
        	// Removes any step with the class "active"
            $(".steps .active")
                .fadeOut("fast", function(){
                        $(this).remove();
                    });
        },

        
        

	    // Adds a new step to the markup after saving
        "addposition" : function(data, formData){
	    	// Converts the query string to an object
	        var entry = fx.deserialize(formData);
	        
	        console.log(entry);
	        
	        var x = parseInt(data,10); // have to do this to get rid of the leading space, don't konw why it has a leading space
	        
	        // Adds new li and step link
	        // *TODO we have to figure out some way to get the flippin color 
	        $("<li>")
	        .append('<div style="width:50px;height:70px;background-color:#E7BB20">'
	        		+ '<a href="positionview.php?position_id=' + x + '">'
	        		+ entry.position_acronym + '</a>'
	        		+ '</div><div>'
	        		+ '<a href="positionview.php?position_id=' + x + '">'
	        		+ entry.position_name + '</a></div>')
	        			
	        	.insertAfter($('.positions>li:last'));
        },
        
        
        // Removes a step from the markup after deletion
        "removeposition" : function()
        {
        	// Removes any position with the class "active"
            $(".positions .active")
                .fadeOut("fast", function(){
                        $(this).remove();
                    });
        },
        
        
        

	    // Adds a new definition to the markup after saving
        "adddefinition" : function(data, formData){
	    	// Converts the query string to an object
	        var entry = fx.deserialize(formData);
	        
	       // console.log(entry);
	        
	        var x = parseInt(data,10); // have to do this to get rid of the leading space, don't konw why it has a leading space
	        
	        // Adds new li and step link
	        $("<li>")
	        .append('<div>'
	        		+ '<a href="glossaryview.php?definition_id=' + x + '">'
	        		+ entry.definition_name + '</a></div>'
	        		+ '<div>'
	        		+ entry.definition_description + '</div>')
	        	.insertAfter($('.glossary>li:last'));
        },
        
        
        // Removes a definition from the markup after deletion
        "removedefinition" : function()
        {
        	// Removes any definition with the class "active"
            $(".glossary .active")
                .fadeOut("fast", function(){
                        $(this).parent().remove();
                    });
        },
        
        
        
        

	    // Adds a new department to the markup after saving
        "adddepartment" : function(data, formData){
	    	// Converts the query string to an object
	        var entry = fx.deserialize(formData);
	        
	        console.log(entry);
	        
	        var x = parseInt(data,10); // have to do this to get rid of the leading space, don't konw why it has a leading space
	        
	        // Adds new li and step link
	        $("<li>")
	        .append('<div>'
	        		+ '<a href="departmentview.php?department_id=' + x + '">'
	        		+ entry.department_name + '</a></div>'
	        		+ '<div>'
	        		+ entry.department_color + '</div>')
	        	.insertAfter($('.departments>li:last'));
        },
        
        
        // Removes a department from the markup after deletion
        "removedepartment" : function()
        {
        	// Removes any position with the class "active"
            $(".departments .active")
                .fadeOut("fast", function(){
                        $(this).parent().remove();
                    });
        },
        
        
        
        
        // Deserializes the query string and returns
        // an event object
        "deserialize" : function(str){
        	 // Breaks apart each name-value pair
            var data = str.split("&"),

            // Declares variables for use in the loop
                pairs=[], entry={}, key, val;

            // Loops through each name-value pair
            for ( x in data )
            {
                // Splits each pair into an array
                pairs = data[x].split("=");

                // The first element is the name
                key = pairs[0];

                // Second element is the value
                val = pairs[1];

                // Reverses the URL encoding and stores
                // each value as an object property
                entry[key] = fx.urldecode(val);
            }
            return entry;
        },
        
        // Decodes a query string value
        "urldecode" : function(str) {
            // Converts plus signs to spaces
            var converted = str.replace(/\+/g, ' ');

            // Converts any encoded entities back
            return decodeURIComponent(converted);
         },
    
        
        "setPhase" : function(str) {
        	$('#phase_title').html(str + " phase");
        },

         "setStepNum" : function(str) {
	     	$('#map_container .map_pos_indicator').html(str);
	    },
        
        "setSearchResults" :function(results) {
        	$('.modal-search-window #search_contents').html(results);
        }
		
	};
	
    
	
	
	
	/*
	 * NEW CONTENT
	 */
	
	
	
	
	
	$("#login_modal input[type=submit]").click(function(event) {
		
		event.preventDefault();
		var formData = $(this).parents("form").serialize();
		submitVal = $(this).val();
		
		/* 
		var action = $("#form1").attr('action');
		var form_data = {
			username: $("#username").val(),
			password: $("#password").val(),
			is_ajax: 1
		};
		*/
		
		$.ajax({
			type: "POST",
			url: processFile,
			data: formData,
			success: function(response)
			{
			    if(response == 1) { // data converts it to an int
					//$("#form1").slideUp('slow', function() {
					//    window.location.href = 'newwork.php';
				   // });
					fx.boxout();
					loadLandingPage();
			    } else {
			    	$("#message").html("You have entered an invalid username or password.");	
			    }
			}
		});
		
	});
	
	

	
	
	function loadLandingPage() {
		
	    // Loads the event data from the DB
        $.ajax({
            type: "POST",
            url: processFile,
            data: "action=landingPage_view",
            success: function(data){
					//console.log('data = ' + data);
            		$('#content').html(data); 
                },
            error: function(msg) {
                    modal.append(msg);
                }
        });
       
	}
	
	
	
	
	
	
	$("#header_nav>.nav_item.projects_view").live("click", function(event){
		 
		event.preventDefault();
		
		$(this).addClass("active");
		$(this).siblings().removeClass('active');

		$.ajax({
		    type: "POST",
		    url: processFile,
		    data: "action=projectsPage_view",
		    success: function(data){
					// console.log('data = ' + data);
		    		$('#content').html(data); 
		        },
		    error: function(msg) {
		            modal.append(msg);
		        }
		});
	});
	
	
	
	
	
	
	$("#header_nav>.nav_item.news_view").live("click", function(event){
		 
		event.preventDefault();

		$(this).addClass("active");
		$(this).siblings().removeClass('active');
		
		$.ajax({
		    type: "POST",
		    url: processFile,
		    data: "action=newsPage_view",
		    success: function(data){
					// console.log('data = ' + data);
		    		$('#content').html(data); 
		        },
		    error: function(msg) {
		            modal.append(msg);
		        }
		});
	});
	
	

	
	$("#header_nav>.nav_item.thought_view").live("click", function(event){
		 
		event.preventDefault();

		$(this).addClass("active");
		$(this).siblings().removeClass('active');
		
		$.ajax({
		    type: "POST",
		    url: processFile,
		    data: "action=thoughtPage_view",
		    success: function(data){
					// console.log('data = ' + data);
		    		$('#content').html(data); 
		        },
		    error: function(msg) {
		            modal.append(msg);
		        }
		});
	});
	
	
	
	
	/*
	 * END NEW CONTENT
	 */
	
	
	
	

	
});


