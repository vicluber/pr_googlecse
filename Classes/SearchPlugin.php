<?php

declare(strict_types=1);

namespace KronovaNet\PrGooglecse;

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
use KronovaNet\PrGooglecse\Service\GoogleCseService;
use Psr\Log\LoggerInterface;
use TYPO3\CMS\Core\Cache\Frontend\FrontendInterface;
use TYPO3\CMS\Core\Log\Logger;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Fluid\View\StandaloneView;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

/**
 * Class SearchPlugin
 */
class SearchPlugin
{
    /**
     * @var ContentObjectRenderer
     */
    public $cObj;

    /**
     * @var GoogleCseService
     */
    protected $googleCseService;

    /**
     * @var ExtConf
     */
    protected $extConf;

    /**
     * @var FrontendInterface
     */
    protected $cache;

    /**
     * @var StandaloneView
     */
    protected $standaloneView;

    /**
     * @var Logger
     */
    protected $logger;

    public function __construct(
        GoogleCseService $googleCseService,
        ExtConf $extConf,
        FrontendInterface $cache,
        LoggerInterface $logger
    )
    {
        $this->googleCseService = $googleCseService;
        $this->extConf = $extConf;
        $this->cache = $cache;
        $this->logger = $logger;
    }

    public function render(): string
    {
        $query = trim(GeneralUtility::_GP('prGoogleCseQuery'));
        $start = (int)GeneralUtility::_GP('prGoogleCseStartIndex') ?: 1;
        $pageUid = (int)$this->getTypoScriptFrontendController()->id;
        $pageType = (int)GeneralUtility::_GP('type');
        $cacheIdentifier = md5($query . $start);
        // get cached result / search form if cache is enabled and cache entry is exists
        if ($this->extConf->isEnableCache() && $this->cache->has($cacheIdentifier)) {
            $content = $this->cache->get($cacheIdentifier);
        } else {
            $this->initializeStandaloneView();
            $this->standaloneView->assign('pageUid', $pageUid);
            $this->standaloneView->assign('pageType', $pageType);
            if ($query) {
                try {
                    // only send request if query is not empty
                    $response = $this->googleCseService->search($query, $start);
                    $this->standaloneView->assign('response', $response);
                    $this->standaloneView->assign('prGoogleCseQuery', $query);
                    $this->standaloneView->setTemplate('Results');
                } catch (\Exception $exception) {
                    // show template that search is currently not available
                    $this->extConf->setEnableCache(false);
                    $this->standaloneView->setTemplate('Error');
                    $this->logger->error('Exception during search!', ['exception' => $exception]);
                }
            } else {
                // otherwise render the form template
                $this->standaloneView->setTemplate('Form');
            }
            $content = $this->standaloneView->render();
            if ($this->extConf->isEnableCache()) {
                $this->cache->set($cacheIdentifier, $content, [], $this->extConf->getCacheLifetime());
            }
        }
        return $content;
    }

    protected function initializeStandaloneView(): void
    {
        $this->standaloneView = GeneralUtility::makeInstance(StandaloneView::class, $this->cObj);
        $this->standaloneView->getTemplatePaths()->fillDefaultsByPackageName('pr_googlecse');
        $this->standaloneView->getRenderingContext()->setControllerName('Search');
        $this->standaloneView->getRequest()->setControllerExtensionName('pr_googlecse');
    }

    protected function getTypoScriptFrontendController(): TypoScriptFrontendController
    {
        return $GLOBALS['TSFE'];
    }
}
