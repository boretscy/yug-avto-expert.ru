<?php 
$APPLICATION->AddChainItem('Документы', '');

$userGuid = $GLOBALS['CABINET_USER']['PROPERTY_GUID_VALUE'] ?? '';
$vin = $data['vin'] ?? '';
$numDoc = (string)($_GET['doc'] ?? '');

$rawResponse = $cab::getGenerateADocument($userGuid, $vin, $numDoc);

if ( empty($rawResponse['Doc']) ) {
    ShowError('Не удалось сформировать документ. Пожалуйста, обратитесь к менеджеру автосалона.');
    return;
}

$binary = base64_decode($rawResponse['Doc'], true);

if ( empty($binary) ) {
    ShowError('Ошибка декодирования содержимого документа.');
    return;
}

while ( ob_get_level() ) {
    ob_end_clean();
}

header('Content-Type: application/pdf');
header('Content-Disposition: inline; filename="document_' . urlencode($numDoc) . '.pdf"');
header('Content-Length: ' . strlen($binary));

echo $binary;
exit;
