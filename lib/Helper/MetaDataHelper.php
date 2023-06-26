<?php

declare(strict_types=1);

namespace Aleks\Adfs\Helper;

use Exception;
use OneLogin\Saml2\Error;
use OneLogin\Saml2\Settings;

/**
 * Метод для работы с данными для ADFS
 */
class MetaDataHelper
{
    /**
     * @return void
     * @throws Error
     * @throws Exception
     */
    public static function getMetaData(): void
    {
        $settings = new Settings(SettingsHelper::getSettings(), true);
        $metadata = $settings->getSPMetadata();
        $errors = $settings->validateMetadata($metadata);
        if (empty($errors)) {
            header('Content-Type: text/xml');
            echo $metadata;
        } else {
            throw new Error(
                'Invalid SP metadata: '.implode(', ', $errors),
                Error::METADATA_SP_INVALID
            );
        }
    }
}