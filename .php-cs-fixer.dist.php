<?php

return (new PhpCsFixer\Config())
    ->setRiskyAllowed(false)
    ->setRules([
        '@PSR1' => true,
        '@PSR2' => true,
        '@PSR12' => true,
        // Zusätzliche Regeln für eine strengere Codierungskonvention
        'array_syntax' => ['syntax' => 'short'],
        'binary_operator_spaces' => [
            'default' => 'align_single_space_minimal',
            'operators' => ['=' => 'align_single_space_minimal']
        ],
        'blank_line_after_namespace' => true,
        'blank_line_after_opening_tag' => true,
        'blank_line_before_statement' => ['statements' => ['return']],
        'braces' => ['allow_single_line_closure' => true],
        'cast_spaces' => true,
        'class_definition' => ['single_line' => true],
        'concat_space' => ['spacing' => 'one'],
        'declare_equal_normalize' => true,
        'function_declaration' => true,
        'indentation_type' => true,
        'lowercase_cast' => true,
        'method_argument_space' => true,
        'no_unused_imports' => true,
        'single_quote' => true,
        'trailing_comma_in_multiline' => ['elements' => ['arrays']],
        'phpdoc_align' => ['align' => 'left'],
        'phpdoc_indent' => true,
        'phpdoc_no_alias_tag' => true,
        'phpdoc_scalar' => true,
        'phpdoc_separation' => true,
        'phpdoc_single_line_var_spacing' => true,
        'phpdoc_trim' => true,
        'phpdoc_types_order' => ['null_adjustment' => 'always_last', 'sort_algorithm' => 'none'],
    ])
    ->setFinder(
        PhpCsFixer\Finder::create()
            ->in('Test')
            ->in('src/App')
            ->exclude('src/App/main.php')
            ->exclude('src/App/Provider/TokenDataProvider.php')
            ->name('*.php')
    );
