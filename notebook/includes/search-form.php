<form name="quick-search" id="quick-search" method="get" action="<?php bloginfo('url'); ?>">
	<input type="text" value="Start searching for your new home..." name="s" id="s" class="left" onfocus="if(this.value=='Start searching for your new home...')this.value = '';" onblur="if(this.value=='')this.value = 'Start searching for your new home...';" />
   	<input type="image" src="<?php bloginfo('template_directory'); ?>/images/search_btn.png" />
	<input type="hidden" name="quick-search" value="true" />
</form>

	<div class="clear"></div>

<form id="advanced_search" name="property-search" action="<?php bloginfo('url'); ?>">
    
	<h3>Advanced Search</h3>
    
    <label for="ct_type">Type</label>
	<?php ct_search_form_select('property_type'); ?>
	
	<label for="ct_status">Status</label>
	<?php ct_search_form_select('status'); ?>
	
	<label for="ct_beds"># Bedrooms</label>
	<?php ct_search_form_select('beds'); ?>
	
	<label for="ct_baths"># Bathrooms</label>
	<?php ct_search_form_select('baths'); ?>
	
	<label for="ct_city">City</label>
	<?php ct_search_form_select('city'); ?>
	
	<label for="ct_state">State</label>
	<?php ct_search_form_select('state'); ?>
	
	<label for="ct_additional_features">Additional Features</label>
	<?php ct_search_form_select('additional_features'); ?>
	
	<input type="hidden" name="property-search" value="true" />
	<input type="image" src="<?php bloginfo('template_directory'); ?>/images/search_btn.png" />
	
</form>