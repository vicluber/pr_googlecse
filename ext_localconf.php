<?php
if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'Kronovanet.' . $_EXTKEY,
        'GoogleCse',
        array(
                'GoogleSearch' => 'form, search',
        ),
        // non-cacheable actions
        array(
                'GoogleSearch' => 'search',
        )
);