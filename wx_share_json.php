<?php
	require_once "jssdk.php";
	$appId = "wx0965b78981bff617";
	$appSecret = "e50e8448dbc3330f14b1b2be9a1688d3";
	$jssdk = new JSSDK($appId, $appSecret);
	$signPackage = $jssdk->GetSignPackage();

	$wxconfig = array(
		"appId" => $signPackage["appId"],
		"timestamp" => $signPackage["timestamp"],
		"nonceStr" => $signPackage["nonceStr"],
		"signature" => $signPackage["signature"],
	);

	echo json_encode($wxconfig);
?>