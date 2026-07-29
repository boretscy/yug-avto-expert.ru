<?php 
$APPLICATION->AddChainItem('Документы', '');
$rawResponse = $cab::getGenerateADocument($GLOBALS['CABINET_USER']['PROPERTY_GUID_VALUE'], $data['vin'], $_GET['doc']);

// YApp::sp($_GET);
// YApp::sd( $rawResponse );

$binary = base64_decode($rawResponse['Doc'], true);

// if (!$binary || !str_starts_with($binary, "%PDF-")) exit("Ошибка: Сервис вернул некорректные данные.");

if (ob_get_length()) ob_end_clean();

header('Content-Type: application/pdf');
header('Content-Disposition: inline; filename="document.pdf"');
header('Content-Length: ' . strlen($binary));

echo $binary;
exit;

?>
