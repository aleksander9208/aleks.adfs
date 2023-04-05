<?php

declare(strict_types=1);

namespace Lepricon\Adfs\Helper;

/**
 * Метод для логирования ошибок
 */
class ErrorHelper
{
    /**
     * @param $auth
     * @return void
     */
    public static function inErrors($auth): void
    {
        if (!empty($auth->getErrors())) {
            echo '<p>',implode(', ', $auth->getErrors()),'</p>';
            if ($auth->getSettings()->isDebugActive()) {
                echo '<p>'.htmlentities($auth->getLastErrorReason()).'</p>';
            }
        }
    }
}
