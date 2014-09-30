<?php
/************************************************************************
* Search Form
*************************************************************************/
?>


<div class="widget">

	<form method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search" class="search">

		<input type="text" class="field" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" id="s" placeholder="<?php esc_attr_e( 'Search &hellip;', 'framework' ); ?>" />
	
	</form>

</div>