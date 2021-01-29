<?php declare(strict_types=1);
namespace Helmich\TypoScriptLint\Linter\Sniff;

use Helmich\TypoScriptLint\Linter\LinterConfiguration;
use Helmich\TypoScriptLint\Linter\Report\File;
use Helmich\TypoScriptLint\Linter\Report\Issue;
use Helmich\TypoScriptParser\Parser\Parser;
use Helmich\TypoScriptParser\Tokenizer\TokenInterface;
use Helmich\TypoScriptParser\Tokenizer\Tokenizer;

class DeadCodeSniff implements TokenStreamSniffInterface
{

    const ANNOTATION_COMMENT = '/^\s*([a-z0-9]+=(.*?))(;\s*[a-z0-9]+=(.*?))*\s*$/';

    public function __construct(array $parameters)
    {
    }

    /**
     * @param TokenInterface[]    $tokens
     */
    public function sniff(array $tokens, File $file, LinterConfiguration $configuration): void
    {
        foreach ($tokens as $token) {
            if (!($token->getType() === TokenInterface::TYPE_COMMENT_ONELINE
                || $token->getType() === TokenInterface::TYPE_COMMENT_MULTILINE)) {
                continue;
            }

            $commentContent = preg_replace(',^\s*(#|/\*|/)\s*,', '', $token->getValue());

            if (preg_match(static::ANNOTATION_COMMENT, $commentContent)) {
                continue;
            } else if (preg_match(Tokenizer::TOKEN_OPERATOR_LINE, $commentContent, $matches)) {
                try {
                    $parser = new Parser(new Tokenizer());
                    $parser->parseString($commentContent);

                    $file->addIssue(new Issue(
                        $token->getLine(),
                        0,
                        'Found commented code (' . $matches[0] . ').',
                        Issue::SEVERITY_INFO,
                        __CLASS__
                    ));
                } catch (\Exception) {
                    // pass
                }
            }
        }
    }
}
