<?php
namespace Kronovanet\PrGooglecse\Controller;

use Kronovanet\PrGooglecse\Configuration\ExtConf;
use Kronovanet\PrGooglecse\Domain\Model\Result;
use Kronovanet\PrGooglecse\Domain\Model\Search;

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
class GoogleSearchController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

    /**
     * searchstring for Google Api
     */
    const SEARCHSTRING = 'https://www.googleapis.com/customsearch/v1?q=%s&cx=%s&key=%s&startIndex=%i';
    /**
     * max items per query
     */
    const ITEMSPERQUERY = 10;

    /**
     * @var ExtConf
     */
    protected $extConf = null;

    /**
     * inject extConf
     *
     * @param ExtConf $extConf
     * @return void
     */
    public function injectExtConf(ExtConf $extConf) {
        $this->extConf = $extConf;
    }

    /**
     * show search form
     *
     * @return void
     */
    protected function formAction() {
        $this->view->assign('search', $this->objectManager->get(\Kronovanet\PrGooglecse\Domain\Model\Search::class));
    }

    /**
     * initialize searchAction
     *
     * @return void
     */
    public function initializeSearchAction() {
        if ($this->arguments->hasArgument('search')) {
            $propertyMappingConfiguration = $this->arguments->getArgument('search')->getPropertyMappingConfiguration();
            $propertyMappingConfiguration->allowProperties('query', 'startIndex');
        }
    }

    /**
     * show search results
     *
     * @param Search $search
     * @return void
     * @throws \Exception
     */
    protected function searchAction(Search $search) {
        $content = $this->getResponseFromGoogleSearch($search);
        if ($content === null) throw new \Exception('Status code different from 200', 1454323157);
        $response = json_decode($content['body']);
        if ($response->queries->request[0]->totalResults !== '0') {
            $search->setTotalResults($response->queries->request[0]->totalResults);
            $search->setLinks($this->getSearchPagination($search));
            $this->view->assign('results', $this->getResultObjectStorage($response));
        }
        $this->view->assign('search', $search);

    }

    /**
     * @param Search $search
     * @return array|null
     * @throws \Exception
     */
    protected function getResponseFromGoogleSearch(Search $search) {
        $response = array();
        $findAddressLink = sprintf(self::SEARCHSTRING, $search->getQuery(), $this->extConf->getGoogleCseKey(), $this->extConf->getGoogleApiKey(), $search->getStartIndex());
        try {
            $content = file_get_contents($findAddressLink);
        } catch (\Exception $e) {
            throw new \Exception('No link to Google', 1454323953);
        }
        if (preg_match('#HTTP/[0-9\.]+\s+([0-9]+)#', implode("\r\n", $http_response_header), $matches)) {
            $response['header'] = $http_response_header;
            $response['body'] = $content;
        } else {
            $response = null;
        }
        return $response;
    }

    /**
     * returns an array that includes the pagination array
     *
     * @param Search $search
     * @return array|null
     */
    protected function getSearchPagination(Search $search) {
        /* will be configurable later via TCA */
        $maxPaginationItems = 10;
        /* end */

        $totalResults = $search->getTotalResults();
        $startIndex = $search->getStartIndex();
        $links = null;
        if ($totalResults > self::ITEMSPERQUERY) {
            $links = array();
            $activePage = ($startIndex == 1 ? 1 : ceil($startIndex / self::ITEMSPERQUERY));
            $totalPages = ceil($totalResults / self::ITEMSPERQUERY);
            $startPage = ($activePage > ($maxPaginationItems - 5)) ? $activePage - 5 : 0;
            for ($i = $startPage; $i < $startPage + $maxPaginationItems && $i <= $totalPages; $i++) {
                $links['pagination'][$i + 1] = array(
                    'startIndex' => 1 + ($i * self::ITEMSPERQUERY),
                    'query' => $search->getQuery()
                );
            }
            $links['firstPage'] = array('startIndex' => 1, 'query' => $search->getQuery());
            $links['lastPage'] = array('startIndex' => $search->getTotalResults() - self::ITEMSPERQUERY, 'query' => $search->getQuery());
            $links['activePage'] = $activePage;
            $links['totalPages'] = $totalPages;
        }
        return $links;
    }

    /**
     * includes results from $response to given search object
     *
     * @param \stdClass $response
     * @return \SplObjectStorage|null
     */
    protected function getResultObjectStorage(\stdClass $response) {
        $results = null;
        if (is_array($response->items)) {
            $results = new \SplObjectStorage();
            foreach ($response->items as $responseItem) {
                /**
                 * @var Result $result
                 */
                $result = $this->objectManager->get(Result::class);
                $result->setLink($responseItem->link);
                $result->setSnippet($responseItem->htmlSnippet);
                $result->setTitle($responseItem->htmlTitle);

                $results->attach($result);
            }
        }
        return $results;
    }
}