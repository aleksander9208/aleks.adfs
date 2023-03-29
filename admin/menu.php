<?php

declare(strict_types=1);

use Bitrix\Main\Localization\Loc;

$aMenuStickers = [
    'parent_menu' => 'global_menu_settings',
    'section' => 'GENERAL',
    'sort' => 100,
    'text' => Loc::getMessage('MYMODULE_MENU_TITLE'),
    'title' => Loc::getMessage('MYMODULE_MENU_TITLE'),
    'icon'=> 'menu_support',
    'page_icon'=> 'support',
    'items_id' => 'menu_hints_comments',
    'url' => '/bitrix/admin/adfs_setting_admin.php?lang=' .LANGUAGE_ID,
    'more_url' => [],
    'items' => []
];

$aMenu = [
    $aMenuStickers
];

return $aMenu;