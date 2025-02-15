	<div class="searchbox">
		<form id="searchform" action="<?php bloginfo('url'); ?>/" method="get">
			<div class="label">Find Entries</div>
			<div class="search"><input type="text" value="<?php the_search_query(); ?>" name="s" id="s" /></div>
			<div><input type="submit" id="searchsubmit" value="GO" /></div>
		</form>
	</div>
