<?php

declare(strict_types=1);

namespace Lepricon\Adfs\Helper;

use Bitrix\Main\Config\Option;

/**
 * Метод для работы с настройками SAML
 */
class SettingsHelper
{
    /** @var string Название модуля для получения настроек */
    public const MODULE_ID = 'korus.adfs';

    /**
     * Возвращаем настройки запросов
     *
     * @return array
     */
    public static function getSettings(): array
    {
        return [
            'debug' => true,
            'sp' => [
                'entityId' => UrlHelper::getUrlHost() .'/adfs/',
                'assertionConsumerService' => [
                    'url' => UrlHelper::getUrlHost() .'/?acs',
                    'binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
                ],
                'singleLogoutService' => [
                    'url' => UrlHelper::getUrlHost() .'/?sls',
                    'binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
                ],
                'NameIDFormat' => 'urn:oasis:names:tc:SAML:1.1:nameid-format:unspecified',
            ],
            'idp' => [
                'entityId' => Option::get(self::MODULE_ID, 'adfs_entity_id'),
                'singleSignOnService' => [
                    'url' => Option::get(self::MODULE_ID, 'adfs_point_entry'),
                    'binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
                ],
                'singleLogoutService' => [
                    'url' => '',
                    'responseUrl' => '',
                    'binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
                ],
                'x509cert' => Option::get(self::MODULE_ID, 'adfs_cert'),
            ],
        ];
    }
}