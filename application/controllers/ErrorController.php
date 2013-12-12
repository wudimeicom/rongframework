<?php
class ErrorController extends Rong_Controller
{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function indexAction()
	{
		echo "Error! URL Not Found!<br />";
		echo "ErrorController::indexAction()";
	}
}