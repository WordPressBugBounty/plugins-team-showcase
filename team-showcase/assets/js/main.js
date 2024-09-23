jQuery(document).ready(function($){
	"use strict";
	// $(document).on('click', '.team-popup-box .close', function(){
	// 	$('.team-popup-box').fadeOut();
	// 	$('.team-slide').fadeOut();
	// })
	// $('.team-popup').click(function(event){
	// 	event.preventDefault();
	// 	var teamid = $(this).attr('teamid');
	// 	$('.team-popup-box-'+teamid).fadeIn();
	// 	$('.team-slide-'+teamid).css("display",'inline-block');
	// });

	$('.open-popup-link').magnificPopup({
		type:'inline',
		midClick: true,
		gallery:{
			enabled:true,
		},
		removalDelay: 500, //delay removal by X to allow out-animation
		callbacks: {
		    beforeOpen: function() {
                var e = ["mfp-tpteamfree"];
                e.push(this.st.el.attr("data-effect") ? this.st.el.attr("data-effect") : "mfp-fade");
                this.st.mainClass = this.st.mainClass + " " + e.join(" ");
		    },
		    buildControls: function() {
		      // re-appends controls inside the main container
		      this.contentContainer.append(this.arrowLeft.add(this.arrowRight));
		    }
		},
	  	closeOnContentClick: false,
	});

});