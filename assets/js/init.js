

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
            if ($(".modal-window").length) {
	            $(".modal-window")
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
	
	

	
	$("#header_wrapper>.clLogo").click(function(event) {
		loadLandingPage();
	});
	
	
	
	function loadLandingPage() {
		
	    // Loads the event data from the DB
        $.ajax({
            type: "POST",
            url: processFile,
            data: "action=landingPage_view",
            success: function(data){
					//console.log('data = ' + data);
            		$( "#modal_background").remove();
            		$('#content').html(data); 
            		shouldLoadEditor("div#greeting", 'full');
                },
            error: function(msg) {
                    modal.append(msg);
                }
        });
	}
	
	
	
	function loadFullEditor(sel) {
		tinymce.init({
		    selector: sel,
		    inline: true,
		    plugins: [
		        "autolink lists link charmap anchor",
		        "searchreplace visualblocks code",
		        "insertdatetime paste"
		    ],
		    toolbar: "undo redo | bold italic | charmap | link"
		});
	}
	
	
	
	function loadMinimalEditor(sel) {
		console.log("loadMinimalEditor(");
		tinymce.init({
		    selector: sel,
		    inline: true,
		    plugins: "charmap",
		    toolbar: "undo redo | charmap",
		    menubar: false
		});
	}

	
	
	function loadLinkEditor(sel) {
		tinymce.init({
			  selector: sel, 
			  inline: true,
			  plugins: "link",
          toolbar: "link",
			  menubar: false
			});
	}
	
	
	function loadImageEditor(sel) {
		tinymce.init({
			  selector: sel, 
			   inline: true,
			  plugins: [
			    "jbimages"
			  ],
			  toolbar: "jbimages",
			  menubar: false,
			  relative_urls: false
			});
	}
	
	
	
	function shouldLoadEditor(sel, type) {
		
		console.log("shouldLoadEditor(");
		
		$.ajax( {
		      type:'GET',
		      url:'assets/inc/session.inc.php',
		      success: function(data){
		    	  if( data == "Expired" ) {
				       return false;
				   } else if (data == "Active" ) {
					   
					   switch (type) {
					   case 'full':
						   loadFullEditor(sel);
					     break;
					   case 'minimal':
						   loadMinimalEditor(sel);
					     break;
					   case 'link':
						  loadLinkEditor(sel);
					     break;
					   case 'image':
						  loadImageEditor(sel);
					     break;
					   }
					   
					   return true;
				   }
		      }
		   }
		);
	}
	
	
	
	
	
	
	
	$(".client-admin-options>form>.admin").live("click", function(event){

		event.preventDefault();
				
		console.log($(this).parent().parent().siblings('.logo_img').find('.logo').attr('src'));

		var logo_url = "&logo_url="+encodeURIComponent($(this).parent().parent().siblings('.logo_img').find('img').attr('src'));
        var client = "&client="+encodeURIComponent($(this).parent().parent().siblings('.client').html());
        var tagline = "&tagline="+encodeURIComponent($(this).parent().parent().siblings('.tagline').html());
        var copy = "&copy="+encodeURIComponent($(this).parent().parent().siblings('.copy').html());
        var cta_url = "&cta_url="+encodeURIComponent($(this).parent().parent().siblings('.cta').html()); //.find('a').attr('href'));

		// Sets the action for the form submission
        var action = $(event.target).attr("name") || "edit_client";
        
        // Saves the value of the greeting_id input
        id = $("input[name=client_id]").val();
        
        // Creates an additional param for the ID if set
        id = ( id!=undefined ) ? "&client_id="+id : "";
        
        var data = logo_url + client + tagline + copy + cta_url;
        
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
	
	
	
	
	function initProjectsPage() {
		
		shouldLoadEditor("div.logo_img", 'image');
		shouldLoadEditor(".client_info>div.cta", 'link');
		shouldLoadEditor("div.client", 'minimal');
		shouldLoadEditor("div.tagline", 'minimal');
		shouldLoadEditor("div.copy", 'full');

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
		    		initProjectsPage();
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
	
	
	
	
	
	// Displays the client edit form as a modal window
	$(".client-admin-options form input[type=submit]").live("click", function(event){

			console.log("client admin form click");

			// Prevents the form from submitting
	        event.preventDefault();
	        
	        // Sets the action for the form submission
	        var action = $(event.target).attr("name") || "delete_client";
	        
	        // Saves the value of the step_id input
	        id = $(event.target)
	        .siblings("input[name=client_id]")
	            .val();
	        
	        // Creates an additional param for the ID if set
	        id = ( id!=undefined ) ? "&client_id="+id : "";
	        
	        
	        // Loads the editing form and displays it
	        $.ajax({
	            type: "POST",
	            url: processFile,
	            data: "action="+action+id,
	            success: function(data){
	                // Hides the form
	            	var form = $(data).hide();
	            	
	            //	console.log(data);

	                // Make sure the modal window exists
	               var  modal = fx.initModal()
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
	
	
	
	
	
	
	$(".client_delete.edit-form input[type=submit]").live("click", function(event){
		
		console.log("delete client form click");

        // Prevents the default form action from executing
        event.preventDefault();
        
       // Serializes the form data for use with $.ajax()
        var formData = $(this).parents("form").serialize();
       
	    // Stores the value of the submit button
	    submitVal = $(this).val();
	    
	    // Determines if the client should be removed
        remove = false;
	
	    // If this is the deletion form, appends an action
	    if ( $(this).attr("name")=="confirm_client_delete" )
	    {
	        // Adds necessary info to the query string
	        formData += "&action=confirm_client_delete"
	            + "&confirm_client_delete="+submitVal;

		     // If the client is really being deleted, sets
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
                
               console.log("data = " + data);
                
                // Fades out the modal window
                fx.boxout();
                
                /*
                // If this is a new client, adds it to
                // the process
               if ( $("[name=client_id]").val()==0  && remove===false )
               {
                    fx.adddefinition(data, formData);
                }
                */
            },
            error: function(msg) {
                alert(msg);
            }
        });

	});

	
	
	
	

	
});


