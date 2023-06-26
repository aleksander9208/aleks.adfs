<?php

use Bitrix\Main\Loader;
use Aleks\Adfs\Helper\MetaDataHelper;

require($_SERVER["DOCUMENT_ROOT"] ."/bitrix/modules/main/include/prolog_before.php");

Loader::includeModule('aleks.adfs');

try {
    MetaDataHelper::getMetaData();
} catch (\OneLogin\Saml2\Error|Exception $e) {
    echo $e->getMessage();
}