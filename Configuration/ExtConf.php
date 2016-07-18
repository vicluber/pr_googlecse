<?php
namespace Kronovanet\PrGooglecse\Configuration;


    /***************************************************************
     *
     *  Copyright notice
     *
     *  (c) 2016 Pascal Rinker <prinker@jweiland.net>, jweiland.net
     *
     *  All rights reserved
     *
     *  This script is part of the TYPO3 project. The TYPO3 project is
     *  free software; you can redistribute it and/or modify
     *  it under the terms of the GNU General Public License as published by
     *  the Free Software Foundation; either version 3 of the License, or
     *  (at your option) any later version.
     *
     *  The GNU General Public License can be found at
     *  http://www.gnu.org/copyleft/gpl.html.
     *
     *  This script is distributed in the hope that it will be useful,
     *  but WITHOUT ANY WARRANTY; without even the implied warranty of
     *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
     *  GNU General Public License for more details.
     *
     *  This copyright notice MUST APPEAR in all copies of the script!
     ***************************************************************/
use TYPO3\CMS\Core\SingletonInterface;

/**
 * GoogleMapsController
 */
class ExtConf implements SingletonInterface {
        /**
     * @var string
     */
    protected $googleApiKey = '';

    /**
     * @var string
     */
    protected $googleCseKey = '';

    /**
     * ExtConf constructor.
     */
    public function __construct() {
        // get global configuration
        $extConf = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['pr_googlecse']);
        if (is_array($extConf) && count($extConf)) {
            // call setter method foreach configuration entry
            foreach ($extConf as $key => $value) {
                $methodName = 'set' . ucfirst($key);
                if (method_exists($this, $methodName)) {
                    $this->$methodName($value);
                }
            }
        }
    }

    /**
     * Returns the googleApiKey
     *
     * @return mixed
     */
    public function getGoogleApiKey() {
        return $this->googleApiKey;
    }

    /**
     * Sets the googleApiKey
     *
     * @param $googleApiKey
     * @return void
     */
    public function setGoogleApiKey($googleApiKey) {
        $this->googleApiKey = trim((string)$googleApiKey);
    }

    /**
     * Returns the googleCseKey
     *
     * @return mixed
     */
    public function getGoogleCseKey() {
        return $this->googleCseKey;
    }

    /**
     * Sets the googleCseKey
     *
     * @param $googleCseKey
     * @return void
     */
    public function setGoogleCseKey($googleCseKey) {
        $this->googleCseKey = trim((string)$googleCseKey);
    }
}