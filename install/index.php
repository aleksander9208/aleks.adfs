<?php

declare(strict_types=1);

use Bitrix\Main\Application;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ModuleManager;

/**
 * Установка модуля korus.adfs
 */
Class aleks_adfs extends CModule
{
    /**
     * Настройки передачи параметров
     * в конструкторе
     */
    public function __construct()
    {
        $this->MODULE_ID = 'aleks.adfs';
        $this->MODULE_GROUP_RIGHTS = 'Y';
        $this->PARTNER_NAME = 'Aleksandr9208';

        if( file_exists(__DIR__.'/version.php') ) {
            $arModuleVersion = [];
            include_once(__DIR__.'/version.php');
            $this->MODULE_VERSION = $arModuleVersion['VERSION'];
            $this->MODULE_VERSION_DATE = $arModuleVersion['VERSION_DATE'];
        }

        $this->MODULE_NAME = Loc::getMessage('MODULE_NAME');
        $this->MODULE_DESCRIPTION = Loc::getMessage('MODULE_DESCRIPTION');
    }

    /**
     * Установка модуля
     *
     * @return void
     */
    function DoInstall(): void
    {
        global $APPLICATION;

        /** Регистрируем модуль */
        ModuleManager::registerModule($this->MODULE_ID);

        /** Копируем файлы */
        $this->InstallFiles();

        $APPLICATION->IncludeAdminFile(
            Loc::getMessage('MODULE_INSTALL'),
            __DIR__.'/step.php'
        );
    }

    /**
     * Удаления модуля
     *
     * @return void
     */
    function DoUninstall(): void
    {
        global $APPLICATION;

        /** Удаляем модуль */
        ModuleManager::unRegisterModule($this->MODULE_ID);

        if(empty($this->errors) ) {
            ModuleManager::unRegisterModule($this->MODULE_ID);
        }

        $APPLICATION->IncludeAdminFile(
            Loc::getMessage('MODULE_UNINSTALL'),
            __DIR__.'/unstep1.php'
        );
    }

    /**
     * Копируем файлы
     *
     * @return bool
     */
    function InstallFiles(): void
    {
        /** Копируем файл админки */
        CopyDirFiles(
            __DIR__ .'/bitrix/admin/',
            Application::getDocumentRoot() .'/bitrix/admin/',
            true,
            true
        );

        /** Копируем раздел для отдачи настроек */
        CopyDirFiles(
            __DIR__ .'/adfs/',
            Application::getDocumentRoot() .'/adfs/',
            true,
            true
        );

        /** Копируем компоненты */
        CopyDirFiles(
            __DIR__ . '/bitrix/components',
            $_SERVER['DOCUMENT_ROOT'] . '/bitrix/components',
            true,
            true
        );
    }

    /**
     * Удаляем файлы
     *
     * @return void
     */
    function UnInstallFiles(): void
    {
        DeleteDirFilesEx(Application::getDocumentRoot().'/bitrix/admin/adfs_setting_admin.php');
        DeleteDirFilesEx(Application::getDocumentRoot().'/bitrix/components/korus/adfs');
        DeleteDirFilesEx(Application::getDocumentRoot().'/adfs');
    }
}