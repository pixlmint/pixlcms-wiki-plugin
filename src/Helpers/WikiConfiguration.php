<?php

namespace PixlMint\WikiPlugin\Helpers;

use Nacho\Exceptions\ConfigurationDoesNotExistException;
use Nacho\Helpers\ConfigurationHelper;

class WikiConfiguration
{
    public static function version(): string
    {
        return self::getJournalConfig('version');
    }

    private static function getJournalConfig(string $configName): mixed
    {
        $helper = ConfigurationHelper::getInstance();
        $config = $helper->getCustomConfig('wiki');

        if (!key_exists($configName, $config)) {
            throw new ConfigurationDoesNotExistException("${configName} does not exist in journal configuration");
        }

        return $config[$configName];
    }
}