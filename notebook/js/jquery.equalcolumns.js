jQuery.noConflict();
(function(jQuery){
jQuery.fn.equalHeight = function() {
	tallest = 0;
	this.each(function(){
		thisHeight = jQuery(this).height();
		if( thisHeight > tallest)
			tallest = thisHeight;
	});
	this.each(function(){
		jQuery(this).height(tallest);
	});
}
})(jQuery);