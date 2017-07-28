<?php
/********************************************
*
*	Filename:	manageStructure.php
*	Author:		Ahmet Oguz Mermerkaya
*	E-mail:		ahmetmermerkaya@hotmail.com
*	Begin:		Sunday, July 6, 2008  20:21
*
*********************************************/

if (isset($_REQUEST['action']) && !empty($_REQUEST['action'])){
	$action = $_REQUEST['action'];	
} else {
	die(FAILED);
}

define("IN_PHP", true);
require_once("common.php");
$out = NULL;

switch($action){
	case "insertElement":
	{}
	break;	
	case  "getElementList":  
	{
		/**
		 * getting element list
		 */
        if( isset($_REQUEST['real_parent']) == true && $_REQUEST['real_parent'] != NULL ) {  	
			$real_parent = checkVariable($_REQUEST['real_parent']); 
		}
		else {
			print $real_parent = 0;
		}
  		$out = $treeManager->getElementList($real_parent, $_SERVER['PHP_SELF']);
    }
	break;		
    case "updateElementName":
    {}    
    break;

	case "deleteElement":
	{}
	break;
	case "changeOrder":
	{}
	break;		
    default:
    	/**
    	 * if an unsupported action is requested, reply it with FAILED
    	 */
      	$out = FAILED;
	break;
}
echo $out;
