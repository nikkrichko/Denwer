/**
*	@version	$Id: positions.js 18 2013-04-01 05:16:20Z linhnt $
*	@package	OMG Template Framework for Joomla! 2.5
*	@subpackage	lib_omg
*	@copyright	Copyright (C) 2009 - 2013 Omegatheme. All rights reserved.
*	@license	GNU/GPL version 2, or later
*	@website:	http://www.omegatheme.com
*	Support Forum - http://www.omegatheme.com/forum/
*/

jQuery(document).ready(function($) {
	// setup checkbox ui
	var icon_off = {primary: "ui-icon-close", secondary: null};
	var icon_on = {primary: "ui-icon-check", secondary: null};
	
	
	// changing the layout width select, change the width of block for example
	$(".omgposition").each(function(ib, pb){
		// setup checkbox ui
		$(pb).find("input:checkbox:checked").button({text: false, icons: icon_on});
		$(pb).find("input:checkbox:not(:checked)").button({text: false, icons: icon_off});
			
		$(pb).find(".position-view").each(function(iv, pv){
			// checkbox action
			$(pv).find("input:checkbox").click(function(event){
				
				if ($(event.target).is(':checked')) {
					//update icon
					$(event.target).button("option", "icons", icon_on).button('refresh');
				} else {
					//update icon
					$(event.target).button("option", "icons", icon_off).button('refresh');
				}
				
				//update the hidden input relevant checkbox state
				$(pv).children(".position-view-value").val(
					$(pv).find(':checkbox').map(function() {
						return $(this).is(":checked") ? 1 : 0;
					}).get().join(",")
				);
			});
		
		});
		
		
		// position width model select
		$(pb).find(".pos-width-select").change(function(e){
			var width = $(e.target).val().split(',');
			$(e.target).parents(".posNumCase").eq(0).find(".position-block").each(function(ipb, pob){
				$(pob).find(".posW").each(function(ip, po){
					$(po).removeClassRegEx(/span\d+/).addClass('span'+width[ip]);
				});
			});
		});
		
		// change width model with up-down button
		$(pb).find(".posSpinnerUp").click(function(e){
			e.preventDefault();
			var theSelect = $(e.target).parents(".layout-width").eq(0).find(".pos-width-select").eq(0);
			var theMaxIndex = $(theSelect).children().length > 1 ? $(theSelect).children().length - 1 : 0;
			var oldIndex = $(theSelect).prop('selectedIndex');
			
			
			if (oldIndex > 0){
				//$(e.target).removeClass('ui-state-disabled');
				//if (oldIndex - 1 < theMaxIndex) $(".posSpinnerDown").removeClass('ui-state-disabled');
				$(theSelect).prop('selectedIndex', oldIndex - 1).change();
			}
			else{
				//$(e.target).addClass('ui-state-disabled');
			}
			
		});
		$(pb).find(".posSpinnerDown").click(function(e){
			e.preventDefault();
			var theSelect = $(e.target).parents(".layout-width").eq(0).find(".pos-width-select").eq(0);
			var oldIndex = $(theSelect).prop('selectedIndex');
			var theMaxIndex = $(theSelect).children().length > 1 ? $(theSelect).children().length - 1 : 0;
			if (oldIndex < theMaxIndex){
				//$(e.target).removeClass('ui-state-disabled');
				//if (oldIndex + 1 > 0) $(".posSpinnerUp").removeClass('ui-state-disabled');
				$(theSelect).prop('selectedIndex', oldIndex + 1).change();
			}
			else{
				//$(e.target).addClass('ui-state-disabled');
			}
			
		});
	});
	
});

// fucntion to search and remove a class of an element with regexp
(function($)
{
	$.fn.removeClassRegEx = function(regex)
    {
		return this.each(function()
		{
			var classes = $(this).attr('class');
			if(!classes || !regex) return false;
			var classArray = [];
			classes = classes.split(' ');
			for(var i=0, len=classes.length; i<len; i++) if(!classes[i].match(regex)) classArray.push(classes[i]);
			$(this).attr('class', classArray.join(' '));
		});
	};
})(jQuery);

// fucntion to check an element have a class with regexp
(function($)
{
    $.fn.hasClassRegEx = function(regex)
    {
        var classes = $(this).attr('class');
        if(!classes || !regex) return false;
        classes = classes.split(' ');
        for(var i=0, len=classes.length; i < len; i++)
            if(classes[i].match(regex)) return true;
        
        return false;
    }; 
})(jQuery);
