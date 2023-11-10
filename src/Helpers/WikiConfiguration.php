<?php

namespace PixlMint\WikiPlugin\Helpers;

use Nacho\Exceptions\ConfigurationValueDoesNotExistException;
use Nacho\Helpers\ConfigurationContainer;

class WikiConfiguration
{
    private ConfigurationContainer $configuration;

    public function __construct(ConfigurationContainer $configuration)
    {
        $this->configuration = $configuration;
    }

    public function version(): string
    {
        return $this->getJournalConfig('version');
    }

    private function getJournalConfig(string $configName): mixed
    {
        $config = $this->configuration->getCustomConfig('wiki');

        if (!key_exists($configName, $config)) {
            throw new ConfigurationValueDoesNotExistException($configName, 'wiki');
        }

        return $config[$configName];
    }
}