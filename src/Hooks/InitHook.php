<?php

namespace PixlMint\WikiPlugin\Hooks;

use PixlMint\CMS\Contracts\InitFunction;
use PixlMint\WikiPlugin\Helpers\WikiConfiguration;

class InitHook implements InitFunction
{
    private WikiConfiguration $configuration;

    public function __construct(WikiConfiguration $configuration)
    {
        $this->configuration = $configuration;
    }

    public function call(array $init): array
    {
        $init['wikiVersion'] = $this->configuration->version();

        return $init;
    }
}