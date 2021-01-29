<?php declare(strict_types=1);
namespace Helmich\TypoScriptLint\Linter\Sniff;

use Helmich\TypoScriptLint\Linter\Sniff\Visitor\NestingConsistencyVisitor;
use Helmich\TypoScriptLint\Linter\Sniff\Visitor\SniffVisitor;

class NestingConsistencySniff extends AbstractSyntaxTreeSniff
{
    /** @var int */
    private $commonPathPrefixThreshold = 1;

    public function __construct(array $parameters)
    {
        if (array_key_exists('commonPathPrefixThreshold', $parameters)) {
            $this->commonPathPrefixThreshold = $parameters['commonPathPrefixThreshold'];
        }
    }

    protected function buildVisitor(): SniffVisitor
    {
        return new NestingConsistencyVisitor($this->commonPathPrefixThreshold);
    }
}
