<?php
/**
 * No-op parser for phpBB-specific Twig tags in syntax-only tests.
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use Twig\Node\Node;
use Twig\Node\TextNode;
use Twig\Token;
use Twig\TokenParser\AbstractTokenParser;

final class template_noop_token_parser extends AbstractTokenParser
{
	private string $tag;

	public function __construct(string $tag)
	{
		$this->tag = $tag;
	}

	public function parse(Token $token): Node
	{
		$stream = $this->parser->getStream();
		while (!$stream->test(Token::BLOCK_END_TYPE))
		{
			$stream->next();
		}
		$stream->expect(Token::BLOCK_END_TYPE);

		return new TextNode('', $token->getLine());
	}

	// phpcs:ignore PhpbbCodingStandard.NamingConventions.LowercaseUnderscoredFunctions.NotAllowed -- Required Twig API.
	public function getTag(): string
	{
		return $this->tag;
	}
}
