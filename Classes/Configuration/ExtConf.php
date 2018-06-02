<?php
namespace CryntonCom\PrGooglecse\Configuration;

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

use CryntonCom\PrGooglecse\Exception\IncompleteConfigurationException;
use TYPO3\CMS\Core\SingletonInterface;

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
        $extConf = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['pr_googlecse']);
        $missingRequiredSettings = $this->requiredSettings;
        if (is_array($extConf) && count($extConf)) {
            // call setter method foreach configuration entry
            foreach ($extConf as $key => $value) {
                $methodName = 'set' . ucfirst($key);
                if (method_exists($this, $methodName)) {
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
                . implode(', ', $missingRequiredSettings),
                1527962959
            );
        }
    }

    /**
     * Returns the googleApiKey
     *
     * @return string
     */
    public function getGoogleApiKey(): string
    {
        return $this->googleApiKey;
    }

    /**
     * Sets the googleApiKey
     *
     * @param string $googleApiKey
     * @return void
     */
    public function setGoogleApiKey(string $googleApiKey)
    {
        $this->googleApiKey = trim((string)$googleApiKey);
    }

    /**
     * Returns the googleCseKey
     *
     * @return string
     */
    public function getGoogleCseKey(): string
    {
        return $this->googleCseKey;
    }

    /**
     * Sets the googleCseKey
     *
     * @param string $googleCseKey
     * @return void
     */
    public function setGoogleCseKey(string $googleCseKey)
    {
        $this->googleCseKey = $googleCseKey;
    }

    /**
     * @return bool
     */
    public function isEnableCache(): bool
    {
        return $this->enableCache;
    }

    /**
     * @param int|bool $enableCache
     */
    public function setEnableCache($enableCache)
    {
        $this->enableCache = (bool)$enableCache;
    }

    /**
     * @return int
     */
    public function getCacheLifetime(): int
    {
        return $this->cacheLifetime;
    }

    /**
     * @param int $cacheLifetime
     */
    public function setCacheLifetime(int $cacheLifetime)
    {
        $this->cacheLifetime = $cacheLifetime;
    }
}