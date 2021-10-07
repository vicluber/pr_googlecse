<?php

declare(strict_types=1);

namespace KronovaNet\PrGooglecse\Configuration;

/*
 * This file is part of the pr_googlecse project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use KronovaNet\PrGooglecse\Exception\IncompleteConfigurationException;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * GoogleMapsController
 */
class ExtConf implements SingletonInterface
{
    /**
     * @var string
     */
    protected $googleApiKey = '';

    /**
     * @var string
     */
    protected $googleCseKey = '';

    /**
     * @var bool
     */
    protected $enableCache = true;

    /**
     * @var int
     */
    protected $cacheLifetime = 300;

    /**
     * @var array
     */
    protected $requiredSettings = ['googleApiKey' => true, 'googleCseKey' => true];

    /**
     * ExtConf constructor.
     */
    public function __construct()
    {
        // get global configuration
        $extConf = GeneralUtility::makeInstance(ExtensionConfiguration::class)->get('pr_googlecse');
        $missingRequiredSettings = $this->requiredSettings;
        if (is_array($extConf) && count($extConf)) {
            // call setter method foreach configuration entry
            foreach ($extConf as $key => $value) {
                $methodName = 'set' . ucfirst($key);
                if (method_exists($this, $methodName)) {
                    $reflectionMethod = new \ReflectionMethod($this, $methodName);
                    $type = $reflectionMethod->getParameters()[0]->getType();
                    if ($type) {
                        settype($value, $type->getName());
                    }
                    $this->$methodName($value);
                }
                if (array_key_exists($key, $missingRequiredSettings)) {
                    unset($missingRequiredSettings[$key]);
                }
            }
        }
        if (count($missingRequiredSettings)) {
            throw new IncompleteConfigurationException(
                'The following required settings are missing in your extension configuration: '
                . implode(', ', array_keys($missingRequiredSettings)),
                1527962959
            );
        }
    }

    public function getGoogleApiKey(): string
    {
        return $this->googleApiKey;
    }

    public function setGoogleApiKey(string $googleApiKey): void
    {
        $this->googleApiKey = trim((string)$googleApiKey);
    }

    public function getGoogleCseKey(): string
    {
        return $this->googleCseKey;
    }

    public function setGoogleCseKey(string $googleCseKey): void
    {
        $this->googleCseKey = $googleCseKey;
    }

    public function isEnableCache(): bool
    {
        return $this->enableCache;
    }

    public function setEnableCache(bool $enableCache): void
    {
        $this->enableCache = (bool)$enableCache;
    }

    public function getCacheLifetime(): int
    {
        return $this->cacheLifetime;
    }

    public function setCacheLifetime(int $cacheLifetime): void
    {
        $this->cacheLifetime = $cacheLifetime;
    }
}
