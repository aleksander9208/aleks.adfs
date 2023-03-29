<?php

declare(strict_types=1);

use Bitrix\Main\Config\Option;
use Bitrix\Main\Context;

/**
 * @global $APPLICATION CMain
 */

require_once($_SERVER['DOCUMENT_ROOT'] .'/bitrix/modules/main/include/prolog_admin_before.php');

CModule::IncludeModule('lepricon.adfs');

$APPLICATION->SetTitle('Настройки для подключения к ADFS');

require($_SERVER['DOCUMENT_ROOT'] .'/bitrix/modules/main/include/prolog_admin_after.php');

global $USER;

$cache = Bitrix\Main\Data\Cache::createInstance();
$request = Context::getCurrent()->getRequest();

$arFieldsValues = [
    'adfs_point_entry' => '',
    'adfs_entity_id' => '',
    'adfs_cert' => '',
];

$arFieldsNames = [
    'adfs_point_entry' => 'Точка входа(SSO сервера для подключения)',
    'adfs_entity_id' => 'Entity Id подключения к серверу',
    'adfs_cert' => 'Сертификат доступов',
];

if($request['save_form'] === 'Y' && check_bitrix_sessid()) {
    Option::set('korus.adfs', 'adfs_point_entry', $request['adfs_point_entry']);
    Option::set('korus.adfs', 'adfs_entity_id', $request['adfs_entity_id']);
    Option::set('korus.adfs', 'adfs_cert', $request['adfs_cert']);

    if ($request['clear_all'] === 'Y') {
        $cache->clean('korus.adfs.settings', 'korus.adfs/cache');
        $cache->cleanDir( 'korus.adfs/cache');
    }
}
?>
    <form method='POST' action='<?= $APPLICATION->GetCurPage() ?>' name='st_access_form'>
        <input type='hidden' name='save_form' value='Y'>
        <input type='hidden' name='clear_all' value='Y'>
        <?= bitrix_sessid_post() ?>

        <?php
        $aTabs = [
            ['DIV' => 'settings', 'TAB' => 'Настройки', 'TITLE' => 'Настройки подключения к сервису'],
        ];

        if ($cache->initCache(86400, 'korus.adfs.settings', 'korus.adfs/cache')) {
            $arFieldsValues = $cache->getVars();
        } elseif ($cache->startDataCache()) {
            foreach ($arFieldsValues as $code => $field) {
                $arFieldsValues[$code] = Option::get('korus.adfs', $code, '');
            }

            $cache->endDataCache($arFieldsValues);
        }


        $tabControl = new CAdminTabControl('tabControl', $aTabs);
        $tabControl->Begin();
        $tabControl->BeginNextTab(); ?>
        <tr>
            <td colspan='2'>
                <table>
                    <tr></tr>
                    <?php foreach ($arFieldsValues as $code => $value) {?>
                        <tr>
                            <td></td>
                            <td width='100%'>
                                <label>
                                    <?= $arFieldsNames[$code] . ': ' ?>
                                    <textarea placeholder='<?= $arFieldsNames[$code] ?>' name='<?= $code ?>' rows='4' style='margin-top: 10px; width: 100%'><?= $value ?></textarea>
                                </label>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            </td>
        </tr>
        <?php

        $tabControl->EndTab();

        $tabControl->Buttons([
            'disabled' => false,
            'back_url' => '/bitrix/admin/?lang='. LANGUAGE_ID .'&'. bitrix_sessid_get()
        ]);

        $tabControl->End();

        ?>
    </form>

<?php
require($_SERVER['DOCUMENT_ROOT'] .'/bitrix/modules/main/include/epilog_admin.php');