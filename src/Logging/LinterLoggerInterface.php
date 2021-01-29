<?php declare(strict_types=1);
namespace Helmich\TypoScriptLint\Logging;


use Helmich\TypoScriptLint\Linter\Report\File;
use Helmich\TypoScriptLint\Linter\Report\Report;


/**
 * Interface definition for a progress logger
 *
 * This logger is domain-specific, and implements methods for very specific
 * domain events. This way, how to treat specific events is entirely up to the
 * logger implementation.
 *
 * @author     Martin Helmich <typo3@martin-helmich.de>
 * @license    MIT
 * @package    Helmich\TypoScriptLint
 * @subpackage Logging
 */
interface LinterLoggerInterface
{
    /**
     * Called when a desired input directory/file does not exist
     */
    public function notifyFileNotFound(string $file): void;

    /**
     * Called before linting any input file
     *
     * @param string[] $files The list of filenames to lint
     */
    public function notifyFiles(array $files): void;

    /**
     * Called before linting any specific file
     *
     * @param string $filename The name of the file to be linted
     */
    public function notifyFileStart(string $filename): void;

    /**
     * Called before running a specific sniff on a file
     *
     * @param string $filename   The name of the file to be linted
     * @param string $sniffClass The class name of the sniff to be run
     */
    public function notifyFileSniffStart(string $filename, string $sniffClass): void;

    /**
     * Called after completing a specific sniff on a file
     *
     * @param string $filename   The name of the file that was linted
     * @param string $sniffClass The class name of the sniff that was run
     * @param File   $report     The (preliminary) linting report for this file
     */
    public function nofifyFileSniffComplete(string $filename, string $sniffClass, File $report): void;

    /**
     * Called after completing all sniffs on a file
     *
     * @param string $filename   The name of the file that was linted
     * @param File   $report     The (final) linting report for this file
     */
    public function notifyFileComplete(string $filename, File $report): void;

    /**
     * Called after all files have been linted
     *
     * @param Report $report The final linting report for all files
     */
    public function notifyRunComplete(Report $report): void;
}