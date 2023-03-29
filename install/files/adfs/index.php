<?php

declare(strict_types=1);

use Bitrix\Main\Loader;
use Lepricon\Adfs\Helper\MetaDataHelper;
use OneLogin\Saml2\Error;

require($_SERVER["DOCUMENT_ROOT"] ."/bitrix/modules/main/include/prolog_before.php");

Loader::includeModule('korus.adfs');

try {
    MetaDataHelper::getMetaData();
} catch (Error|Exception $e) {
    echo $e->getMessage();
}