<?php
	class top_menu_walker extends walker_nav_menu {
		
		function display_element ($element, &$children_elements, $max_depth, $depth = 0, $args, &$output) {
			// check, whether there are children for the given ID and append it to the element with a (new) ID
			$element->hasChildren = isset($children_elements[$element->ID]) && !empty($children_elements[$element->ID]);

			return parent::display_element($element, $children_elements, $max_depth, $depth, $args, $output);
		}

		function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
			if ($item->hasChildren) {
				$output .= '<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">'.$item->title.' <b class="caret"></b></a>';
			} else {
				parent::start_el($output, $item, $depth, $args);
			}
		}
		
		public function start_lvl(&$output, $depth=0, $args=array()) {
			if ($depth == 0) {
				$output .= '<ul class="dropdown-menu">';
			}
		}
		
		public function end_lvl(&$output, $depth=0, $args=array()) {
			if ($depth == 0) {
				$output .= '</ul>';
			}
		}
		
	}
?>