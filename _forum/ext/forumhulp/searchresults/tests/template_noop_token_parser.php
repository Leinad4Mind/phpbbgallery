<?php

namespace forumhulp\searchresults\tests;

use Twig\Node\Node;
use Twig\Token;
use Twig\TokenParser\AbstractTokenParser;

class template_noop_token_parser extends AbstractTokenParser
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

		return new Node([], [], $token->getLine());
	}

	// phpcs:ignore PhpbbCodingStandard.NamingConventions.LowercaseUnderscoredFunctions.NotAllowed
	public function getTag(): string
	{
		return $this->tag;
	}
}
