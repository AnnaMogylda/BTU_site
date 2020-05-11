<?php

// Подключаем SOAP
require_once('nusoap/nusoap.php');
$server = new nusoap_server;
$server->register('updateBill');
$server->service(file_get_contents("php://input"));

// Эта функция вызывается при уведомлениях от QIWI Кошелька
function updateBill($login, $password, $txn, $status)
{
	// Если уведомление не о успешной оплате, нам это не интересно
	if($status!=60)
		return new soapval('updateBillResult', 'xsd:integer', 0); 

	// Работаем в корневой директории
	chdir ('../../');
	
	// Подключаем основной класс
	require_once('api/Home.php');
	$h = new Home();

	// Выбираем оплачиваемый заказ
	$order = $h->orders->get_order(intval($txn));
	
	// 210 = Счет не найден
	if(empty($order))
		return new soapval('updateBillResult', 'xsd:integer', 210); 
		
	// Выбираем из базы соответствующий метод оплаты
	$method = $h->payment->get_payment_method(intval($order->payment_method_id));
	if(empty($method))
		return new soapval('updateBillResult', 'xsd:integer', 210);
	// Настройки способа оплаты	
	$settings = unserialize($method->settings);

	// Проверяем логин
	// 150 = Ошибка авторизации (неверный логин/пароль)
	if(empty($login) || ($settings['qiwi_login'] !== $login))
		return new soapval('updateBillResult', 'xsd:integer', 150); 

	// Проверяем пароль
	// 150 = Ошибка авторизации (неверный логин/пароль)
	if(empty($password) || (strtoupper(md5($txn.strtoupper(md5($settings['qiwi_password'])))) !== strtoupper($password)))
		return new soapval('updateBillResult', 'xsd:integer', 150); 

	// Нельзя оплатить уже оплаченный заказ 
	// 215 = Счет с таким txn-id уже существует
	if($order->paid)
		return new soapval('updateBillResult', 'xsd:integer', 215);
		
	// Проверка наличия товара
	$purchases = $h->orders->get_purchases(array('order_id'=>intval($order->id)));
	foreach($purchases as $purchase)
	{
		$variant = $h->variants->get_variant(intval($purchase->variant_id));
		if(empty($variant) || (!$variant->infinity && $variant->stock < $purchase->amount))
		{
			// 300 = Неизвестная ошибка
			return new soapval('updateBillResult', 'xsd:integer', 300); 
		}
	}
	
	// Установим статус оплачен
	$h->orders->update_order(intval($order->id), array('paid'=>1));
	
	// Спишем товары  
	$h->orders->close(intval($order->id));
	$h->notify->email_order_user(intval($order->id));
	$h->notify->email_order_admin(intval($order->id));

	// Успешное завершение
	return new soapval('updateBillResult', 'xsd:integer', 0); 
}

