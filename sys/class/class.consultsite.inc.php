<?php

	/**
	 * Builds and manipulates a CL Consultant Website
	 * 
	 * @author Todd Flom
	 * @copyright 2013 Carmichael Lynch
	 * 
	 */


class ConsultSite extends DB_Connect
{
	
	
	/**
	 * Creates a database object and stores relevant data
	 * Upon instantiation, this class accepts a database object
	 * that, if not null, is stored in the object's private $_db
	 * property. If null, a new PDO object is created and stored
	 * instead.
	 *
	 * @param object $dbo a database object
	 * @param int $useStep the step to use to set up the app
	 * @return void
	 *
	 */
	
	public function __construct($dbo=NULL)
	{
		/*
		 * Call the parent constructor to check for a database object
		*/
		parent::__construct($dbo);
	}
	
	
	/**
	 * Returns HTML markup to display the initial Consultant Site View
	 *
	 * @return string the process HTML markup
	 */
	
	public function buildSite()
	{
		$html = '<div class="pagewrapper">';
		
		$html .= '<div id="header">'
					. '<div id="header_wrapper">'
					. '<a class="clLogo" href="http://carmichaellynch.com/"></a>'
					. '<div class="spacer"></div>'
					. '<div class="horizontalRule"></div>'
					. '</div>'
					. '</div>'
					. '<div class="spacer"></div>';
		
		$html .= '</div>';
		
		return $html;
	}
	
}


?>
