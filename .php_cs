<?php

$rules = [
    '@Symfony' => true,
    '@Symfony:risky' => true,
    'array_syntax' => ['syntax' => 'short'],
    'array_indentation' => true,
    'binary_operator_spaces' => ['operators' => ['=>' => 'align']],
    'increment_style' => ['style' => 'post'],
    'linebreak_after_opening_tag' => true,
    'mb_str_functions' => true,
    'no_php4_constructor' => true,
    'no_unreachable_default_argument_value' => true,
    'no_useless_else' => true,
    'no_useless_return' => true,
    'not_operator_with_successor_space' => true,
    'ordered_imports' => ['sortAlgorithm' => 'length'],
    'php_unit_strict' => true,
    'phpdoc_order' => true,
    'simplified_null_return' => true,
    'strict_comparison' => true,
    'strict_param' => true,
    'no_extra_consecutive_blank_lines' => true,
    'blank_line_before_return' => true,
    'no_unused_imports' => true,
    'single_line_after_imports' => true,
    'no_blank_lines_after_class_opening' => true,
    'no_blank_lines_after_phpdoc' => true,
    'phpdoc_trim' => true,
];

$excludes = [
    'vendor',
    'storage',
    'node_modules',
];

return PhpCsFixer\Config::create()
    ->setRules($rules)
    ->setFinder(
        PhpCsFixer\Finder::create()
            ->in(__DIR__)
            ->exclude($excludes)
            ->notName('README.md')
            ->notName('*.xml')
            ->notName('*.yml')
            ->notName('_ide_helper.php')
    );