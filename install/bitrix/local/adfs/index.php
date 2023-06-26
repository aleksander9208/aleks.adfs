<?php

const NOT_CHECK_PERMISSIONS = true;
const NEED_AUTH = false;
const NO_KEEP_STATISTIC = true;

require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include/prolog_before.php");

global $APPLICATION;

$APPLICATION->IncludeComponent(
    'aleks:adfs',
    '',
);
