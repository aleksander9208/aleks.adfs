<?php

declare(strict_types=1);

use Bitrix\Main\Localization\Loc;

if(!check_bitrix_sessid()) {
    return;
}

global $obModule;
if(!is_object($obModule)) {
    return;
}

if (is_array($obModule->errors) && count($obModule->errors)) {
    echo CAdminMessage::ShowMessage([
        'TYPE' => 'ERROR',
        'MESSAGE' => Loc::getMessage('MODULE_UNINSTALL_ERROR'),
        'DETAILS' => implode('<br>', $obModule->errors),
        'HTML' => true,
    ]);
} else {
    echo CAdminMessage::ShowNote(GetMessage('MODULE_UNINSTALLED'));
}
?>

<form action='<?= $APPLICATION->GetCurPage() ?>'>
    <input type='hidden' name='lang' value='<?= LANG ?>'>
    <input type='submit' name='' value='<?= Loc::getMessage('MODULE_SUBMIT_BACK') ?>'>
</form>