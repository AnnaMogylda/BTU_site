<?php

require_once('api/Home.php');


class PaymentModule extends Home
{
 
	public function checkout_form()
	{
		$form = '<input type=submit value="Оплатить">';	
		return $form;
	}
	public function settings()
	{
		$form = '<input type=submit value="Оплатить">';	
		return $form;
	}
}
