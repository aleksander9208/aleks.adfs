<?php

declare(strict_types=1);

namespace Aleks\Adfs\Helper;

use Bitrix\Main\Context;
use CMain;

/**
 * Метод для работы со ссылками
 */
class UrlHelper
{
    /**
     * Возвращаем адрес сайта
     *
     * @return string
     */
    public static function getUrlHost(): string
    {
        $server = Context::getCurrent()->getServer();
        $page = (CMain::IsHTTPS()) ? 'https://' : 'http://';

        return $page . $server->getServerName();
    }
}