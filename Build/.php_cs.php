<?php
/**
This file represents the configuration for Code Sniffing PSR-2-related
automatic checks of coding guidelines
Install @fabpot's great php-cs-fixer tool via
 *
 $ composer global require friendsofphp/php-cs-fixer
 *
And then simply run
 *
 $ ./bin/php-cs-fixer fix --config ./Build/.php_cs
 *
inside the TYPO3 directory. Warning: This may take up to 10 minutes.
 *
For more information read:
	 https://www.php-fig.org/psr/psr-2/
	 https://cs.sensiolabs.org
 */
if (PHP_SAPI !== 'cli') {
    die('This script supports command line usage only. Please check your command.');
}

$headerComment = <<<COMMENT
This file is part of the package kronova/pr-googlecse.

For the full copyright and license information, please read the
LICENSE file that was distributed with this source code.
COMMENT;

// Return a Code Sniffing configuration using
// all sniffers needed for PSR-2
// and additionally:
//  - Remove leading slashes in use clauses.
//  - PHP single-line arrays should not have trailing comma.
//  - Single-line whitespace before closing semicolon are prohibited.
//  - Remove unused use statements in the PHP source code
//  - Ensure Concatenation to have at least one whitespace around
//  - Remove trailing whitespace at the end of blank lines.
return (new PhpCsFixer\Config)
    ->setRiskyAllowed(true)
    ->setRules([
        '@PSR2' => true,
        'header_comment' => [
            'header' => $headerComment
        ],
        'general_phpdoc_annotation_remove' => [
            'annotations' => [
                'author'
            ]
        ],
        'no_leading_import_slash' => true,
        'no_trailing_comma_in_singleline_array' => true,
        'no_singleline_whitespace_before_semicolons' => true,
        'no_unused_imports' => true,
        'concat_space' => ['spacing' => 'one'],
        'no_whitespace_in_blank_line' => true,
        'ordered_imports' => true,
        'single_quote' => true,
        'no_empty_statement' => true,
        'no_extra_blank_lines' => true,
        'phpdoc_no_package' => true,
        'phpdoc_scalar' => true,
        'no_blank_lines_after_phpdoc' => true,
        'array_syntax' => ['syntax' => 'short'],
        'whitespace_after_comma_in_array' => true,
        'function_typehint_space' => true,
        'single_line_comment_style' => true,
        'no_alias_functions' => true,
        'lowercase_cast' => true,
        'no_leading_namespace_whitespace' => true,
        'native_function_casing' => true,
        'self_accessor' => true,
        'no_short_bool_cast' => true,
        'no_unneeded_control_parentheses' => true
    ])
    ->setFinder(
        (new \PhpCsFixer\Finder)
            ->name('*.php')
            ->exclude('.build')
            ->exclude('var')
            ->in(__DIR__)
    );
