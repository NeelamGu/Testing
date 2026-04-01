$(document).ready(function(){

	$('.tags').tagsinput({
    	allowDuplicates: true
    });

	//$(".allnorway").hide();
	$('input[type=radio][name=all_norway]').change(function() {
				var all_norway = $('input[type=radio][name=all_norway]:checked').val();
				if(all_norway=="all"){
					$(".allnorway").hide();
				}else{
					$(".allnorway").show();
				}
			});

	$('input[type=checkbox][name=deliverToAll]').change(function() {
		var deliverToAll = $('input[type=checkbox][name=deliverToAll]:checked').val();
		if(deliverToAll=="Yes"){
			$(".radiusAll").val("2500");	
		}else{
			$(".radiusAll").val("");
		}
	});

	$("#checkAll").change(function () {
    $("input:checkbox").prop('checked', $(this).prop("checked"));
});

	$('input[type="checkbox"]').change(function(e) {

  var checked = $(this).prop("checked"),
      container = $(this).parent(),
      siblings = container.siblings();

  container.find('input[type="checkbox"]').prop({
    indeterminate: false,
    checked: checked
  });

  function checkSiblings(el) {

    var parent = el.parent().parent(),
        all = true;

    el.siblings().each(function() {
      return all = ($(this).children('input[type="checkbox"]').prop("checked") === checked);
    });

    if (all && checked) {

      parent.children('input[type="checkbox"]').prop({
        indeterminate: false,
        checked: checked
      });

      checkSiblings(parent);

    } else if (all && !checked) {

      parent.children('input[type="checkbox"]').prop("checked", checked);
      parent.children('input[type="checkbox"]').prop("indeterminate", (parent.find('input[type="checkbox"]:checked').length > 0));
      checkSiblings(parent);

    } else {

      el.parents("li").children('input[type="checkbox"]').prop({
        indeterminate: true,
        checked: false
      });

    }

  }

  checkSiblings(container);
});




	// Load Cities for Pincodes in Enquiry Form
	$('#norway_pincode').on('keyup', function() {
        if (this.value.length >= 4) {
            var pincode = $(this).val();
            $.ajax({
                type : 'get',
                data : {pincode:pincode},
                url : '/get-city',
                success:function(resp){
                    $('#load_city').val(resp.city);
                },
                error:function(){
                    //nothing to do
                }
            })
        }
    });

	// Load Cities & States for Pincodes in Enquiry Form
	$('#norway_pincodes').on('keyup', function() {
        if (this.value.length >= 4) {
            var pincode = $(this).val();
            $.ajax({
                type : 'get',
                data : {pincode:pincode},
                url : '/get-city-state',
                success:function(resp){
                    $('#load_city').val(resp.city);
                    $('#load_state').val(resp.state);
                },
                error:function(){
                    //nothing to do
                }
            })
        }
    });

	// call datatable class
	$('#admins').DataTable();
	$('#sections').DataTable();
	$('#categoriess').DataTable();
	$('#brands').DataTable();
	$('#products').DataTable();
	$('#banners').DataTable();
	$('#filters').DataTable();
	$('#users').DataTable();
	$('#coupons').DataTable();
	$('#pages').DataTable();
	$('#products_enquiries').DataTable();
	$('#events').DataTable();
	$('#ratings').DataTable();
	$('#plans').DataTable();
	$('#subscribers').DataTable();
	$('#products_enquiries_all').DataTable({
        /*// Define default sorting
        order: [[0, 'desc']], // First column (index 0), descending order
        columnDefs: [
            { type: 'updated_at', targets: 0 } // Specify the type as 'date' for the first column
        ]*/
				// Disable initial sorting
				order: []
    });

	$("#admins").DataTable({
      "order": [[ 0, "desc" ]], //or asc 
      "bDestroy": true
    });
    $("#sections").DataTable({
      "order": [[ 0, "desc" ]], //or asc 
      "bDestroy": true
    });
    $("#categoriess").DataTable({
      "order": [[ 0, "desc" ]], //or asc 
      "bDestroy": true
    });
    $("#brands").DataTable({
      "order": [[ 0, "desc" ]], //or asc 
      "bDestroy": true
    });
    $("#products").DataTable({
      "order": [[ 0, "desc" ]], //or asc 
      "bDestroy": true 
    });
    $("#banners").DataTable({
      "order": [[ 0, "desc" ]], //or asc 
      "bDestroy": true
    });
    $("#filters").DataTable({
      "order": [[ 0, "desc" ]], //or asc 
      "bDestroy": true
    });
    $("#users").DataTable({
      "order": [[ 0, "desc" ]], //or asc 
      "bDestroy": true
    });
    $("#subscribers").DataTable({
      "order": [[ 0, "desc" ]], //or asc 
      "bDestroy": true
    });
    $("#coupons").DataTable({
      "order": [[ 0, "desc" ]], //or asc 
      "bDestroy": true
    });
    $("#pages").DataTable({
      "order": [[ 0, "desc" ]], //or asc 
      "bDestroy": true
    });
    $("#products_enquiries").DataTable({
      "order": [[ 0, "desc" ]], //or asc
      "bDestroy": true 
    });
    /*$("#products_enquiries_all").DataTable({
      "order": [[ 0, "desc" ]], //or asc
      "bDestroy": true 
    });*/
    $("#all_enquiries").DataTable({
      "order": [[ 0, "desc" ]], //or asc
      "bDestroy": true 
    });
    $("#events").DataTable({
      "order": [[ 0, "desc" ]], //or asc 
      "bDestroy": true
    });
    $("#ratings").DataTable({
      "order": [[ 0, "desc" ]], //or asc 
      "bDestroy": true
    });


	// Setup - add a text input to each footer cell
	$('#categoriess tfoot th').each( function () {
	    var title = $(this).text();
	    $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
	} );

	// DataTable
 	var cattable = $('#categoriess').DataTable();

 	// Apply the search
	 cattable.columns().every( function () {
	 
	     var that = this;
	     $( 'input', this.footer() ).on( 'keyup change', function () {
	         if ( that.search() !== this.value ) {
	             that
	                 .search( this.value )
	                 .draw();
	         }
	     } );
	 } );

	///////////////////////

 	// Setup - add a text input to each footer cell
	$('#products tfoot th').each( function () {
	    var title = $(this).text();
	    $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
	} );

	// DataTable
 	var protable = $('#products').DataTable();

	 // Apply the search
	 protable.columns().every( function () {
	 
	     var that = this;
	     $( 'input', this.footer() ).on( 'keyup change', function () {
	         if ( that.search() !== this.value ) {
	             that
	                 .search( this.value )
	                 .draw();
	         }
	     } );
	 } );

	///////////////////////

		// Setup - add a text input to each footer cell before DataTable initializes
    $('#adminss tfoot th').each(function() {
        var title = $(this).text();
        $(this).html('<input type="text" placeholder="Search ' + title + '" />');
    });

    // Initialize DataTable with default sorting on the first column (Admin ID) in descending order
    var protable = $('#adminss').DataTable({
        "order": [[0, "desc"]],      // Set initial sorting
        "pageLength": 10,            // Optional: Set default page length
        "lengthChange": true,        // Optional: Show length change option
        "searching": true,           // Enable search
        "autoWidth": false,          // Prevent DataTable from auto-adjusting column widths
        "stateSave": false           // Disable state saving if enabled elsewhere
    });

    // Reapply the descending order after DataTable is fully initialized
    setTimeout(function() {
        protable.order([0, 'desc']).draw();
    }, 1000); // 5000ms delay ensures sorting is maintained

    // Apply search filter on table columns
    protable.columns().every(function() {
        var that = this;
        $('input', this.footer()).on('keyup change', function() {
            if (that.search() !== this.value) {
                that.search(this.value).draw();
            }
        });
    });

	 ///////////////////////

	 // Setup - add a text input to each footer cell
	$('#plans tfoot th').each( function () {
	    var title = $(this).text();
	    $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
	} );

	// DataTable
 	var plantable = $('#plans').DataTable();

 	// Apply the search
	 plantable.columns().every( function () {
	 
	     var that = this;
	     $( 'input', this.footer() ).on( 'keyup change', function () {
	         if ( that.search() !== this.value ) {
	             that
	                 .search( this.value )
	                 .draw();
	         }
	     } );
	 } );

	 ///////////////////////

	 // Setup - add a text input to each footer cell
	$('#products_enquiries tfoot th').each( function () {
	    var title = $(this).text();
	    $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
	} );

	// DataTable
 	var proenquirytable = $('#products_enquiries').DataTable();

 	// Apply the search
	 proenquirytable.columns().every( function () {
	 
	     var that = this;
	     $( 'input', this.footer() ).on( 'keyup change', function () {
	         if ( that.search() !== this.value ) {
	             that
	                 .search( this.value )
	                 .draw();
	         }
	     } );
	 } );

	$(".nav-item").removeClass("active");
	$(".nav-link").removeClass("active");
	$(".itemCity").show();

	// Check Admin Password is correct or not
	$("#current_password").keyup(function(){
		var current_password = $("#current_password").val();
		/*alert(current_password);*/
		$.ajax({
			headers: {
        		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    		},
			type:'post',
			url:'/admin/check-admin-password',
			data:{current_password:current_password},
			success:function(resp){
				if(resp=="false"){
					$("#check_password").html("<font color='red'>Current Password is Incorrect!</font>");
				}else if(resp=="true"){
					$("#check_password").html("<font color='green'>Current Password is Correct!</font>");
				}
			},error:function(){
				alert('Error');
			}

		});
	})

	// Update Admin Status
	$(document).on("click",".updateAdminStatus",function(){
		$('.PleaseWaitDiv').show();
		var status = $(this).children("i").attr("status");
		var admin_id = $(this).attr("admin_id");
		$.ajax({
			headers: {
        		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    		},
			type:'post',
			url:'/admin/update-admin-status',
			data:{status:status,admin_id:admin_id},
			success:function(resp){
				$('.PleaseWaitDiv').hide();
				// alert(resp);
				if(resp['status']==0){
					$("#admin-"+admin_id).html("<i style='font-size:18px; color: #000;' class='mdi mdi-bookmark-outline' status='Inactive'></i>Inactive");
				}else if(resp['status']==1){
					$("#admin-"+admin_id).html("<i style='font-size:18px; color: #000;' class='mdi mdi-bookmark-check' status='Active'></i>Active");
				}
			},error:function(){
				$('.PleaseWaitDiv').hide();
				//alert("Error");
			}
		})
	});

	// Update Enquiry Status for Pin/Unpin
	$(document).on("click",".updatePinStatus",function(){
		$('.PleaseWaitDiv').show();
		var status = $(this).children("i").attr("status");
		var enquiry_id = $(this).attr("enquiry_id");
		$.ajax({
			headers: {
        		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    		},
			type:'post',
			url:'/admin/update-pin-status',
			data:{status:status,enquiry_id:enquiry_id},
			success:function(resp){
				$('.PleaseWaitDiv').hide();
				// alert(resp);
				if(resp['status']==0){
					$("#enquiry-"+enquiry_id).html("<i style='font-size:18px; color: #000;' class='mdi mdi-bookmark-outline' status='Inactive'></i>Unpin");
				}else if(resp['status']==1){
					$("#enquiry-"+enquiry_id).html("<i style='font-size:18px; color: #000;' class='mdi mdi-bookmark-check' status='Active'></i>Pin");
				}
			},error:function(){
				$('.PleaseWaitDiv').hide();
				//alert("Error");
			}
		})
	});

	// Update User Status
	$(document).on("click",".updateUserStatus",function(){
		var status = $(this).children("i").attr("status");
		var user_id = $(this).attr("user_id");
		$.ajax({
			headers: {
        		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    		},
			type:'post',
			url:'/admin/update-user-status',
			data:{status:status,user_id:user_id},
			success:function(resp){
				// alert(resp);
				if(resp['status']==0){
					$("#user-"+user_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-outline' status='Inactive'></i>");
				}else if(resp['status']==1){
					$("#user-"+user_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-check' status='Active'></i>");
				}
			},error:function(){
				//alert("Error");
			}
		})
	});

	// Update Subscriber Status
	$(document).on("click",".updateSubscriberStatus",function(){
		var status = $(this).children("i").attr("status");
		var user_id = $(this).attr("user_id");
		$.ajax({
			headers: {
        		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    		},
			type:'post',
			url:'/admin/update-subscriber-status',
			data:{status:status,user_id:user_id},
			success:function(resp){
				// alert(resp);
				if(resp['status']==0){
					$("#user-"+user_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-outline' status='Inactive'></i>");
				}else if(resp['status']==1){
					$("#user-"+user_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-check' status='Active'></i>");
				}
			},error:function(){
				//alert("Error");
			}
		})
	});

	// Update Rating Status
	$(document).on("click",".updateRatingStatus",function(){
		var status = $(this).children("i").attr("status");
		var rating_id = $(this).attr("rating_id");
		$.ajax({
			headers: {
        		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    		},
			type:'post',
			url:'/admin/update-rating-status',
			data:{status:status,rating_id:rating_id},
			success:function(resp){
				// alert(resp);
				if(resp['status']==0){
					$("#rating-"+rating_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-outline' status='Inactive'></i>");
				}else if(resp['status']==1){
					$("#rating-"+rating_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-check' status='Active'></i>");
				}
			},error:function(){
				//alert("Error");
			}
		})
	});

	// Update Plan Status
	$(document).on("click",".updatePlanStatus",function(){
		var status = $(this).children("i").attr("status");
		var plan_id = $(this).attr("plan_id");
		$.ajax({
			headers: {
        		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    		},
			type:'post',
			url:'/admin/update-plan-status',
			data:{status:status,plan_id:plan_id},
			success:function(resp){
				// alert(resp);
				if(resp['status']==0){
					$("#plan-"+plan_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-outline' status='Inactive'></i>");
				}else if(resp['status']==1){
					$("#plan-"+plan_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-check' status='Active'></i>");
				}
			},error:function(){
				//alert("Error");
			}
		})
	});

	// Update Banner Status
	$(document).on("click",".updateBannerStatus",function(){
		var status = $(this).children("i").attr("status");
		var banner_id = $(this).attr("banner_id");
		$.ajax({
			headers: {
        		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    		},
			type:'post',
			url:'/admin/update-banner-status',
			data:{status:status,banner_id:banner_id},
			success:function(resp){
				// alert(resp);
				if(resp['status']==0){
					$("#banner-"+banner_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-outline' status='Inactive'></i>");
				}else if(resp['status']==1){
					$("#banner-"+banner_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-check' status='Active'></i>");
				}
			},error:function(){
				//alert("Error");
			}
		})
	});

	// Update Event Status
	$(document).on("click",".updateEventStatus",function(){
		var status = $(this).children("i").attr("status");
		var event_id = $(this).attr("event_id");
		$.ajax({
			headers: {
        		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    		},
			type:'post',
			url:'/admin/update-event-status',
			data:{status:status,event_id:event_id},
			success:function(resp){
				// alert(resp);
				if(resp['status']==0){
					$("#event-"+event_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-outline' status='Inactive'></i>");
				}else if(resp['status']==1){
					$("#event-"+event_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-check' status='Active'></i>");
				}
			},error:function(){
				//alert("Error");
			}
		})
	});

	// Update CMS Pages Status
	$(document).on("click",".updateCMSPagesStatus",function(){
		var status = $(this).children("i").attr("status");
		var page_id = $(this).attr("page_id");
		$.ajax({
			headers: {
        		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    		},
			type:'post',
			url:'/admin/update-cms-page-status',
			data:{status:status,page_id:page_id},
			success:function(resp){
				// alert(resp);
				if(resp['status']==0){
					$("#page-"+page_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-outline' status='Inactive'></i>");
				}else if(resp['status']==1){
					$("#page-"+page_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-check' status='Active'></i>");
				}
			},error:function(){
				//alert("Error");
			}
		})
	});

	// Update Section Status
	$(document).on("click",".updateSectionStatus",function(){
		var status = $(this).children("i").attr("status");
		var section_id = $(this).attr("section_id");
		$.ajax({
			headers: {
        		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    		},
			type:'post',
			url:'/admin/update-section-status',
			data:{status:status,section_id:section_id},
			success:function(resp){
				// alert(resp);
				if(resp['status']==0){
					$("#section-"+section_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-outline' status='Inactive'></i>");
				}else if(resp['status']==1){
					$("#section-"+section_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-check' status='Active'></i>");
				}
			},error:function(){
				//alert("Error");
			}
		})
	});

	// Update Category Status
	$(document).on("click",".updateCategoryStatus",function(){
		var status = $(this).children("i").attr("status");
		var category_id = $(this).attr("category_id");
		$.ajax({
			headers: {
        		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    		},
			type:'post',
			url:'/admin/update-category-status',
			data:{status:status,category_id:category_id},
			success:function(resp){
				// alert(resp);
				if(resp['status']==0){
					$("#category-"+category_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-outline' status='Inactive'></i>");
				}else if(resp['status']==1){
					$("#category-"+category_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-check' status='Active'></i>");
				}
			},error:function(){
				//alert("Error");
			}
		})
	});

	// Update Brand Status
	$(document).on("click",".updateBrandStatus",function(){
		var status = $(this).children("i").attr("status");
		var brand_id = $(this).attr("brand_id");
		$.ajax({
			headers: {
        		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    		},
			type:'post',
			url:'/admin/update-brand-status',
			data:{status:status,brand_id:brand_id},
			success:function(resp){
				// alert(resp);
				if(resp['status']==0){
					$("#brand-"+brand_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-outline' status='Inactive'></i>");
				}else if(resp['status']==1){
					$("#brand-"+brand_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-check' status='Active'></i>");
				}
			},error:function(){
				//alert("Error");
			}
		})
	});

	// Update Product Status
	$(document).on("click",".updateProductStatus",function(){
		var status = $(this).children("i").attr("status");
		var product_id = $(this).attr("product_id");
		$.ajax({
			headers: {
        		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    		},
			type:'post',
			url:'/admin/update-product-status',
			data:{status:status,product_id:product_id},
			success:function(resp){
				// alert(resp);
				if(resp['status']==0){
					$("#product-"+product_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-outline' status='Inactive'></i>");
				}else if(resp['status']==1){
					$("#product-"+product_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-check' status='Active'></i>");
				}
			},error:function(){
				//alert("Error");
			}
		})
	});

	// Update Filter Status
	$(document).on("click",".updateFilterStatus",function(){
		var status = $(this).children("i").attr("status");
		var filter_id = $(this).attr("filter_id");
		$.ajax({
			headers: {
        		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    		},
			type:'post',
			url:'/admin/update-filter-status',
			data:{status:status,filter_id:filter_id},
			success:function(resp){
				// alert(resp);
				if(resp['status']==0){
					$("#filter-"+filter_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-outline' status='Inactive'></i>");
				}else if(resp['status']==1){
					$("#filter-"+filter_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-check' status='Active'></i>");
				}
			},error:function(){
				//alert("Error");
			}
		})
	});

	// Update Filter Status
	$(document).on("click",".updateFilterValueStatus",function(){
		var status = $(this).children("i").attr("status");
		var filter_id = $(this).attr("filter_id");
		$.ajax({
			headers: {
        		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    		},
			type:'post',
			url:'/admin/update-filter-value-status',
			data:{status:status,filter_id:filter_id},
			success:function(resp){
				// alert(resp);
				if(resp['status']==0){
					$("#filter-"+filter_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-outline' status='Inactive'></i>");
				}else if(resp['status']==1){
					$("#filter-"+filter_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-check' status='Active'></i>");
				}
			},error:function(){
				//alert("Error");
			}
		})
	});

	// Update Attribute Status
	$(document).on("click",".updateAttributeStatus",function(){
		var status = $(this).children("i").attr("status");
		var attribute_id = $(this).attr("attribute_id");
		$.ajax({
			headers: {
        		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    		},
			type:'post',
			url:'/admin/update-attribute-status',
			data:{status:status,attribute_id:attribute_id},
			success:function(resp){
				// alert(resp);
				if(resp['status']==0){
					$("#attribute-"+attribute_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-outline' status='Inactive'></i>");
				}else if(resp['status']==1){
					$("#attribute-"+attribute_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-check' status='Active'></i>");
				}
			},error:function(){
				//alert("Error");
			}
		})
	});

	// Update Image Status
	$(document).on("click",".updateImageStatus",function(){
		var status = $(this).children("i").attr("status");
		var image_id = $(this).attr("image_id");
		$.ajax({
			headers: {
        		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    		},
			type:'post',
			url:'/admin/update-image-status',
			data:{status:status,image_id:image_id},
			success:function(resp){
				// alert(resp);
				if(resp['status']==0){
					$("#image-"+image_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-outline' status='Inactive'></i>");
				}else if(resp['status']==1){
					$("#image-"+image_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-check' status='Active'></i>");
				}
			},error:function(){
				//alert("Error");
			}
		})
	});

	// Confirm Deletion (Simple Javascript)
	/*$(".confirmDelete").click(function(){
		var title = $(this).attr("title");
		if(confirm("Are you sure to delete this "+title+"?")){
			return true;
		}else{
			return false;
		}
	})*/

	// Confirm Deletion (SweetAlert Library)
	$(document).on("click",".confirmDelete",function(){	
		var module = $(this).attr('module');
		var moduleid = $(this).attr('moduleid');
		Swal.fire({
		  title: 'Are you sure?',
		  text: "You won't be able to revert this!",
		  icon: 'warning',
		  showCancelButton: true,
		  confirmButtonColor: '#3085d6',
		  cancelButtonColor: '#d33',
		  confirmButtonText: 'Yes, delete it!'
		}).then((result) => {
		  if (result.isConfirmed) {
		    Swal.fire(
		      'Success',
		      'Bildet er slettet.',
		      'success'
		    )
		    window.location = "/admin/delete-"+module+"/"+moduleid;
		  }
		})
	})

	

	// Set scroll flag when "Add Captions" button is clicked
    document.querySelector('.scroll-to-captions')?.addEventListener('click', function () {
        localStorage.setItem('scrollToCaptions', 'true');
    });

    // Set scroll flag when delete (only image) is clicked
    document.addEventListener('click', function (e) {
        const el = e.target.closest('.confirmDelete');
        if (el && el.getAttribute('module') === 'image') {
            localStorage.setItem('scrollToCaptions', 'true');
        }
    });

    // Unified scroll handler after reload
    window.addEventListener('load', function () {
        if (localStorage.getItem('scrollToCaptions') === 'true') {
            const el = document.getElementById('image-captions');
            if (el) {
                el.scrollIntoView({ behavior: 'smooth' });
            } else {
                // If ID is not found, fallback scroll to bottom
                window.scrollTo({ top: document.body.scrollHeight, behavior: 'smooth' });
            }
            localStorage.removeItem('scrollToCaptions');
        }
    });



	// Append Categories level
	$("#section_id").change(function(){
		var section_id = $(this).val();
		$.ajax({
			headers: {
        		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    		},
			type:'get',
			url:'/admin/append-categories-level',
			data:{section_id:section_id},
			success:function(resp){
				$("#appendCategoriesLevel").html(resp);
			},error:function(){
				//alert("Error");
			}
		})
	});

	// Products Attributes Add/Remove Script
	var maxField = 10; //Input fields increment limitation
    var addButton = $('.add_button'); //Add button selector
    var wrapper = $('.field_wrapper'); //Input field wrapper
    var fieldHTML = '<div><div style="height:10px;"></div><input type="text" name="size[]" placeholder="Size" style="width: 120px;"/>&nbsp;<input type="text" name="sku[]" placeholder="SKU" style="width: 120px;"/>&nbsp;<input type="text" name="price[]" placeholder="Price" style="width: 120px;"/>&nbsp;<input type="text" name="stock[]" placeholder="Stock" style="width: 120px;"/>&nbsp;<a href="javascript:void(0);" class="remove_button">Remove</div>'; //New input field html 
    var x = 1; //Initial field counter is 1
    
    //Once add button is clicked
    $(addButton).click(function(){
        //Check maximum number of input fields
        if(x < maxField){ 
            x++; //Increment field counter
            $(wrapper).append(fieldHTML); //Add field html
        }
    });
    
    //Once remove button is clicked
    $(wrapper).on('click', '.remove_button', function(e){
        e.preventDefault();
        $(this).parent('div').remove(); //Remove field html
        x--; //Decrement field counter
    });

    // Show Filters on selection of Category
    $("#category_id").on('change',function(){
    	var category_id = $(this).val();
    	/*alert(category_id);*/
    	$.ajax({
    		headers: {
        		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    		},
    		type:'post',
    		url:'category-filters',
    		data:{category_id:category_id},
    		success:function(resp){
    			$(".loadFilters").html(resp.view);
    		}
    	});
    });

    // Show/Hide Coupon Field for Manual/Automatic
	$("#ManualCoupon").click(function(){
		$("#couponField").show();
	});

	$("#AutomaticCoupon").click(function(){
		$("#couponField").hide();
	});


	// Show/Hide fields on Category Selection
    $(document).on('change','#category_id', function(){
    	var category_id = $(this).val();
    	if(category_id==6 || category_id==7){
    		$(".itemCity").show();	
    	}else{
    		$(".itemCity").show();
    	}
    	
    });


});


$(".toggle-password").click(function() {

  $(this).toggleClass("fa-eye fa-eye-slash");
  var input = $($(this).attr("toggle"));
  if (input.attr("type") == "password") {
    input.attr("type", "text");
  } else {
    input.attr("type", "password");
  }
});

$(".toggle-password-two").click(function() {

  $(this).toggleClass("fa-eye fa-eye-slash");
  var input = $($(this).attr("toggle"));
  if (input.attr("type") == "password") {
    input.attr("type", "text");
  } else {
    input.attr("type", "password");
  }
});

$(".toggle-password-three").click(function() {

  $(this).toggleClass("fa-eye fa-eye-slash");
  var input = $($(this).attr("toggle"));
  if (input.attr("type") == "password") {
    input.attr("type", "text");
  } else {
    input.attr("type", "password");
  }
});


document.querySelectorAll(".cityMarker").forEach((summary) => {
    summary.addEventListener("click", function (event) {
        event.preventDefault(); // Prevent default toggle behavior
        let details = this.parentElement;
        details.open = !details.open;
    });
});

