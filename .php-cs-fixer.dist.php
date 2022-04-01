<?php

$finder = Symfony\Component\Finder\Finder::create()
    ->in([
        __DIR__.'/src',
    ])
    ->name('*.php')
    ->notName('*.blade.php');

return (new PhpCsFixer\Config())
    ->setUsingCache(false)
    ->setRiskyAllowed(true)
    ->setRules([
        '@Symfony' => true,
        'array_syntax' => ['syntax' => 'short'],
        'increment_style' => ['style' => 'post'],
        'multiline_whitespace_before_semicolons' => ['strategy' => 'no_multi_line'],
        'semicolon_after_instruction' => false,
        'strict_comparison' => true,
        'yoda_style' => false,
        'phpdoc_separation' => false,
        'no_superfluous_phpdoc_tags' => false,
        'php_unit_method_casing' => ['case' => 'snake_case'],
    ])
    ->setFinder($finder);
