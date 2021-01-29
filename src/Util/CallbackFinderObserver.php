<?php declare(strict_types=1);
namespace Helmich\TypoScriptLint\Util;

class CallbackFinderObserver implements FinderObserver
{
    public function __construct(private callable $fn)
    {
    }

    public function onEntryNotFound(string $fileOrDirectory): void
    {
        // Because, fuck you, PHP
        $fn = $this->fn;
        $fn($fileOrDirectory);
    }

}