<?php
namespace Kronovanet\PrGooglecse\Domain\Model;

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
     *zi
     *  This copyright notice MUST APPEAR in all copies of the script!
     ***************************************************************/

/**
 * Class Search
 * @package Kronovanet\GoogleCse\Domain\Model
 */
class Search {
    /**
     * @var string
     */
    protected $query = '';

    /**
     * @var int
     */
    protected $startIndex = 1;

    /**
     * @var int
     */
    protected $totalResults = 0;

    /**
     * @var array
     */
    protected $links = array();

    /**
     * Returns the address
     *
     * @return string
     */
    public function getQuery() {
        return $this->query;
    }

    /**
     * Sets the address
     *
     * @param string $query
     * @return void
     */
    public function setQuery($query) {
        $query = trim((string)$query);
        // security
        $query = htmlspecialchars(strip_tags($query));
        // save encoded string
        $this->query = $query;
    }

    /**
     * @return int
     */
    public function getStartIndex() {
        return $this->startIndex;
    }

    /**
     * @param int $startIndex
     */
    public function setStartIndex($startIndex) {
        $this->startIndex = (int)$startIndex;
    }

    /**
     * @return int
     */
    public function getTotalResults() {
        return $this->totalResults;
    }

    /**
     * @param int $totalResults
     */
    public function setTotalResults($totalResults) {
        $this->totalResults = (int)$totalResults;
    }

    /**
     * @return array
     */
    public function getLinks() {
        return $this->links;
    }

    /**
     * @param array $links
     */
    public function setLinks($links) {
        $this->links = $links;
    }
}