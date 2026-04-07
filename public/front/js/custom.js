$(document).ready(function(){
	$("#showdifferent").addClass('collapse show');
	$(".newAddress").hide();
	$("#getPrice").change(function(){
		var size = $(this).val();
		var product_id = $(this).attr("product-id");
		$.ajax({
			headers: {
        		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    		},
			url:'/get-product-price',
			data:{size:size,product_id:product_id},
			type:'post',
			success:function(resp){
				
				if(resp['discount']>0){
					$(".getAttributePrice").html("<div class='price'><h4>Rs."+resp['final_price']+"</h4></div><div class='original-price'><span>Original Price: </span><span>Rs."+resp['product_price']+"</span></div>");
				}else{
					$(".getAttributePrice").html("<div class='price'><h4>Rs."+resp['final_price']+"</h4></div>");
				}
			},error:function(){
				//alert("Error");
			}
		});
	});


	// Load Cities for Pincodes in Enquiry Form
	$('#norway_pincode').on('keyup', function() {
        if (this.value.length >= 1) {
            var pincode = $(this).val();
            $.ajax({
                type : 'get',
                data : {pincode:pincode},
                url : '/get-city',
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

    // Load Cities for Pincodes in Enquiry Form
	$('#norway_pincodes').on('keyup', function() {
        if (this.value.length >= 1) {
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

    // Load Codes for Countries in Enquiry Form
	$('.enquire_country').on('change', function() {        
        var country = $(this).val();
        $.ajax({
            type : 'get',
            data : {country:country},
            url : '/get-countrycode',
            success:function(resp){
                $('.load_countrycode').val("+"+resp.countrycode);
            },
            error:function(){
                //nothing to do
            }
        })
    });

	// Update Cart Items Qty
	$(document).on('click','.updateCartItem',function(){
		if($(this).hasClass('plus-a')){
			// Get Qty
			var quantity = $(this).data('qty');
			// increase the qty by 1
			new_qty = parseInt(quantity) + 1;
			/*alert(new_qty);*/
		}
		if($(this).hasClass('minus-a')){
			// Get Qty
			var quantity = $(this).data('qty');
			// Check Qty is atleast 1
			if(quantity<=1){
				alert("Item quantity must be 1 or greater!");
				return false;
			}
			// increase the qty by 1
			new_qty = parseInt(quantity) - 1;
			/*alert(new_qty);*/
		}
		var cartid = $(this).data('cartid');
		$.ajax({
			headers: {
        		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    		},
			data:{cartid:cartid,qty:new_qty},
			url:'/cart/update',
			type:'post',
			success:function(resp){
				$(".totalCartItems").html(resp.totalCartItems);
				if(resp.status==false){
					alert(resp.message);
				}
				$("#appendCartItems").html(resp.view);
				$("#appendHeaderCartItems").html(resp.headerview);
			},error:function(){
				//alert("Error");
			}
		});
	});

	// Delete Cart Item
	$(document).on('click','.deleteCartitem',function(){
		var cartid = $(this).data('cartid');
		var result = confirm("Are you sure to delete this Cart Item?");
		if(result){
			$.ajax({
				headers: {
	        		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    		},
	    		data:{cartid:cartid},
	    		url:'/cart/delete',
	    		type:'post',
	    		success:function(resp){
	    			$(".totalCartItems").html(resp.totalCartItems);
					$("#appendCartItems").html(resp.view);
					$("#appendHeaderCartItems").html(resp.headerview);
				},error:function(){
					//alert("Error");
				}
			})	
		}
		
	});

	function reloadUserEnquiriesList(forcedMessageType){
		if (!$("#loadEnqueries").length) {
			return;
		}
		var cat = $("#selcatenq").val();
		var message_type = $("#seltypeenq").val();
		if (typeof forcedMessageType !== 'undefined' && forcedMessageType !== null && String(forcedMessageType) !== '') {
			message_type = String(forcedMessageType);
		} else if (typeof window.currentMessageType !== 'undefined') {
			var currentPanelType = String(window.currentMessageType || '');
			if (currentPanelType === 'assignment') {
				message_type = 'assignment';
			}
		}
		if ((message_type === undefined || message_type === null || message_type === "") && typeof window.currentMessageType !== 'undefined') {
			message_type = String(window.currentMessageType || "");
		}
		var active_close = $("#selcloseenq").val();
		var selected_enquiry_id = $("#selectedEnquiryId").val() || "";
		$.ajax({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			type:'post',
			data:{cat:cat,message_type:message_type,active_close:active_close,selected_enquiry_id:selected_enquiry_id},
			url:'/get-user-enquiries',
			success:function(resp){
				$("#loadEnqueries").html(resp.view);
				if ($("#seltypeenq").length) {
					if (typeof forcedMessageType !== 'undefined' && forcedMessageType !== null && String(forcedMessageType) !== '') {
						$("#seltypeenq").val(String(forcedMessageType));
					} else if (typeof window.currentMessageType !== 'undefined' && String(window.currentMessageType || '') !== '') {
						$("#seltypeenq").val(String(window.currentMessageType));
					}
				}
			},error:function(){
				//alert("Error");
			}
		});
	}

	// Update Enquiry Status for Close
	$(document).on("click",".updateEnquiryStatus",function(){
		if($(this).hasClass('enquiry-complete-btn')){
			var itemLabel = ($(this).attr('data-item-label') || 'assignment').toLowerCase();
			var confirmText = "Er du sikker på at du vil fullføre oppdraget? Når oppdraget er fullført kan det ikke aktiveres igjen.";
			if(itemLabel === 'conversation'){
				confirmText = "Er du sikker på at du vil avslutte samtalen?";
			}
			var confirmComplete = confirm(confirmText);
			if(!confirmComplete){
				return false;
			}
		}
		$('.PleaseWaitDiv').show();
		var status = $(this).children("i").attr("status");
		var enquiry_id = $(this).attr("enquiry_id");
		$.ajax({
			headers: {
        		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    		},
			type:'post',
			url:'/update-enquiry-status',
			data:{status:status,enquiry_id:enquiry_id},
			success:function(resp){
				$('.PleaseWaitDiv').hide();
				reloadUserEnquiriesList();
			},error:function(){
				$('.PleaseWaitDiv').hide();
				//alert("Error");
			}
		})
	});

	// Delete completed enquiry
	$(document).on("click", ".deleteEnquiry", function(){
		var enquiry_id = $(this).attr("enquiry_id");
		var itemLabel = ($(this).attr('data-item-label') || 'assignment').toLowerCase();
		var confirmText = "Er du sikker på at du vil fjerne dette fullførte oppdraget?";
		if(itemLabel === 'conversation'){
			confirmText = "Er du sikker på at du vil fjerne denne avsluttede samtalen?";
		}
		var confirmDelete = confirm(confirmText);
		if(!confirmDelete){
			return false;
		}
		$('.PleaseWaitDiv').show();
		$.ajax({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			type:'post',
			url:'/delete-enquiry',
			data:{enquiry_id:enquiry_id},
			success:function(resp){
				$('.PleaseWaitDiv').hide();
				reloadUserEnquiriesList();
			},error:function(){
				$('.PleaseWaitDiv').hide();
			}
		});
	});

	// Status filter panel for enquiries page
	$(document).on('click', '.status-filter-btn', function(e){
		e.preventDefault();
		var statusVal = $(this).attr('data-status');
		$("#selcloseenq").val(statusVal);
		$('.status-filter-btn').removeClass('is-active');
		$(this).addClass('is-active');
		reloadUserEnquiriesList();
	});

	$(document).on('click', '.status-filter-toggle', function(e){
		if (!window.matchMedia('(max-width: 767px)').matches) {
			return;
		}
		e.preventDefault();
		var $panel = $(this).closest('.status-filter-panel');
		var isOpen = !$panel.hasClass('is-open');
		$panel.toggleClass('is-open', isOpen);
		$(this).attr('aria-expanded', isOpen ? 'true' : 'false');
	});

	$(window).on('resize', function(){
		if (!window.matchMedia('(max-width: 767px)').matches) {
			$('.status-filter-panel').removeClass('is-open');
			$('.status-filter-toggle').attr('aria-expanded', 'false');
		}
	});

	// Update Enquiry Status for Pin/Unpin
	$(document).on("click",".updatePinStatus",function(){
		$('.PleaseWaitDiv').show();
		var status = $(this).children("i").attr("status");
		var pin_id = $(this).attr("pin_id");
		$.ajax({
			headers: {
        		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    		},
			type:'post',
			url:'/update-pin-status',
			data:{status:status,pin_id:pin_id},
			success:function(resp){
				$('.PleaseWaitDiv').hide();
				// alert(resp);
				if(resp['status']==0){
					$("#pin-"+pin_id).html("<i class='status-marker' style='display:none;' status='Inactive'></i><span class='pin-chip is-unpinned'><i class='fa fa-thumb-tack'></i> Ikke festet</span>");
				}else if(resp['status']==1){
					$("#pin-"+pin_id).html("<i class='status-marker' style='display:none;' status='Active'></i><span class='pin-chip is-pinned'><i class='fa fa-thumb-tack'></i> Festet</span>");
				}
			},error:function(){
				$('.PleaseWaitDiv').hide();
				//alert("Error");
			}
		})
	});

	// Vendor Register Form Validation
	/* $("#vendorRegisterForm").submit(function(){
		$(".loader").show();
		var formdata = $(this).serialize();
		$.ajax({
			url:"/vendor/register",
			type:"POST",
			data:formdata,
			success:function(resp){
				if(resp.type=="error"){
					$(".loader").hide();
					$.each(resp.errors,function(i,error){
						alert("#register-"+i);
						$("#register-"+i).attr('style','color:red');
						$("#register-"+i).html(error);
					setTimeout(function(){
						$("#register-"+i).css({
							'display':'none'
						});
					},3000);
					});
				}else if(resp.type=="success"){
					alert(resp.message);
					$(".loader").hide();
					$("#register-success").attr('style','color:green');
					$("#register-success").html(resp.message);
				}
				
			},error:function(){
				//alert("Error");
			}
		})
	}); */

	//Vendor Register Form Validation
    $("#vendorRegisterForm").submit(function(e){
        $('.PleaseWaitDiv').show();
        /* $('.loader').show(); */
        e.preventDefault();
        var formdata = $("#vendorRegisterForm").serialize();
        $.ajax({
        	headers: {
        		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    		},
            url: "/vendor/register",
            type:'POST',
            data: formdata,
            success: function(data) {
                $('.PleaseWaitDiv').hide();
                if(!data.status){
                    if(data.type=="validation"){
                        $.each(data.errors, function (i, error) {
                            $('#Register-'+i).attr('style', 'color:red');
                            $('#Register-'+i).html(error);
                            setTimeout(function () {
                                $('#Register-'+i).css({
                                    'display': 'none'
                                });
                            }, 3000);
                        });
                    }else{
                        var msg = [];
                        msg[0] = data.errors;
                        $('.print-error-msg').delay(3000).fadeOut('slow');
                    }
                }else{
                	/*alert(data.type); return false;*/
                    if(data.type=="success"){
                        /*var msg = [];
                        msg[0] = data.message;
                        $('.print-success-msg').delay(3000).fadeOut('slow');
                        $('.PleaseWaitDiv').hide();
                        $('#register-success').text(data.message);*/
                        /* window.location.href= data.url; */
                        window.location.href = 'plans/'+data.code;
                    }else{
                        var msg = [];
                        msg[0] = data.errors;
                        $('.print-success-msg').delay(3000).fadeOut('slow');
                        /*window.location.href= data.url;*/    
                    }     
                }
            }
        });
    });

    // Vendor Login Form Validation
	$("#vendorLoginForm").submit(function(){
		var formdata = $(this).serialize();
		$.ajax({
			headers: {
		        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    },
			url:"/vendor/login",
			type:"POST",
			data:formdata,
			success:function(resp){
				if(resp.type=="error"){
					$.each(resp.errors,function(i,error){
						$("#vendor-login-"+i).attr('style','color:red');
						$("#vendor-login-"+i).html(error);
					setTimeout(function(){
						$("#vendor-login-"+i).css({
							'display':'none'
						});
					},3000);
					});
				}else if(resp.type=="incorrect"){
					/*alert(resp.message);*/
					/*alert(resp.message);*/	
					$("#vendor-login-error").attr('style','color:red');
					$("#vendor-login-error").html(resp.message);
				}else if(resp.type=="inactive"){
					/*alert(resp.message);*/	
					$("#vendor-login-error").attr('style','color:red');
					$("#vendor-login-error").html(resp.message);
				}else if(resp.type=="success"){
					window.location.href = resp.url;	
				}
			},error:function(){
				//alert("Error");
			}
		})
	});

	// Forgot Password Form Validation
	$("#vendorForgotForm").submit(function(){
		$(".loader").show();
		var formdata = $(this).serialize();
		$.ajax({
			url:"/vendor/forgot-password",
			type:"POST",
			data:formdata,
			success:function(resp){
				if(resp.type=="error"){
					$(".loader").hide();
					$.each(resp.errors,function(i,error){
						$(".forgot-"+i).attr('style','color:red');
						$(".forgot-"+i).html(error);
					setTimeout(function(){
						$(".forgot-"+i).css({
							'display':'none'
						});
					},3000);
					});
				}else if(resp.type=="success"){
					/*alert(resp.message);*/
					$(".loader").hide();
					$(".forgot-success").attr('style','color:green');
					$(".forgot-success").html(resp.message);
				}
				
			},error:function(){
				//alert("Error");
			}
		})
	});

	// Register Form Validation
	$("#registerForm").submit(function(){
		$(".loader").show();
		$(".PleaseWaitDiv").show();
		var formdata = $(this).serialize();
		$.ajax({
			headers: {
        		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    		},
			url:"/user/register",
			type:"POST",
			data:formdata,
			success:function(resp){
				if(resp.type=="error"){
					$(".loader").hide();
					$(".PleaseWaitDiv").hide();
					$.each(resp.errors,function(i,error){
						$("#register-"+i).attr('style','color:red');
						$("#register-"+i).html(error);
					setTimeout(function(){
						$("#register-"+i).css({
							'display':'none'
						});
					},3000);
					});
				}else if(resp.type=="success"){
					// alert(resp.message);
					$(".loader").hide();
					$(".PleaseWaitDiv").hide();
					//$("#registerForm").hide();
					$("#register-success").show();
					$("#register-success").attr('style','color:green');
					$("#register-success").html(resp.message);
					$("#signupModal").modal('hide');
					//$("#loginModal").modal('show');
					window.location.href = resp.url;
				}
				
			},error:function(){
				//alert("Error");
				$(".loader").hide();
				$(".PleaseWaitDiv").hide();
			}
		})
	});

	// Password Form Validation
	$(document).on("submit", "#passwordForm", function(e){
		e.preventDefault();
		$(".loader").show();
		var formdata = $(this).serialize();
		$.ajax({
			url:"/user/update-password",
			type:"POST",
			data:formdata,
			success:function(resp){
				if(resp.type=="error"){
					$(".loader").hide();
					$.each(resp.errors,function(i,error){
						$("#password-"+i).attr('style','color:red');
						$("#password-"+i).html(error);
					setTimeout(function(){
						$("#password-"+i).css({
							'display':'none'
						});
					},3000);
					});
				}else if(resp.type=="incorrect"){
					$(".loader").hide();
					$("#password-error").attr('style','color:red');
					$("#password-error").html(resp.message);
					setTimeout(function(){
						$("#password-error").css({
							'display':'none'
						});
					},3000);
				}else if(resp.type=="success"){
					/*alert(resp.message);*/
					$(".loader").hide();
					$("#password-success").attr('style','color:green');
					$("#password-success").html(resp.message);
					setTimeout(function(){
						$("#password-success").css({
							'display':'none'
						});
					},3000);
				}
				
			},error:function(){
				//alert("Error");
			}
		})
	});

	// Forgot Password Form Validation
	$("#forgotForm").submit(function(){
		$(".loader").show();
		var formdata = $(this).serialize();
		$.ajax({
			url:"/user/forgot-password",
			type:"POST",
			data:formdata,
			success:function(resp){
				if(resp.type=="error"){
					$(".loader").hide();
					$.each(resp.errors,function(i,error){
						$("#forgot-"+i).attr('style','color:red');
						$("#forgot-"+i).html(error);
					setTimeout(function(){
						$("#forgot-"+i).css({
							'display':'none'
						});
					},3000);
					});
				}else if(resp.type=="success"){
					/*alert(resp.message);*/
					$(".loader").hide();
					$("#forgot-success").attr('style','color:green');
					$("#forgot-success").html(resp.message);
				}
				
			},error:function(){
				//alert("Error");
			}
		})
	});

	$("#SaveContact").submit(function(e){
        e.preventDefault();
        $(".PleaseWaitDiv").show();
        $(".loadingDiv").show();
        var formdata = $("#SaveContact").serialize();
        $.ajax({
            url: "/save-contact",
            type:'POST',
            data: formdata,
            success: function(data) {
                $('.PleaseWaitDiv').hide();
                $('.loadingDiv').hide();
                if(!data.status){
                    if(data.type=="validation"){
                        $.each(data.errors, function (i, error) {
                            $('#Contact-'+i).attr('style', '');
                            $('#Contact-'+i).html(error);
                            setTimeout(function () {
                                $('#Contact-'+i).css({
                                    'display': 'none'
                                });
                            }, 3000);
                        });
                    }
                }else{
                    alert("Thanks for your feedback. We will get back to you soon.");
                    $('#SaveContact').trigger("reset");
                    /*window.location.href= data.url;*/
                }
            }
        });
    });

	// Apply Coupon
    $("#ApplyCoupon").submit(function(){
    	var user = $(this).attr("user");
    	/*alert(user);*/
    	if(user==1){
    		// do nothing
    	}else{
    		alert("Please login to apply Coupon!");
    		return false;
    	}
    	var code = $("#code").val();
    	$.ajax({
    		headers: {
        		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    		},
    		type:'post',
    		data:{code:code},
    		url:'/apply-coupon',
    		success:function(resp){
    			if(resp.message!=""){
    				alert(resp.message);
    			}
    			$(".totalCartItems").html(resp.totalCartItems);
				$("#appendCartItems").html(resp.view);
				$("#appendHeaderCartItems").html(resp.headerview);
				if(resp.couponAmount>0){
					$(".couponAmount").text("Rs."+resp.couponAmount);
				}else{
					$(".couponAmount").text("Rs.0");
				}
				if(resp.grand_total>0){
					$(".grand_total").text("Rs."+resp.grand_total);
				}
    		},error:function(){
    			//alert("Error");
    		}
    	})
    });

    //Add to Wishlist
    $(document).on('click','.addWishList',function(){

            $('.PleaseWaitDiv').show();
            var proid = $(this).data('productid');
            $.ajax({
            	headers: {
	        		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    		},
                data : {
                    "_token": "{{ csrf_token() }}",
                    "proid":proid
                },
                type : 'post',
                url : '/add-to-wishlist',
                success:function(resp){ 
                    if(resp.status){
                        if(resp.message ==='set'){
                            $('a[data-productid='+proid+']').children().children().removeClass('fa-heart-o');
                            $('a[data-productid='+proid+']').children().children().addClass('fa-heart');
                        }else if(resp.message ==='unset'){
                            $('a[data-productid='+proid+']').children().children().removeClass('fa-heart');
                            $('a[data-productid='+proid+']').children().children().addClass('fa-heart-o');
                        }
                    }else{
                        alert(resp.message);
                        //window.location.reload();
                    }
                    $('.PleaseWaitDiv').hide();
                },
                error:function(){
                    //Nothing to do
                }
            }); 
        });

    $(document).on('click', '.editAddress', function(e) {
        var addressid = $(this).data("addressid");
        $.ajax({
        	headers: {
        		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    		},
            data : { id:addressid},
            url : "/get-delivery-address",
            type : 'post',
            success:function(resp){
            	$("#showdifferent").removeClass('collapse');
            	$(".newAddress").hide();
            	$(".deliveryText").text('Edit Delivery Address');
                if(resp.status){
                    $('[name=delivery_id]').val(resp.address['id']);
                    $('[name=delivery_name]').val(resp.address['name']);
                    $('[name=delivery_state]').val(resp.address['state']);
                    $('[name=delivery_city]').val(resp.address['city']);
                    $('[name=delivery_country]').val(resp.address['country']);
                    $('[name=delivery_mobile]').val(resp.address['mobile']);
                    $('[name=delivery_pincode]').val(resp.address['pincode']);
                    $('[name=delivery_address]').val(resp.address['address']);
                    /* $('#shipAdd').modal('show'); */
                }else{
                    $('#deliveryAddresses').html(resp.view);
                }
            }
        });
    });

    $(document).on('submit', '#addressAddEditForm', function() {
        var formdata = $("#addressAddEditForm").serialize();
        $.ajax({
        	headers: {
        		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    		},
            url: '/save-address',
            type:'POST',
            data: formdata,
            success: function(data) {
                $('#addressAddEditForm').trigger("reset");
                $('#deliveryAddresses').html(data.view);
                /* window.location.reload(); */
            },error:function(){
            	//alert("Error");
            }
        });
    });

    // Remove Delivery Address
    $(document).on('click', '.removeAddress', function(e) {
        if (confirm('Are you sure you want to remove this?')) {
            var addressid = $(this).data("addressid");
            $.ajax({
            	headers: {
        			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    			},
                url: '/remove-delivery-address',
                type:'GET',
                data : {"id":addressid}, 
                success:function(resp){   
                    $('#deliveryAddresses').html(resp.view);
                    /* window.location.reload(); */
                },error:function(){
	            	//alert("Error");
	            }
            });
        }
    });

    // Login Form Validation
	$("#loginForm").submit(function(){
		var formdata = $(this).serialize();
		$.ajax({
			headers: {
    			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			url:"/user/login",
			type:"POST",
			data:formdata,
			dataType: 'json',
			success:function(resp){
				if(resp.type=="error"){
					$.each(resp.errors,function(i,error){
						$("#login-"+i).attr('style','color:red');
						$("#login-"+i).html(error);
					setTimeout(function(){
						$("#login-"+i).css({
							'display':'none'
						});
					},3000);
					});
				}else if(resp.type=="incorrect"){
					/*alert(resp.message);*/	
					$("#login-error").attr('style','color:red');
					$("#login-error").html(resp.message);
				}else if(resp.type=="inactive"){
					/*alert(resp.message);*/	
					$("#login-error").attr('style','color:red');
					$("#login-error").html(resp.message);
				}else if(resp.type=="success"){
					window.location.href = resp.url;	
				}
			},error:function(){
				//alert("Error");
			}
		})
	});

	// Account Form Validation + Unsaved Changes Guard
	var accountGuardState = {
		formElement: null,
		initialSerialized: "",
		isSubmitting: false
	};

	function syncAccountBaseline() {
		var $form = $("#accountForm");
		if (!$form.length) {
			accountGuardState.formElement = null;
			accountGuardState.initialSerialized = "";
			accountGuardState.isSubmitting = false;
			return;
		}

		if (accountGuardState.formElement !== $form.get(0)) {
			accountGuardState.formElement = $form.get(0);
			accountGuardState.initialSerialized = $form.serialize();
			accountGuardState.isSubmitting = false;
		}
	}

	function hasUnsavedAccountChanges() {
		var $form = $("#accountForm");
		if (!$form.length || accountGuardState.isSubmitting) {
			return false;
		}
		if (accountGuardState.formElement !== $form.get(0)) {
			syncAccountBaseline();
		}
		return $form.serialize() !== accountGuardState.initialSerialized;
	}

	window.customerAccountGuard = {
		hasUnsavedChanges: hasUnsavedAccountChanges
	};

	window.addEventListener("beforeunload", function (e) {
		if (!hasUnsavedAccountChanges()) {
			return;
		}
		e.preventDefault();
		e.returnValue = "";
	});

	syncAccountBaseline();

	$(document).on("click", "#profileImageTrigger", function () {
		var input = document.getElementById("profileImageInput");
		if (input) {
			input.click();
		}
	});

	$(document).on("change", "#profileImageInput", function () {
		var input = this;
		var statusEl = $("#profile-image-status");
		if (!input || !input.files || !input.files.length) {
			return;
		}

		var selectedFile = input.files[0];
		var formData = new FormData();
		formData.append("_token", $('meta[name="csrf-token"]').attr("content"));
		formData.append("profile_image", selectedFile);

		statusEl.css("color", "#7a6f62").text("Laster opp bilde...");
		$(".loader").show();

		$.ajax({
			url: "/user/account",
			type: "POST",
			data: formData,
			processData: false,
			contentType: false,
			dataType: "json",
			success: function (resp) {
				if (resp.type === "success") {
					if (resp.image_url) {
						$("#profileAvatarImage").attr("src", resp.image_url);
						$("#topbarAvatarImage").attr("src", resp.image_url);
					}
					statusEl.css("color", "#1f6f39").text(resp.message || "Profilbildet er oppdatert.");
				} else if (resp.type === "error") {
					if (resp.errors) {
						var firstKey = Object.keys(resp.errors)[0];
						if (firstKey && resp.errors[firstKey] && resp.errors[firstKey][0]) {
							statusEl.css("color", "#b42318").text(resp.errors[firstKey][0]);
							return;
						}
					}
					statusEl.css("color", "#b42318").text(resp.message || "Kunne ikke oppdatere profilbildet.");
				}
			},
			error: function (xhr) {
				var errorMessage = "Kunne ikke oppdatere profilbildet.";
				if (xhr.responseJSON && xhr.responseJSON.errors) {
					var firstKey = Object.keys(xhr.responseJSON.errors)[0];
					if (firstKey && xhr.responseJSON.errors[firstKey] && xhr.responseJSON.errors[firstKey][0]) {
						errorMessage = xhr.responseJSON.errors[firstKey][0];
					}
				} else if (xhr.responseJSON && xhr.responseJSON.message) {
					errorMessage = xhr.responseJSON.message;
				}
				statusEl.css("color", "#b42318").text(errorMessage);
			},
			complete: function () {
				$(".loader").hide();
				input.value = "";
			}
		});
	});

	$(document).on("submit", "#accountForm", function(e){
		e.preventDefault();
		$(".loader").show();
		accountGuardState.isSubmitting = true;
		var $form = $(this);
		var formdata = $form.serialize();
		$.ajax({
			url:"/user/account",
			type:"POST",
			data:formdata,
			success:function(resp){
				if(resp.type=="error"){
					accountGuardState.isSubmitting = false;
					$(".loader").hide();
					$.each(resp.errors,function(i,error){
						$("#account-"+i).attr('style','color:red');
						$("#account-"+i).html(error);
					setTimeout(function(){
						$("#account-"+i).css({
							'display':'none'
						});
					},3000);
					});
				}else if(resp.type=="success"){
					$(".loader").hide();
					accountGuardState.isSubmitting = false;
					accountGuardState.initialSerialized = $form.serialize();
					$("#account-success").attr('style','display:block;color:#1f6f39;font-weight:700;');
					$("#account-success").html(resp.message);

					if (typeof Swal !== "undefined") {
						Swal.fire({
							icon: 'success',
							title: 'Endringer lagret',
							text: resp.message,
							confirmButtonColor: '#1f6f39'
						});
					}

					setTimeout(function(){
						$("#account-success").fadeOut(300);
					},3500);
				}
				
			},error:function(){
				accountGuardState.isSubmitting = false;
				$(".loader").hide();
				//alert("Error");
			}
		})
	});

	// Product Enquiry Form Submission
	$("#productEnquiryForm").submit(function(){
		$('.PleaseWaitDiv').show();
		$(".loader").show();
		var formdata = $(this).serialize();
		$.ajax({
			headers: {
    			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			url:"/user/enquiry",
			type:"POST",
			data:formdata,
			success:function(resp){
				$(".loader").hide();
				$('.PleaseWaitDiv').hide();
				if(resp.type=="success"){
					//alert(resp.message);
					$("#enquiry-success").attr('style','color:green');
					$("#enquiry-success").html(resp.message);
					$("#message").val("");
					setTimeout(function(){
						$("#enquiry-success").css({
							'display':'none'
						});
					},3000);
				}
			},error:function(){
				//alert("Error");
			}
		})
	});

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
		      'Deleted!',
		      'Your file has been deleted.',
		      'success'
		    )
		    window.location = "/user/delete-"+module+"/"+moduleid;
		  }
		})
	})

	//Newsletter Subscribe
    $("#Subscribe").on("submit", function () {
        var email = $("#subscriber").val();
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        var resp = regex.test(email);
        if (resp == false) {
            $(".FailureFader").text('Please enter valid Email address');
            $(".FailureFader").slideDown();
            setTimeout(function () {
                $(".FailureFader").slideUp();
            }, 1500);
            return false;
        }
        $("#Subscribebtn").prop('disabled', true);
        var formdata = $(this).serialize();
        $.ajax({
            url: '/add-subscriber',
            data: formdata,
            type: 'post',
            dataType: 'json',
            success: function (resp) {
                $("#subscriber").val('');
                if (resp.status == "ok") {
                    $(".SuccessFader").text(resp.message);
                    $(".SuccessFader").slideDown();
                    setTimeout(function () {
                        $(".SuccessFader").slideUp();
                    }, 1500);
                } else {
                    $(".FailureFader").text(resp.message);
                    $(".FailureFader").slideDown();
                    setTimeout(function () {
                        $(".FailureFader").slideUp();
                    }, 1500);
                }
                $("#Subscribebtn").prop('disabled', false);
            },
            error: function () { }
        })
    });


	$(".enquery-form-button").click(function(){
   /*$(".get-quote").toggle();*/
   });

   $(".close-e-form").click(function(){
   $(".get-quote").hide();
   });

	// load User Enquiries based on selected filters
   	$(document).on('change','.seluserenquiries',function(){
		reloadUserEnquiriesList();
   });

   	$('input[type=checkbox][name=deliverToAll]').change(function() {
		var deliverToAll = $('input[type=checkbox][name=deliverToAll]:checked').val();
		if(deliverToAll=="Yes"){
			$(".radiusAll").val("2500");	
		}else{
			$(".radiusAll").val("");
		}
	});
});


function get_filter(class_name){
	var filter = [];
	$('.'+class_name+':checked').each(function(){
		filter.push($(this).val());
	});
	return filter;
}



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
$(document).ready(function() {
	if ($('.fancybox').length > 0) {
		$('.enquery-form').hide();
	}
});
