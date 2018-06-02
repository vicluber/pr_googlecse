<?php
// Register frontend plugin
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPlugin(
    [
        'LLL:EXT:pr_googlecse/Resources/Private/Language/locallang_db.xlf:plugin.title',
        'pr_googlecse',
        'EXT:pr_googlecse/Resources/Public/Icons/Extension.svg'
    ],
    'list_type',
    'pr_googlecse'
);