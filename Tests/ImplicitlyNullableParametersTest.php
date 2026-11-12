<?php

/**
 * @copyright  Copyright (C) 2005 - 2026 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Tests;

use PHPUnit\Framework\TestCase;

/**
 * Checks that no parameter is implicitly nullable, which PHP 8.4 deprecates.
 */
class ImplicitlyNullableParametersTest extends TestCase
{
    public function testNoImplicitlyNullableParameters()
    {
        $found = [];
        $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator(\dirname(__DIR__) . '/src'));

        foreach ($files as $file) {
            if ($file->getExtension() !== 'php') {
                continue;
            }

            foreach ((new \ReflectionClass($this->getClassName($file->getPathname())))->getMethods() as $method) {
                if ($method->getFileName() !== $file->getRealPath()) {
                    continue;
                }

                foreach ($method->getParameters() as $parameter) {
                    $type = $parameter->getType();

                    if (
                        $type instanceof \ReflectionNamedType
                        && $type->getName() !== 'mixed'
                        && $parameter->isDefaultValueAvailable()
                        && $parameter->getDefaultValue() === null
                        && !$this->isDeclaredNullable($method, $parameter)
                    ) {
                        $found[] = $method->class . '::' . $method->getName() . '() $' . $parameter->getName();
                    }
                }
            }
        }

        $this->assertSame([], $found, 'Implicitly nullable parameters (use ?Type)');
    }

    private function getClassName(string $path): string
    {
        $relative = substr($path, \strlen(\dirname(__DIR__) . '/src/'), -4);

        return 'Joomla\\Github\\' . str_replace(['/', '\\'], '\\', $relative);
    }

    /**
     * The type of a parameter declared as `?Type $x = null` and as `Type $x = null` is the same in reflection, so look
     * at the declaration in the source.
     */
    private function isDeclaredNullable(\ReflectionMethod $method, \ReflectionParameter $parameter): bool
    {
        $lines     = \array_slice(file($method->getFileName()), $method->getStartLine() - 1, $method->getEndLine() - $method->getStartLine() + 1);
        $signature = strstr(implode('', $lines), '{', true);

        return (bool) preg_match('/(\?|null\s*\|)[\\\\\w]+\s+\$' . $parameter->getName() . '\b/', $signature);
    }
}
