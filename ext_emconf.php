<?php
$EM_CONF[$_EXTKEY] = array(
        'title' => 'Google Custom Search Engine',
        'description' => 'Use the Custom Search Engine as Frontend-Plugin.',
        'category' => 'plugin',
        'state' => 'alpha',
        'uploadfolder' => 0,
        'createDirs' => '',
        'clearCacheOnLoad' => 0,
        'author' => 'Pascal Rinker',
        'author_email' => 'prinker@jweiland.net',
        'author_company' => 'jweiland.net',
        'version' => '0.0.1',
        'constraints' => array(
                'depends' => array(
                        'typo3' => '7.6.0-7.6.99',
                ),
                'conflicts' => array(),
                'suggests' => array(),
        ),
);
