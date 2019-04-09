<?php
$EM_CONF[$_EXTKEY] = [
        'title' => 'Google custom search engine',
        'description' => 'Frontend search plugin that uses the Google CSE api.',
        'category' => 'plugin',
        'state' => 'stable',
        'uploadfolder' => 0,
        'createDirs' => '',
        'clearCacheOnLoad' => 0,
        'author' => 'Pascal Rinker',
        'author_email' => 'info@kronova.net',
        'author_company' => 'kronova.net',
        'version' => '1.1.1',
        'constraints' => [
                'depends' => [
                        'typo3' => '8.7.0-9.5.99',
                ],
                'conflicts' => [],
                'suggests' => [],
        ]
];
