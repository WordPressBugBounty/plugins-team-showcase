(function( $ ) {
	'use strict';

	$( ".tup_class2" ).sortable();

	$(document).on('click', '.tab-nav li', function(){
		$(".active").removeClass("active");
		$(this).addClass("active");
		var nav = $(this).attr("nav");
		$(".box li.tab-box").css("display","none");
		$(".box"+nav).css("display","block");
		$("#nav_value").val(nav);
	});

	var team_manager_free_imagesize = $("#team_manager_free_imagesize").val();
	if( team_manager_free_imagesize == 1 ){
		$("#hide1").hide('slow');
	}else {
		$("#hide1").show('slow');
	}

	$("#team_manager_free_imagesize").on('change', function(){
		var team_manager_free_imagesize = $("#team_manager_free_imagesize").val();
		if( team_manager_free_imagesize == 2 ){
			$("#hide1").show('slow');
		}else{
			$("#hide1").hide('slow');
		}
	});

	var slider = document.getElementById("myRange");
	var output = document.getElementById("autoplay_speed");
	output.innerHTML = slider.value;

	slider.oninput = function() {
	  	output.setAttribute( 'value' ,this.value );
	}

    $('.tmf-tree-toggle').on('click', function(e){
        e.stopPropagation(); // prevent label click
        var $group = $(this).closest('.tmf-tree-group');
        $group.find('.tmf-tree-children').slideToggle(150);
        $(this).toggleClass('open');
    });

	$('.tmf-layout-item').on('click', function(){

	    // Check if PRO layout
	    if ($(this).hasClass('tmffree-pro-disabled')) {

	        // CodeCanyon style upsell
	        window.open('https://themepoints.com/teamshowcase/', '_blank');

	        return false;
	    }

	    // Remove selected from others
	    $(this).siblings().removeClass('selected');

	    // Add selected class
	    $(this).addClass('selected');

	    // Update hidden field
	    $('#team_manager_free_theme_style').val($(this).data('value'));

	});

	function toggleSingleLayout(){
	    var detailsType = $('input[name="team_manager_free_details_page_type"]:checked').val();

	    if(detailsType == 'single' || detailsType == 'both'){
	        $('.tmf-single-layout-row').show();
	    }else{
	        $('.tmf-single-layout-row').hide();
	    }
	}

	toggleSingleLayout();

	$('input[name="team_manager_free_details_page_type"]').change(function(){
	    toggleSingleLayout();
	});

})( jQuery );