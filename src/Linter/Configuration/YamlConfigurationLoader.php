<?php declare(strict_types=1);
namespace Helmich\TypoScriptLint\Linter\Configuration;

use Helmich\TypoScriptLint\Util\Filesystem;
use Symfony\Component\Config\Exception\FileLocatorFileNotFoundException;
use Symfony\Component\Config\FileLocatorInterface;
use Symfony\Component\Config\Loader\FileLoader;
use Symfony\Component\Yaml\Parser as YamlParser;

/**
 * Configuration loader for YAML files.
 *
 * @author     Martin Helmich <typo3@martin-helmich.de>
 * @license    MIT
 * @package    Helmich\TypoScriptLint
 * @subpackage Linter\Configuration
 *
 * @psalm-suppress MethodSignatureMismatch
 */
class YamlConfigurationLoader extends FileLoader
{

    /**
     * Constructs a new YAML-based configuration loader.
     *
     * @param FileLocatorInterface $locator    The file locator.
     */
    public function __construct(FileLocatorInterface $locator, private YamlParser $yamlParser, private Filesystem $filesystem)
    {
        parent::__construct($locator);
    }

    /**
     * Loads a resource.
     *
     * @param mixed  $resource The resource
     * @param string $type     The resource type
     *
     * @psalm-suppress MethodSignatureMismatch
     */
    public function load($resource, $type = null): array
    {
        try {
            /** @var string $path */
            $path = $this->locator->locate($resource);
            $file = $this->filesystem->openFile($path);

            return $this->yamlParser->parse($file->getContents());
        } catch (FileLocatorFileNotFoundException) {
            return [];
        }
    }

    /**
     * Returns true if this class supports the given resource.
     *
     * @param mixed  $resource A resource
     * @param string $type     The resource type
     * @return bool    true if this class supports the given resource, false otherwise
     *
     * @psalm-suppress MethodSignatureMismatch
     */
    public function supports($resource, $type = null): bool
    {
        return is_string($resource) &&
            in_array(pathinfo($resource, PATHINFO_EXTENSION), ['yml', 'yaml']);
    }
}
