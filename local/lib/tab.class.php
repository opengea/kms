<?php
// ******************************************************************
//
// 	Intergrid KMS Tab Class
//
//	Package version : 2.0
//      Last update     : 12/08/2011
// 	Author		: Jordi Berenguer
// 	Company 	: Intergrid Tecnologies del coneixement SL
// 	Country		: Catalonia
//      Email           : j.berenguer@intergrid.cat
//	Website		: www.intergrid.cat
//
// ******************************************************************

// Reporting
ini_set('register_globals',0);
error_reporting(E_ALL&~E_NOTICE&~E_WARNING&~E_STRICT);
// Mod management class
include_once("/usr/local/kms/lib/mod.class.php");
// depreacted:  include_once("/usr/local/kms/lib/dataManager.class.php");

// Base class for knowledge managment
class tab extends appInterface {

	// variables declaration
	var $id;
	var $title;
	var $focus;
	var $mod	= array();
	var $t = 1;

 	// Constructor
	function tab($tab,$mod) {
		parent::appInterface();
	}

	function _set_title($n,$title) {


	}

	function _focus_tab($n) {


	}

	function _create_tab($n) {


	}

	function _destroy_tab($n) {



	}

        function _open_tab($i,$mod) {


		
//               $this->tab[$i]->_load_mod($mod);



        }


}  // end class
?>
