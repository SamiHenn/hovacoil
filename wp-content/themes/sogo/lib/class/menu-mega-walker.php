<?php

class sogo_mega_walker_nav_menu extends Walker_Nav_Menu {


	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {

		if ( in_array( 'menu-image', $item->classes ) ) {
		//	debug( $item );
			//attr_title  = > image
			//description = > url
			$output .= '</div>' . "\n";
			$output .= '<div class="col-md-7">' . "\n";
			$output .= "<div class='menu-image'>
							<a href='{$item->description}'>
								<img src='{$item->attr_title}' alt='{$item->title}'></a>
						</div>";
			$output .= '</div>' . "\n";

		} else {
			parent::start_el( $output, $item, $depth, $args );

		}


	}

	// add classes to ul sub-menus
	function start_lvl( &$output, $depth = 0, $args = array() ) {

	//	if ( $depth > 0  ) {



	//	} else {
			parent::start_lvl( $output, $depth , $args  );
		$output .= '<div class="col-md-5">' . "\n";
	//	}
	}

//	function end_lvl( &$output, $depth = 0, $args = array() ) {
//		if ( $depth > 0  ) {
//			$output .= '<div class="col-md-7">' . "\n";
//			$output .= '</div>' . "\n";
//			$output .= '</div>' . "\n";
//		}
//		$output .= "</ul>\n";
//
//
//
//	}




}