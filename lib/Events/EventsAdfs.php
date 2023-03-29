<?php

declare(strict_types=1);

namespace Lepricon\Adfs\Events;

use Bitrix\Main\Application;
use Lepricon\Adfs\Helper\SettingsHelper;
use OneLogin\Saml2\Auth;
use OneLogin\Saml2\Error;

/**
 * Метод для переопределения событий
 * в модуле
 */
class EventsAdfs
{
    /**
     * @param array $fields
     * @return void
     * @throws Error
     */
    public static function OnAfterUserLoginHandler(array &$fields): void
    {
        //TODO раскоментировать если нужно чтобы администратора не проверяли в системе
//        if ($fields['USER_ID'] >= 0 || $fields['USER_ID'] != 1) {
        if ($fields['USER_ID'] >= 0) {
            $auth = new Auth(SettingsHelper::getSettings());

            if($auth->login()) {
                $session = Application::getInstance()->getSession();
                if (!$session->has('adfs'))
                {
                    $session->set('adfs', $auth);
                }
            }
        }
    }
}