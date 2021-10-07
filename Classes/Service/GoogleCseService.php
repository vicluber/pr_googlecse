<?php

declare(strict_types=1);

namespace KronovaNet\PrGooglecse\Service;

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

use KronovaNet\PrGooglecse\Configuration\ExtConf;
use TYPO3\CMS\Core\Http\RequestFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class GoogleCseService
 */
class GoogleCseService
{
    /**
     * API URL
     */
    private const API_URL = 'https://www.googleapis.com/customsearch/v1?q=%s&cx=%s&key=%s&start=%d';

    /**
     * @var ExtConf
     */
    protected $extConf;

    /**
     * GoogleCseService constructor.
     */
    public function __construct(ExtConf $extConf)
    {
        $this->extConf = $extConf;
    }

    public function search(string $query, int $start): array
    {
        $requestUrl = sprintf(
            self::API_URL,
            urlencode($query),
            urlencode($this->extConf->getGoogleCseKey()),
            urlencode($this->extConf->getGoogleApiKey()),
            $start
        );
        $requestFactory = GeneralUtility::makeInstance(RequestFactory::class);
        $response = $requestFactory->request($requestUrl);
        if ($response->getStatusCode() === 200) {
            return json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);
        } else {
            throw new \HttpResponseException(
                'Your search could not be completed. HTTP response code: ' . $response->getStatusCode()
                . ', Response message: ' . $response->getBody()->getContents(),
                1527430897
            );
        }
    }

}
