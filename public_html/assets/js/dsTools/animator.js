$(document).ready(function(){
	animator.carouselFlipInit();
});

var animator = {

	carouselFlipInit: function(){
		// Init the carousels
		animator.carouselFlip.carousels = [];

		// set statup css
		var $carousel;
		$(".animCarouselFlip .carousel").each(function(){
			$carousel = $(this);

			// set the first panel's angle
			var $firstPanel;
			var panelWidth = 0;
			$carousel.find(".panel").each(function(){
				$firstPanel = $(this);
				$(this).data("animCarouselFlipAngle", 0);
				panelWidth = $(this).width();
			});

			// set new carousel data for the specified one
			var carouselID = animator.carouselFlip.carousels.length;
			var panelAngle = $carousel.attr("data-panelAngle");
			if (panelAngle == undefined) panelAngle = 90; // defaults to 90deg
			var carouselDepth = Math.ceil((panelWidth / 2) / Math.tan((panelAngle / 2) * Math.PI / 180));
			$carousel.data("animCarouselFlip_ID", carouselID);

			animator.carouselFlip.carousels[carouselID] = { angle: 0,
				panelWidth: panelWidth,
				panelAngle: panelAngle,
				carouselDepth: carouselDepth};

			// once all is calculated, set the initial position of carousel and firstPanel
			$carousel.css("transform", "translateZ( -" + carouselDepth + "px ) rotateY( 0deg )");
			$carousel.css("-webkit-transform", "translateZ( -" + carouselDepth + "px ) rotateY( 0deg )");
			$carousel.css("-ms-transform", "translateZ( -" + carouselDepth + "px ) rotateY( 0deg )");

			$firstPanel.css("transform", "rotateY( 0deg ) translateZ( " + carouselDepth + "px )");
			$firstPanel.css("-webkit-transform", "rotateY( 0deg ) translateZ( " + carouselDepth + "px )");
			$firstPanel.css("-ms-transform", "rotateY( 0deg ) translateZ( " + carouselDepth + "px )");

			$carousel.show();
			$carousel.parent(".animCarouselFlip").css("height", $firstPanel.height() + "px");
		});

	},
	carouselFlip : function(cmdData){
		var $carousel = $(cmdData.jQOfCarouselToFlip);

		// get the carousel data for the specified one
		var carouselID = $carousel.data("animCarouselFlip_ID");
		var carouselData = animator.carouselFlip.carousels[carouselID];

		// cleanup all other panels than the one we replace
		var $panelToFlipOut;
		$carousel.find(".panel").each(function(){
			if ($(this).data("animCarouselFlipAngle") == -carouselData.angle){
				$panelToFlipOut = $(this);
			}else{
				$(this).remove();
			}
		});

		// determine the angle where we're going to
		var newAngle;
		var newPanelAngle;
		if (cmdData.insertAfter){
			newAngle = parseFloat(carouselData.angle) - parseFloat(carouselData.panelAngle);
		}else{
			newAngle = parseFloat(carouselData.angle) + parseFloat(carouselData.panelAngle);
		}
		newPanelAngle = -newAngle;

		// create a new panel
		var $newPanel = $('<div/>').html(cmdData.html).find(".panel");

		$newPanel.data("animCarouselFlipAngle", newPanelAngle);
		$newPanel.css("transform", "rotateY( " + newPanelAngle + "deg ) translateZ( " + carouselData.carouselDepth + "px )");
		$newPanel.css("-webkit-transform", "rotateY( " + newPanelAngle + "deg ) translateZ( " + carouselData.carouselDepth + "px )");
		$newPanel.css("-ms-transform", "rotateY( " + newPanelAngle + "deg ) translateZ( " + carouselData.carouselDepth + "px )");

		// do we add before or after ?
		if (cmdData.insertAfter){
			$panelToFlipOut.after($newPanel);
		}else{
			$panelToFlipOut.before($newPanel);
		}

		// animate it / rotate the carousel
		carouselData.angle = newAngle;
		$carousel.css("transform", "translateZ( -" + carouselData.carouselDepth + "px ) rotateY(" + carouselData.angle + "deg )");
		$carousel.css("-webkit-transform", "translateZ( -" + carouselData.carouselDepth + "px ) rotateY(" + carouselData.angle + "deg )");
		$carousel.css("-ms-transform", "translateZ( -" + carouselData.carouselDepth + "px ) rotateY(" + carouselData.angle + "deg )");
		$carousel.parent(".animCarouselFlip").css("height", $newPanel.height() + "px");


	}
}

dsAjaxV2.commands.animCarouselFlip = animator.carouselFlip;