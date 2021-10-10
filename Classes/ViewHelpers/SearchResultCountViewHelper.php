<?php

declare(strict_types=1);

/*
 * This file is part of the package kronova/pr-googlecse.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace KronovaNet\PrGooglecse\ViewHelpers;

use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;

class SearchResultCountViewHelper extends AbstractViewHelper
{
    use CompileWithRenderStatic;

    public function initializeArguments(): void
    {
        parent::initializeArguments();
        $this->registerArgument('totalResults', 'integer', 'Amount of total results', true);
        $this->registerArgument('resultsPerPage', 'integer', 'Results per page to calculate the start index', true);
        $this->registerArgument('maxPagesToDisplay', 'integer', 'Max amount of pages to display', false, 10);
        $this->registerArgument('startIndex', 'integer', 'The current start index', false, 10);
    }

    public static function renderStatic(
        array $arguments,
        \Closure $renderChildrenClosure,
        RenderingContextInterface $renderingContext
    ): array {
        $totalPages = $arguments['totalResults'] / $arguments['resultsPerPage'];
        $currentPage = round($arguments['startIndex'] / $arguments['resultsPerPage']);
        $lastPage = $totalPages > $arguments['maxPagesToDisplay'] ? $arguments['maxPagesToDisplay'] : $totalPages;
        $page = $currentPage > ($totalPages * 0.6) ? round($totalPages * 0.4) : 1;
        $pages = [];
        for ($page; $page <= $lastPage; $page++) {
            $pages[$page] = $arguments['resultsPerPage'] * $page;
        }
        return $pages;
    }
}
