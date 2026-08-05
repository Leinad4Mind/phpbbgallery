<?php

namespace leinad4mind\officialtopicindex\tests;

use Twig\Node\Node;
use Twig\Node\TextNode;
use Twig\Token;
use Twig\TokenParser\AbstractTokenParser;

final class template_noop_token_parser extends AbstractTokenParser
{
	private $tag;

	public function __construct($tag)
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
