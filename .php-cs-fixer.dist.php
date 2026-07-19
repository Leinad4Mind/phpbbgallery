<?php

// phpBB coding-guidelines formatter config for gold-phpbb-ext.
// Only whitespace/style rules that map directly to the phpBB coding
// guidelines are enabled here - no risky or structural rewrites.

$finder = PhpCsFixer\Finder::create()
	->in(__DIR__ . '/_forum/ext')
	->exclude(['vendor', 'tests', 'styles', 'adm'])
	->name('*.php');

return (new PhpCsFixer\Config())
	->setRiskyAllowed(false)
	->setIndent("\t")
	->setLineEnding("\n")
	->setRules([
		'indentation_type' => true,
		'line_ending' => true,
		'braces_position' => [
			'control_structures_opening_brace' => 'next_line_unless_newline_at_signature_end',
			'functions_opening_brace' => 'next_line_unless_newline_at_signature_end',
		],
		'single_space_around_construct' => true,
		'binary_operator_spaces' => [
			'default' => 'single_space',
			'operators' => ['=>' => 'align_single_space_minimal'],
		],
		'spaces_inside_parentheses' => true,
		'single_quote' => true,
		'array_syntax' => ['syntax' => 'short'],
		'no_trailing_whitespace' => true,
		'no_trailing_whitespace_in_comment' => true,
		'single_blank_line_at_eof' => true,
		'lowercase_keywords' => true,
		'constant_case' => ['case' => 'lower'],
	])
	->setFinder($finder);
