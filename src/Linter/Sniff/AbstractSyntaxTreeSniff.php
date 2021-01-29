<?php declare(strict_types=1);
namespace Helmich\TypoScriptLint\Linter\Sniff;

use Helmich\TypoScriptLint\Linter\LinterConfiguration;
use Helmich\TypoScriptLint\Linter\Report\File;
use Helmich\TypoScriptLint\Linter\Sniff\Visitor\SniffVisitor;
use Helmich\TypoScriptParser\Parser\AST\Statement;
use Helmich\TypoScriptParser\Parser\Traverser\Traverser;

/**
 * Abstract base class for sniffs that inspect a file's syntax tree
 *
 * @package Helmich\TypoScriptLint
 * @subpackage Linter\Sniff
 */
abstract class AbstractSyntaxTreeSniff implements SyntaxTreeSniffInterface
{

    public function __construct(array $parameters)
    {
    }

    /**
     * @param Statement[]         $statements
     */
    public function sniff(array $statements, File $file, LinterConfiguration $configuration): void
    {
        $visitor = $this->buildVisitor();

        $traverser = new Traverser($statements);
        $traverser->addVisitor($visitor);
        $traverser->walk();

        foreach ($visitor->getIssues() as $issue) {
            $file->addIssue($issue);
        }
    }

    abstract protected function buildVisitor(): SniffVisitor;
}
