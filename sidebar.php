<?php
$args = array(
  'orderby' => 'count',
  'order' => 'DESC'
  );
$categories = get_categories($args);
	echo "<div class='sidebar-container'>";
		echo "<h5>Categories</h5>";
		echo "<ul class='list-group'>";
  		foreach($categories as $category) { 
    		echo '<li class="list-group-item"><a href="' . get_category_link( $category->term_id ) . '" title="' . sprintf( 	__( "View all stories in %s" ), $category->name ) . '" ' . '>' . $category->name.'</a> <span class="badge">'	.$category->count.'</span></li> ';
		} 
		echo "</ul>";
	echo "</div>";
?>