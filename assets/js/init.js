

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
					console.log('data = ' + data);
            		$('#content').html(data); 
                },
            error: function(msg) {
                    modal.append(msg);
                }
        });
       
	}
	
	
	
	
	
	
	
	
	/*
	 * END NEW CONTENT
	 */
	
	
	
	
	
	

		
	
	$("#search_contents>.search_steps>li>a").live("click", function(event){
		
		//console.log("firing");
		fx.boxout(event);
		var panel = $('#tabs_wrapper').find("#tabs_content_container");
    	/*
		if (panel.is(":visible")) {
    		panel.slideToggle();
    	}
    	*/
	});
	
	

	
	
	
	
	/* No longer needed
	$("#map_content_container a.map_box").live("click", function(event){
		 var data = $(this)
	        .attr("href")
	        .replace(/.+?\?(.*)$/, "$1");
		var stepid = data.substr(data.indexOf("=") + 1);
		// console.log("stepid = " + stepid);
		// moveAllUsingIndex(stepid);
	});
	*/

	/* I moved this down to '#step_window .task_description>div a', seemed like it was redundant
	$("#step_window .task_description>a").live("click", function(event){
		 var data = $(this)
	        .attr("href")
	        .replace(/.+?\?(.*)$/, "$1");
		var stepid = data.substr(data.indexOf("=") + 1);
		// console.log("stepid = " + stepid);
		// moveAllUsingIndex(stepid);
		updateMap(stepid);
	});
	*/
	
	
	
	
	
	// Pulls up positions in a modal window
	$(".positions>li>div").live("click", function(event){
		
		// Stops the link from loading view.php

		event.preventDefault();
        // Adds an "active" class to the link
        $(this).parent().addClass("active");

        // Gets the query string from the link href
        var data = ""; /*$(this)
        .attr("href")
        .replace(/.+?\?(.*)$/, "$1"),*/

		// Checks if the modal window exists and
		// selects it, or creates a new one
		modal = fx.initModal();
        
        // Creates a button to close the window
        $("<a>")
            .attr("href", "#")
            .addClass("modal-close-btn")
            .click(function(event){
            	// Removes modal window
                fx.boxout(event);
            })
            .appendTo(modal);
        
        // Loads the event data from the DB
        $.ajax({
            type: "POST",
            url: processFile,
            data: "action=position_view&" + data,
            success: function(data){
            		fx.boxin(data, modal);
                },
            error: function(msg) {
                    modal.append(msg);
                }
        });
       
	});
	
	
	
	
	// Pulls up definitions in a modal window
	$(".glossary>li>div>a").live("click", function(event){
		
		// Stops the link from loading view.php

		event.preventDefault();
        // Adds an "active" class to the link
        $(this).parent().addClass("active");

        // Gets the query string from the link href
        var data = $(this)
        .attr("href")
        .replace(/.+?\?(.*)$/, "$1"),

		// Checks if the modal window exists and
		// selects it, or creates a new one
		modal = fx.initModal();
        
        // Creates a button to close the window
        $("<a>")
            .attr("href", "#")
            .addClass("modal-close-btn")
           // .html("&times;")
            .click(function(event){
            	// Removes modal window
                fx.boxout(event);
            })
            .appendTo(modal);
        
        // Loads the event data from the DB
        $.ajax({
            type: "POST",
            url: processFile,
            data: "action=definition_view&" + data,
            success: function(data){
            		fx.boxin(data, modal);
                },
            error: function(msg) {
                    modal.append(msg);
                }
        });
       
	});
	

	

	
	// Pulls up glossary terms inside Glossary UL
	$("#glossary_tabs_container>#tabs>li>a").live("click", function(event){
		
		// Stops the link from loading view.php

		event.preventDefault();
        // Adds an "active" class to the link
        $(this).parent().addClass("active");
        $(this).parent().siblings().removeClass('active');

        // Gets the query string from the link href
        var data = $(this)
        .attr("href")
        .replace(/.+?\?(.*)$/, "$1");
        
        // Loads the event data from the DB
        $.ajax({
            type: "POST",
            url: processFile,
            data: "action=glossary_view&" + data,
            success: function(data){
            		// console.log(data);
            		$('#tab1 div.glossary_container').html(data);
                },
            error: function(msg) {
                   console.log("glossary didn't work");
                }
        });
       
	});
	

	
	
	
	// Pulls up departments in a modal window
	$(".departments>li>div>a").live("click", function(event){

		// Stops the link from loading view.php

		event.preventDefault();
        // Adds an "active" class to the link
        $(this).parent().addClass("active");

        // Gets the query string from the link href
        var data = $(this)
        .attr("href")
        .replace(/.+?\?(.*)$/, "$1"),

		// Checks if the modal window exists and
		// selects it, or creates a new one
		modal = fx.initModal();
        
        // Creates a button to close the window
        $("<a>")
            .attr("href", "#")
            .addClass("modal-close-btn")
            // .html("&times;")
            .click(function(event){
            	// Removes modal window
                fx.boxout(event);
            })
            .appendTo(modal);
        
        // Loads the event data from the DB
        $.ajax({
            type: "POST",
            url: processFile,
            data: "action=department_view&" + data,
            success: function(data){
            		fx.boxin(data, modal);
                },
            error: function(msg) {
                    modal.append(msg);
                }
        });
       
	});
	


	
	
	
	// Edits steps without reloading
	$(".edit-form input[type=submit]").live("click", function(event){
		
		console.log("submit form click");

        // Prevents the default form action from executing
        event.preventDefault();
        
        //	convert the data to a query string. 
        // jQuery has a built-in method to do this called .serialize(). 
        // It will convert form inputs into a string of name-value pairs, 
        // separated by an ampersand (&).
        // Serializes the form data for use with $.ajax()
       // var formData = $(this).parents("form").serialize();
        
        var formData = new FormData($(".edit-form")[0]);
        
       // console.log($('#doc_file_path')[0].files[0]);
        
       // var length = $('#doc_file_path')[0].files;
        
	    // Stores the value of the submit button
	    submitVal = $(this).val();
	    
	    // Determines if the step should be removed
        remove = false;
	
	    // If this is the deletion form, appends an action
	    if ( $(this).attr("name")=="confirm_delete" )
	    {
	        // Adds necessary info to the query string
	     //   formData += "&action=confirm_delete"
	     //       + "&confirm_delete="+submitVal;
/// !!! If it's a formData object we need to append to it, not just concatenate a string !!!!	        
	        formData.append('action', "confirm_delete"); 
	        formData.append('confirm_delete', submitVal);

		     // If the step is really being deleted, sets
		     // a flag to remove it from the markup
            if ( submitVal=="Confirm Delete" )
            {
               remove = true;
            }
	    }
	    
	  // console.log("formData = " + formData);
	    
        // Sends the data to the processing file
        $.ajax({
            type: "POST",
            url: processFile,
            xhr: function() {  // custom xhr
                var myXhr = $.ajaxSettings.xhr();
                if(myXhr.upload){ // check if upload property exists
                    myXhr.upload.addEventListener('progress',progressHandlingFunction, false); // for handling the progress of the upload
                }
                return myXhr;
            },
            data: formData,
            cache: false,
            //  set the contentType option to false, forcing jQuery not to add a Content-Type header,
            //  otherwise, the boundary string will be missing from it
            contentType: false,
            // leave the processData flag set to false, otherwise, 
            // jQuery will try to convert the FormData into a string,
            processData: false,
          success: function(data) {
            	// If this is a deleted step, removes
                // it from the markup
                if ( remove===true )
                {
                   fx.removestep();
                }
                
               // console.log("data = " + data);
                
                // Fades out the modal window
                fx.boxout();
                
                // If this is a new step, adds it to
                // the process
               // if ( $("[name=step_id]").val().length==0  && remove===false )
               // console.log($("[name=step_id]").val());
               if ( $("[name=step_id]").val()==0  && remove===false )
               {
                    fx.addstep(data, formData);
                }
            },
            error: function(msg) {
                alert(msg);
            }
        });

	});
	
	
	function progressHandlingFunction(e){
	    if(e.lengthComputable){
	        $('progress').attr({value:e.loaded,max:e.total});
	    }
	}

	
	// Displays the steps edit form as a modal window
	$(".admin-options form, .admin").live("click", function(event){

		console.log("admin form click");

		// Prevents the form from submitting
        event.preventDefault();
        
        // Sets the action for the form submission
        var action = $(event.target).attr("name") || "edit_step";
        
        // Saves the value of the step_id input
        id = $(event.target)
        .siblings("input[name=step_id]")
            .val();
        
        // Creates an additional param for the ID if set
        id = ( id!=undefined ) ? "&step_id="+id : "";
        
        
        // Loads the editing form and displays it
        $.ajax({
            type: "POST",
            url: processFile,
            data: "action="+action+id,
            success: function(data){
                // Hides the form
                var form = $(data).hide(),

                // Make sure the modal window exists
                modal = fx.initModal()
                	.children(":not(.modal-close-btn)")
                    .remove()
                    .end();

                // Call the boxin function to create
                // the modal overlay and fade it in
                fx.boxin(null, modal);

                // Load the form into the window,
                // fades in the content, and adds
                // a class to the form
                form
                   .appendTo(modal)
                    .addClass("edit-form")
                    .fadeIn("fast");
            },
            error: function(msg){
                alert(msg);
            }
        });

    });
	
	
	// Displays the position edit form as a modal window
	$(".position-admin-options form, .position_admin").live("click", function(event){

		console.log("position admin form click");

		// Prevents the form from submitting
        event.preventDefault();
        
        // Sets the action for the form submission
        var action = $(event.target).attr("name") || "edit_position";
        
        // Saves the value of the position_id input
        id = $(event.target)
        .siblings("input[name=position_id]")
            .val();
        
        // Creates an additional param for the ID if set
        id = ( id!=undefined ) ? "&position_id="+id : "";
        
        
        // Loads the editing form and displays it
        $.ajax({
            type: "POST",
            url: processFile,
            data: "action="+action+id,
            success: function(data){
                // Hides the form
                var form = $(data).hide(),

                // Make sure the modal window exists
                modal = fx.initModal()
                	.children(":not(.modal-close-btn)")
                    .remove()
                    .end();

                // Call the boxin function to create
                // the modal overlay and fade it in
                fx.boxin(null, modal);

                // Load the form into the window,
                // fades in the content, and adds
                // a class to the form
                form
                   .appendTo(modal)
                    .addClass("position-edit-form")
                    .fadeIn("fast");
            },
            error: function(msg){
                alert(msg);
            }
        });

    });
	
	
	
	// Edits positions without reloading
	$(".position-edit-form input[type=submit]").live("click", function(event){
		
		console.log("position edit form click");

        // Prevents the default form action from executing
        event.preventDefault();
        
       // Serializes the form data for use with $.ajax()
        var formData = $(this).parents("form").serialize();
       
	    // Stores the value of the submit button
	    submitVal = $(this).val();
	    
	    // Determines if the step should be removed
        remove = false;
	
	    // If this is the deletion form, appends an action
	    if ( $(this).attr("name")=="confirm_position_delete" )
	    {
	        // Adds necessary info to the query string
	        formData += "&action=confirm_position_delete"
	            + "&confirm_position_delete="+submitVal;

		     // If the step is really being deleted, sets
		     // a flag to remove it from the markup
            if ( submitVal=="Confirm Delete" )
            {
               remove = true;
            }
	    }
	    
	    
        // Sends the data to the processing file
        $.ajax({
            type: "POST",
            url: processFile,
            data: formData,
           success: function(data) {
            	// If this is a deleted position, removes
                // it from the markup
                if ( remove===true )
                {
                   fx.removeposition();
                }
                
               // console.log("data = " + data);
                
                // Fades out the modal window
                fx.boxout();
                
                // If this is a new position, adds it to
                // the process
               // if ( $("[name=position_id]").val().length==0  && remove===false )
               // console.log($("[name=position_id]").val());
               if ( $("[name=position_id]").val()==0  && remove===false )
               {
                    fx.addposition(data, formData);
                }
            },
            error: function(msg) {
                alert(msg);
            }
        });

	});
	
	
	
	
	
	
	// Displays the definition edit form as a modal window
	$(".glossary-admin-options form, .glossary_admin").live("click", function(event){

		console.log("glossary admin form click");

		// Prevents the form from submitting
        event.preventDefault();
        
        // Sets the action for the form submission
        var action = $(event.target).attr("name") || "edit_definition";
        
        // Saves the value of the definition_id input
        id = $(event.target)
        .siblings("input[name=definition_id]")
            .val();
        
        // Creates an additional param for the ID if set
        id = ( id!=undefined ) ? "&definition_id="+id : "";
        
        
        // Loads the editing form and displays it
        $.ajax({
            type: "POST",
            url: processFile,
            data: "action="+action+id,
            success: function(data){
                // Hides the form
                var form = $(data).hide(),

                // Make sure the modal window exists
                modal = fx.initModal()
                	.children(":not(.modal-close-btn)")
                    .remove()
                    .end();

                // Call the boxin function to create
                // the modal overlay and fade it in
                fx.boxin(null, modal);

                // Load the form into the window,
                // fades in the content, and adds
                // a class to the form
                form
                   .appendTo(modal)
                    .addClass("definition-edit-form")
                    .fadeIn("fast");
            },
            error: function(msg){
                alert(msg);
            }
        });

    });
	
	
	
	// Edits definitions without reloading
	$(".definition-edit-form input[type=submit]").live("click", function(event){
		
		console.log("definitions edit form click");

        // Prevents the default form action from executing
        event.preventDefault();
        
       // Serializes the form data for use with $.ajax()
        var formData = $(this).parents("form").serialize();
       
	    // Stores the value of the submit button
	    submitVal = $(this).val();
	    
	    // Determines if the step should be removed
        remove = false;
	
	    // If this is the deletion form, appends an action
	    if ( $(this).attr("name")=="confirm_definition_delete" )
	    {
	        // Adds necessary info to the query string
	        formData += "&action=confirm_definition_delete"
	            + "&confirm_definition_delete="+submitVal;

		     // If the step is really being deleted, sets
		     // a flag to remove it from the markup
            if ( submitVal=="Confirm Delete" )
            {
               remove = true;
            }
	    }
	    
	    
        // Sends the data to the processing file
        $.ajax({
            type: "POST",
            url: processFile,
            data: formData,
           success: function(data) {
            	// If this is a deleted position, removes
                // it from the markup
                if ( remove===true )
                {
                   fx.removedefinition();
                }
                
               // console.log("data = " + data);
                
                // Fades out the modal window
                fx.boxout();
                
                // If this is a new definition, adds it to
                // the process
               if ( $("[name=definition_id]").val()==0  && remove===false )
               {
                    fx.adddefinition(data, formData);
                }
            },
            error: function(msg) {
                alert(msg);
            }
        });

	});
	
	
	
	

	
	// Displays the department edit form as a modal window
	$(".department-admin-options form, .department_admin").live("click", function(event){

		console.log("department admin form click");

		// Prevents the form from submitting
        event.preventDefault();
        
        // Sets the action for the form submission
        var action = $(event.target).attr("name") || "edit_department";
        
        // Saves the value of the department_id input
        id = $(event.target)
        .siblings("input[name=department_id]")
            .val();
        
        // Creates an additional param for the ID if set
        id = ( id!=undefined ) ? "&department_id="+id : "";
        
        
        // Loads the editing form and displays it
        $.ajax({
            type: "POST",
            url: processFile,
            data: "action="+action+id,
            success: function(data){
                // Hides the form
                var form = $(data).hide(),

                // Make sure the modal window exists
                modal = fx.initModal()
                	.children(":not(.modal-close-btn)")
                    .remove()
                    .end();

                // Call the boxin function to create
                // the modal overlay and fade it in
                fx.boxin(null, modal);

                // Load the form into the window,
                // fades in the content, and adds
                // a class to the form
                form
                   .appendTo(modal)
                    .addClass("department-edit-form")
                    .fadeIn("fast");
            },
            error: function(msg){
                alert(msg);
            }
        });

    });
	
	
	
	// Edits department without reloading
	$(".department-edit-form input[type=submit]").live("click", function(event){
		
		console.log("department edit form click");

        // Prevents the default form action from executing
        event.preventDefault();
        
        // Serializes the form data for use with $.ajax()
        var formData = $(this).parents("form").serialize();
       
	    // Stores the value of the submit button
	    submitVal = $(this).val();
	    
	    // Determines if the step should be removed
        remove = false;
	
	    // If this is the deletion form, appends an action
	    if ( $(this).attr("name")=="confirm_department_delete" )
	    {
	        // Adds necessary info to the query string
	        formData += "&action=confirm_department_delete"
	            + "&confirm_department_delete="+submitVal;

		     // If the step is really being deleted, sets
		     // a flag to remove it from the markup
            if ( submitVal=="Confirm Delete" )
            {
               remove = true;
            }
	    }
	    
	    
        // Sends the data to the processing file
        $.ajax({
            type: "POST",
            url: processFile,
            data: formData,
           success: function(data) {
            	// If this is a deleted position, removes
                // it from the markup
                if ( remove===true )
                {
                   fx.removedepartment();
                }
                
               // console.log("data = " + data);
                
                // Fades out the modal window
                fx.boxout();
                
                // If this is a new department, adds it to
                // the process
               if ( $("[name=department_id]").val()==0  && remove===false )
               {
                    fx.adddepartment(data, formData);
                }
            },
            error: function(msg) {
                alert(msg);
            }
        });

	});
	
	
	
	
    //  When user clicks on tab, this code will be executed
    $("#tabs_container>#tabs>li").click(function(event) {
    	
    	event.preventDefault();
    	
        //  Here we get the href value of the selected tab
        var selected_tab = $(this).find("a").attr("href");

        if (selected_tab.toLowerCase().indexOf("#tab") >= 0)
    	{
        	var panel = $('#tabs_wrapper').find("#footer_toggle_butt a");
        	if (!panel.hasClass("active")) {
        		toggleTabs();
        	}
       	
            //  First remove class "active" from currently active tab
            $("#tabs_container>#tabs>li").removeClass('active');
     
            //  Now add class "active" to the selected/clicked tab
            $(this).addClass("active");
     
            //  Hide all tab content
            $("#tabs_content_container>.tab_content").hide();

            //  Show the selected tab content
            $(selected_tab).fadeIn();

    	} else {  // Search tab
    		var panel = $('#tabs_wrapper').find("#footer_toggle_butt a");
        	if (panel.hasClass("active")) {
        		toggleTabs();
        	}
    	}
        
        
 
    });
    
    
	//  $("#tabs_container>#tabs>li").click(function() {
	// Pulls up search form in a modal window
	$("#tabs_container>#tabs>li>a.search_tab").live("click", function(event){
		// console.log("clicked");
		event.preventDefault();
		
		var modal = fx.initSearchModal();
		
	    // Gets the query string from the link href
        var data = $(this)
        .attr("href")
        .replace(/.+?\?(.*)$/, "$1");
		
        // Creates a button to close the window
        $("<a>")
            .attr("href", "#")
            .addClass("modal-close-btn")
            // .html("&times;")
            .click(function(event){
            	// Removes modal window
                fx.boxout(event);
            })
            .appendTo(modal);
        
        // Loads the event data from the DB
        $.ajax({
            type: "POST",
            url: processFile,
            data: "action=search_view&" + data,
            success: function(data){
            		fx.boxinsearch(data, modal);
            		//console.log('success');
                },
            error: function(msg) {
                    modal.append(msg);
                }
        });
	});
	
	
	
	// Searches database without reloading
	$(".modal-search-window input[type=submit]").live("click", function(event){
		
		console.log("Search form click");

        // Prevents the default form action from executing
        event.preventDefault();
        
        // Serializes the form data for use with $.ajax()
        var formData = $(this).parents("form").serialize();
       
	    // Stores the value of the submit button
	    submitVal = $(this).val();	    
	    
        // Sends the data to the processing file
        $.ajax({
            type: "POST",
            url: processFile,
            data: formData,
           success: function(data) {
               console.log("data = " + data);
                
                // Fades out the modal window
               //  fx.boxout();
                
        	   // console.log("sending ajax");
               
               fx.setSearchResults(data);
           },
            error: function(msg) {
                alert(msg);
            }
        });

	});
    
    
	
    //  When user clicks on tab, this code will be executed
    $("#stepslist_tabs_container>#tabs>li").click(function(event) {
    	
    	event.preventDefault();
    	
    	var panel = $('#tab3').find("#stepslist_tabs_content_container");
    	if (panel.is(":hidden")) {
    		panel.slideToggle();
    	}
    	
        //  First remove class "active" from currently active tab
        $("#stepslist_tabs_container>#tabs>li").removeClass('active');
 
        //  Now add class "active" to the selected/clicked tab
        $(this).addClass("active");
 
        //  Hide all tab content
        $("#stepslist_tabs_content_container>.tab_content").hide();
 
        //  Here we get the href value of the selected tab
        var selected_tab = $(this).find("a").attr("href");
 
        //  Show the selected tab content
        $(selected_tab).fadeIn();
       // console.log(selected_tab);
 
    });
    
    
    
    
    
    
    
    $('#tabs_wrapper').each(function() {
        var box = $(this);
        var butt = box.find('#footer_toggle_butt a');
        butt.click(function() {
           toggleTabs();
            return false;
        });
    });
    
    
    
    
    


	function findangle () {
	
		var windwidth = $("#perspective_container").width();
		//console.log(windwidth);
		var contWidth = windwidth - menuwidth;
		
		var radian = Math.acos(contWidth  / (contWidth + menuwidth));
		
		var degree = -(radian * (180/Math.PI));
		
		//console.log(degree);
		return degree;
	} 

    
    
    $('#map_toggle_butt a').click(function() {
        var box = $('#map_wrapper');
           
        if ($(this).hasClass("active")) {
        	// box.animate({left: "0px"}, 500);
        	TweenLite.to($("#overlay_container"), 0.5, {autoAlpha:1});
        	TweenLite.to(box, 0.5, {left: "0px"});
        	TweenLite.to($("#perspective_container"), 0.5, {rotationY:findangle(), transformOrigin:"right top", ease:Power2.easeOut});
        } else {
        	// box.animate({left: "-300px"}, 500);
        	TweenLite.to($("#overlay_container"), 0.5, {autoAlpha:0});
        	TweenLite.to(box, 0.5, {left: "-350px"});
    		TweenLite.to($("#perspective_container"), 0.5, {rotationY:0, transformOrigin:"right top", ease:Power2.easeOut});  
        }
        $(this).toggleClass("active");
        
        return false;
    });

    $('#overlay_container').click(function() {
    	closeOverlay();
    });
    
    
    function closeOverlay () {
    	var box = $('#map_wrapper');
    	if (!$('#map_toggle_butt a').hasClass("active")) {
	    	TweenLite.to($("#overlay_container"), 0.5, {autoAlpha:0});
	    	TweenLite.to(box, 0.5, {left: "-350px"});
			TweenLite.to($("#perspective_container"), 0.5, {rotationY:0, transformOrigin:"right top", ease:Power2.easeOut});
			$('#map_toggle_butt a').toggleClass("active");
    	}
    }
    
    
    $("a.map_box").hover(function(){
    	// console.log('hovering');
	    	var box = $(this).next(".map_tag");
	    	box.show();
	    }, 
	    function () {
	    	if (!$(this).parent().hasClass("active")) {
	    		var box = $(this).next(".map_tag");
	    		box.hide();
	    	}
	    }
    );
    
    
    
    $('.position_butt')
	    .mouseenter(function() {
	        $(this).css({'background-color':'#2b2b2b','border':'1px solid #4e4e4e'});
	    })
	    .mouseleave(function() {
	        $(this).css({'background-color':'inherit','border':'1px solid #404040'});
	    })
	    .click(function() {
	        var link = $("a", $(this));
	        if (link.length) {
	           // window.location.assign(link.attr("href"));
	            
	            // Gets the query string from the link href
	            var data = link.attr("href")
	            .replace(/.+?\?(.*)$/, "$1"),

	    		// Checks if the modal window exists and
	    		// selects it, or creates a new one
	    		modal = fx.initModal();
	            
	            // Creates a button to close the window
	            $("<a>")
	                .attr("href", "#")
	                .addClass("modal-close-btn")
	               // .html("&times;")
	                .click(function(event){
	                	// Removes modal window
	                    fx.boxout(event);
	                })
	                .appendTo(modal);
	            
	            // Loads the event data from the DB
	            $.ajax({
	                type: "POST",
	                url: processFile,
	                data: "action=position_view&" + data,
	                success: function(data){
		               		fx.boxin(data, modal);
	                		readyTaskSelectBox();
 	                    },
	                error: function(msg) {
	                        modal.append(msg);
	                    }
	            });
	        }
	    });
    

    $('.step_content .task>a.position_icon').click(function(event) {
 
    	event.preventDefault();

    	
        var link = $(this).attr('href');
        if (link.length) {
           // window.location.assign(link.attr("href"));
            
            // Gets the query string from the link href
            var data = link
            .replace(/.+?\?(.*)$/, "$1"),

           
    		// Checks if the modal window exists and
    		// selects it, or creates a new one
    		modal = fx.initModal();
            
          	console.log(data);
          	 
            
            // Creates a button to close the window
            $("<a>")
                .attr("href", "#")
                .addClass("modal-close-btn")
               // .html("&times;")
                .click(function(event){
                	// Removes modal window
                    fx.boxout(event);
                })
                .appendTo(modal);
            
            // Loads the event data from the DB
            $.ajax({
                type: "POST",
                url: processFile,
                data: "action=position_view&" + data,
                success: function(data){
                		fx.boxin(data, modal);
                		readyTaskSelectBox();
                   },
                error: function(msg) {
                        modal.append(msg);
                    }
            });
        }
    });

    /*
	//ACCORDION 
	 */
    
    $('.step_content').hide();
	 $('#step_view_container').scrollTop(0); // resets scroll feature so it doesn't get eff-d up

	 

    var elemHeight = [],
        elemOffset = [],
        currentElement = 0, //the first element
        previousScroll,
        scrollPos,
        timerObject = {a:0},
        adj = -100, // -100; // moves the step down so the previous step is visible
        moving_down = true;
        
	 
    $(".scroll_element").each(function(index)
    {
    	elemHeight.push($(this).outerHeight());
    	elemOffset.push($(this).offset().top + adj);
    });
    

	 $('.scroll_element').click(function() {
		 var curr = $('.scroll_element').index($(this));
		 // console.log(curr);
		 currentElement = curr;
		 
		 scrollPos = $(this).scrollTop();
		 previousScroll = scrollPos;
		 TweenMax.to(timerObject, .5, {a:1, onComplete:timerComplete});
	 });
	 
	 
	 $('.step_window.scroll_element').hover(
		function() {
			 var title_box = $(this).find(".title_box");			 
			 if(title_box.hasClass('highlighted')){
				 title_box.css('background-color', '#980202');
			 } else {
				 $(this).css('color', '#555555');
			 }
		 },
		function() {
			 var title_box = $(this).find(".title_box");
			 if(title_box.hasClass('highlighted')){
				 title_box.css('background-color', '#C7A9A9');
			 } else {
				 $(this).css('color', '#ACACAC');
			 }
		 }
	 );
	 
	 
	 
	// Pulls up steps in the scroll window after clicking on a link
	$(".step_content .step_tasks .task_description a").live("click", function(event){
		
        // Gets the query string from the link href
        var data = $(this)
        .attr("href")
        .replace(/.+?\?(.*)$/, "$1");
        
		// alert(data.toLowerCase());
		
        // in case there are other anchor tags other than jumping steps
		if (data.toLowerCase().indexOf("step_id") == -1) {
			return; 
		} 
		// Stops the link from loading view.php
		event.preventDefault();		

        // Adds an "active" class to the link
        $(this).parent().addClass("active");
        $(this).parent().siblings().removeClass('active');


        // Loads the event data from the DB
        $.ajax({
            type: "POST",
            url: processFile,
            data: "action=step_view&" + data,
            success: function(data){
        		if (currentElement < parseInt(data)) {
        			moving_down = true;
        		} else {
        			moving_down = false;
        		}
              	    
               	currentElement = parseInt(data); // Header is at 0 now: - 1; // zero index
          		 
           		scrollPos = $(this).scrollTop();
           		previousScroll = scrollPos;
           		TweenMax.to(timerObject, .5, {a:1, onComplete:timerComplete});
           		 
                },
            error: function(msg) {
                   // modal.append(msg);
                }
        });
        
       
	});
	
	


	
	// Pulls up steps in the scroll window from the map
	$("#map_content_container a.map_box").live("click touchstart", function(event){
		
		// Stops the link from loading view.php
		event.preventDefault();
		
        // Gets the query string from the link href
        var data = $(this)
        .attr("href")
        .replace(/.+?\?(.*)$/, "$1");

        
        // Adds an "active" class to the link
        $(this).parent().addClass("active");
        $(this).parent().siblings().removeClass('active');

        
        // Loads the event data from the DB
        $.ajax({
            type: "POST",
            url: processFile,
            data: "action=step_view&" + data,
            success: function(data){
            	
            		if (currentElement < parseInt(data)) {
            			moving_down = true;
            		} else {
            			moving_down = false;
            		}
            		currentElement = parseInt(data); // Header is at 0 now: - 1; // zero index
          		 
             	 	closeOverlay();
             	
            		scrollPos = $(this).scrollTop();
            		previousScroll = scrollPos;
            		TweenMax.to(timerObject, .5, {a:1, onComplete:timerComplete});
   
                },
            error: function(msg) {
                 //   modal.append(msg);
                }
        });
       
	});
	
	
	// Pulls up steps in the step window from the search results
	$("#search_contents>.search_steps>li>a").live("click", function(event){
		
		// Stops the link from loading view.php
		event.preventDefault();
		
        // Gets the query string from the link href
        var data = $(this)
        .attr("href")
        .replace(/.+?\?(.*)$/, "$1");

        
        // Adds an "active" class to the link
        $(this).parent().addClass("active");
        $(this).parent().siblings().removeClass('active');

        
        // Loads the event data from the DB
        $.ajax({
            type: "POST",
            url: processFile,
            data: "action=step_view&" + data,
            success: function(data){
        		if (currentElement < parseInt(data)) {
        			moving_down = true;
        		} else {
        			moving_down = false;
        		}
        		currentElement = parseInt(data); // Header is at 0 now: - 1; // zero index
         		 
         	 	closeOverlay();
         	
        		scrollPos = $(this).scrollTop();
        		previousScroll = scrollPos;
        		TweenMax.to(timerObject, .5, {a:1, onComplete:timerComplete});
               },
            error: function(msg) {
                   // modal.append(msg);
                }
        });
       
	});
	
	
	// Pulls up steps in the scroll window from the position modal window
	$(".modal-window .task_box a").live("click", function(event){
		
		// Stops the link from loading view.php
		event.preventDefault();
		
        // Gets the query string from the link href
        var data = $(this)
        .attr("href")
        .replace(/.+?\?(.*)$/, "$1");

        
        // Loads the event data from the DB
        $.ajax({
            type: "POST",
            url: processFile,
            data: "action=step_view&" + data,
            success: function(data){
	        		if (currentElement < parseInt(data)) {
	        			moving_down = true;
	        		} else {
	        			moving_down = false;
	        		}
	           		currentElement = parseInt(data); // Header is at 0 now: - 1; // zero index
	            	scrollPos = $(this).scrollTop();
            		previousScroll = scrollPos;
            		TweenMax.to(timerObject, .5, {a:1, onComplete:timerComplete});
            		
            		// Removes modal window
                    fx.boxout(event);
   
                },
            error: function(msg) {
                 //   modal.append(msg);
                }
        });
       
	});
	
	
	
	
	// Pulls up steps in the scroll window from the steps List Tab
	$(".stepslist .steps_title a").live("click", function(event){
		
		// Stops the link from loading view.php
		event.preventDefault();
		
        // Gets the query string from the link href
        var data = $(this)
        .attr("href")
        .replace(/.+?\?(.*)$/, "$1");

        
        // Loads the event data from the DB
        $.ajax({
            type: "POST",
            url: processFile,
            data: "action=step_view&" + data,
            success: function(data){
            		toggleTabs();
	        		if (currentElement < parseInt(data)) {
	        			moving_down = true;
	        		} else {
	        			moving_down = false;
	        		}
	           		currentElement = parseInt(data); // Header is at 0 now: - 1; // zero index
	            	scrollPos = $(this).scrollTop();
            		previousScroll = scrollPos;
            		TweenMax.to(timerObject, .5, {a:1, onComplete:timerComplete});
            		
            		// Removes modal window
                    fx.boxout(event);
   
                },
            error: function(msg) {
                 //   modal.append(msg);
                }
        });
       
	});
	
	
	

    $('#step_view_container').scroll(function()
    {

    	scrollPos = $(this).scrollTop();
    	//check scroll direction
    	if(previousScroll < scrollPos)//scrolling down
    	{
    		if(scrollPos > ( (elemHeight[currentElement] / 2) + elemOffset[currentElement]) )
    		{
    			currentElement++;//we passed to the next element of the collection because more than 50% of that element is visible now
    			moving_down = true;
    		}
    	}
    	else if(previousScroll > scrollPos)//scrolling up
    	{
    		if(scrollPos < ( (elemHeight[currentElement - 1] / 2) + elemOffset[currentElement - 1]) )
    		{
    			currentElement--;//we passed to the previuos element of the collection because more than 50% of that element is visible now
    			moving_down = false;
    		}
    	}
    	previousScroll = scrollPos;
    	TweenMax.to(timerObject, .5, {a:1, onComplete:timerComplete});
		//console.log("scroll called");
    });

    function timerComplete()
    {
    	//We scroll the window, or other element with an overflow property, to the top offset position of the current element
    	//that has more than 50% showing on the screen.
    	TweenMax.to($('#step_view_container'), .2, {scrollTo:{y:elemOffset[currentElement]}, ease:Power1.easeOut});
   		openAccordion(currentElement);
		//console.log("timerComplete called");
    }
    
	
    function openAccordion (element) {
    	
    	var speed = 400; //400;
   	
    	//console.log("index = " + $('#step_view_container .on').index('div.scroll_element') + " element = " + element);
    	
    	if ($('#step_view_container .on').index('div.scroll_element') != element) {
    		
    		var curr = $('.scroll_element').eq(element);
    		
    		//console.log("element = " + element);
   		    		
			//NO MATTER WHAT WE CLOSE ALL OPEN SLIDES
    		if (moving_down == true) {
    			$('.step_content').hide(); // changes the way the steps appear
    		} else {
       			$('.step_content').slideUp(speed);
       		}
		 	//$('.step_content').css('display', 'none');
		
		 	//REMOVE THE ON CLASS FROM ALL BUTTONS
			$('.scroll_element').removeClass('on');
			$('.scroll_element').show();
			  
			//IF THE NEXT SLIDE WASN'T OPEN THEN OPEN IT
			if(curr.next().is(':hidden') == true) {  // }&& win_loaded == true) {
				
				//ADD THE ON CLASS TO THE BUTTON
				curr.addClass('on');
				
				curr.hide();
				
				// console.log(curr.next().css("height"));
				  
				//OPEN THE SLIDE
				curr.next().slideDown(speed); //'normal');
					
				//console.log(curr.data('stepid'));
				updateMap(curr.data('stepid'));					
			 } 
			// console.log("openAccordion called");
	    }
	    	
		
	}
    
    
    function toggleTabs () {
    	
        var box = $("#tabs_wrapper");
        var butt = box.find('#footer_toggle_butt a');
            
        if (butt.hasClass("active")) {
        	var targetHeight = box.parent().height() - 58;
        	TweenMax.to(box, .2, {top:targetHeight, ease:Power1.easeOut});
        	// butt.css({'backgroundPosition': '0px 0px'});
        	butt.css({"background-image": "url('assets/images/footerToggleButt.gif')"}); 
        } else {
        	TweenMax.to(box, .2, {top:"0px", ease:Power1.easeOut});
        	// butt.css({'backgroundPosition': '0px -58px'});
        	butt.css({"background-image": "url('assets/images/footerToggleButt_up.gif')"}); 
        }
        butt.toggleClass("active");            
    }
    
    
    function updateMap (stepid) {
		var $map = $('#map_content_container>.steps_map');
		$map.children().each(function () {
			var link = $(this).find('.map_box').attr('href');
			var id = link.substr(link.indexOf("=") + 1);
		    if (stepid == id) {
		    	$(this).addClass("active");
		    	var box = $(this).find(".map_tag");
		    	box.show();
		    } else {
		    	$(this).removeClass('active');
		    	var box = $(this).find(".map_tag");
		    	box.hide();
		    }
		});
		
	}
    
    
    

	
	function readyTaskSelectBox () {
		
		$('#task_select').fancySelect();
		
		$('.task_box').hide();
		
	    $('#task0').show();
	    
	    $('#task_select').change(function () {
	        $('.task_box').hide();
	        $('#'+$(this).val()).show();
	    });
	}
	
	
	$(window).resize(function() {
		var box = $("#tabs_wrapper");
        var butt = box.find('#footer_toggle_butt a');
            
        if (butt.hasClass("active")) {
        	//TweenMax.to(box, .2, {top:"0px", ease:Power1.easeOut});
        } else {
           	var targetHeight = box.parent().height() - 58;
        	//TweenMax.to(box, .2, {top:targetHeight, ease:Power1.easeOut});
        }   
        $("#step_view_container").css({'height': box.parent().height() - 58 });
	});
	
	/*
	if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
		 // some code..
	} else {
		
	}
	*/
	
	if ('ontouchstart' in document) {
	    $('body').removeClass('no-touch');
	}
	
	function moveScrollUp () {
    	scrollPos = $('#step_view_container').scrollTop();
    	currentElement--;
    	moving_down = false;
    	previousScroll = scrollPos;
    	TweenMax.to(timerObject, .5, {a:1, onComplete:timerComplete});
	}
	
	function moveScrollDown () {
    	scrollPos = $('#step_view_container').scrollTop();
    	currentElement++;
    	moving_down = true;
    	previousScroll = scrollPos;
    	TweenMax.to(timerObject, .5, {a:1, onComplete:timerComplete});
		
	}
	
});

$(document).keydown(function(e){
    if (e.keyCode == 38) { 
  //  	moveScrollUp();
    	return false;
    }
    if (e.keyCode == 40) { 
 //   	moveScrollDown();
    	return false;
    }
});


