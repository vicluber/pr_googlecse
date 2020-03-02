<?php
$EM_CONF[$_EXTKEY] = [
    'title' => 'Google custom search engine',
    'description' => 'Frontend search plugin that uses the Google CSE api.',
    'category' => 'plugin',
    'state' => 'beta',
    'uploadfolder' => 0,
    'createDirs' => '',
    'clearCacheOnLoad' => 0,
    'author' => 'Pascal Rinker',
    'author_email' => 'info@kronova.net',
    'author_company' => 'kronova.net',
    'version' => '2.0.0',
    'constraints' => [
        'depends' => [
            'typo3' => '9.5.0-10.4.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ]
];
