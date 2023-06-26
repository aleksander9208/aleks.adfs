<?php

declare(strict_types=1);

namespace Aleks\Adfs\Events;

use Bitrix\Main\Application;

/**
 * Метод для события по главному модулю
 */
class Main
{
    /**
     * Удаляем ответ от ADFS авторизации
     * чтобы было возможно разлогинеться
     *
     * @param $arParams
     * @return void
     */
    public static function OnAfterUserLogoutHandler(&$arParams): void
    {
        $session = Application::getInstance()->getSession();
        if ($session->get('AuthNRequestID')) {
            $session->remove('AuthNRequestID');
            $session->remove('NoAuth');
        }
    }
}