<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

$arComponentDescription = [
    'NAME' => GetMessage('ALEKS_ADFS_COMPONENT_NAME'),
    'DESCRIPTION' => GetMessage('ALEKS_ADFS_REQUEST_COMPONENT_DESC'),
    'ICON' => '',
    'SORT' => 5,
    'CACHE_PATH' => 'Y',
    'PATH' => [
        'ID' => 'content',
        'CHILD' => [
            'ID' => 'aleks',
            'NAME' => GetMessage('ALEKS_ADFS_COMPONENT_GROUP'),
            'SORT' => 1,
        ],
    ],
];