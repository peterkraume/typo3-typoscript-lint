<?php declare(strict_types=1);
namespace Helmich\TypoScriptLint\Linter\Sniff;

use Helmich\TypoScriptLint\Linter\LinterConfiguration;
use Helmich\TypoScriptLint\Linter\Report\File;
use Helmich\TypoScriptParser\Parser\AST\Statement;

interface SyntaxTreeSniffInterface extends SniffInterface
{

    /**
     * @param Statement[]         $statements
     */
    public function sniff(array $statements, File $file, LinterConfiguration $configuration): void;
}
