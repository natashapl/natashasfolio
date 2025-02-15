jQuery(document).ready(function() {
 
	var $container = $('#isotope-list'); //The ID for the list with all the blog posts
	
	$container.imagesLoaded( function() {
	  // init Isotope after all images have loaded
	  $container.isotope({
		itemSelector : '.all',
		filter: '.front-end-development',		
  		layoutMode : 'fitRows'
	  });
	});
 
	//Add the class selected to the item that is clicked, and remove from the others
	var $optionSets = $('#filters'),
	$optionLinks = $optionSets.find('a');
	
	$("#filters a[data-filter~='.front-end-development']").addClass("selected");
 
	$optionLinks.click(function(){
		var $this = $(this);
		// don't proceed if already selected
		
		if ( $this.hasClass('selected') ) {
		  return false;
		}
		var $optionSet = $this.parents('#filters');
		$optionSets.find('.selected').removeClass('selected');
		$this.addClass('selected');
	 
		//When an item is clicked, sort the items.
		 var selector = $(this).attr('data-filter');
		$container.isotope({ filter: selector });
	 
		return false;
	});
 
});