<?php

declare(strict_types=1);

namespace Aleks\Adfs\Events;

use Bitrix\Main\Application;

/**
 * Метод для события по пользователю
 */
class User
{
    /**
     * Удаляем ответ от ADFS авторизации
     * чтобы было возможно разлогинеться
     *
     * @param $arParams
     * @return void
     */
    public static function OnAfterUserLogoutHandler($arParams)
    {
        $session = Application::getInstance()->getSession();
        if ($session->get('AuthNRequestID')) {
            $session->remove('AuthNRequestID');
        }
    }
}
