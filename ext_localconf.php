<?php
if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

call_user_func(function () {
    $iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
    $iconRegistry->registerIcon(
        'googlecse-extension-icon',
        \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
        ['source' => 'EXT:pr_googlecse/Resources/Public/Icons/Extension.svg']
    );

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
        'mod {
            wizards.newContentElement.wizardItems.plugins {
                elements {
                    pr_googlecse {
                        iconIdentifier = googlecse-extension-icon
                        title = LLL:EXT:pr_googlecse/Resources/Private/Language/locallang_db.xlf:plugin.title
                        description = LLL:EXT:pr_googlecse/Resources/Private/Language/locallang_db.xlf:plugin.description
                        tt_content_defValues {
                            CType = list
                            list_type = pr_googlecse
                        }
                    }
                }
                show = *
            }
       }'
    );

    // Cache for google result
    if (!is_array($GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['pr_googlecse'])) {
        $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['pr_googlecse'] = [
            'frontend' => \TYPO3\CMS\Core\Cache\Frontend\VariableFrontend::class,
            'backend' => \TYPO3\CMS\Core\Cache\Backend\Typo3DatabaseBackend::class,
            'options' => [],
            'groups' => []
        ];
    }

});
