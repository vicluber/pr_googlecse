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
        'author_email' => 'info@crynton.com',
        'author_company' => 'crynton.com',
        'version' => '1.0.0',
        'constraints' => [
                'depends' => [
                        'typo3' => '8.7.0-9.3.99',
                ],
                'conflicts' => [],
                'suggests' => [],
        ]
];
