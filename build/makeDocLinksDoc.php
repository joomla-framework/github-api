<?php
/**
 * Part of the Joomla Framework Github Package
 *
 * @copyright  Copyright (C) 2015 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

$packageBase = '../src/Package';
$packages = [];
$md = [];

$basePackages = getFiles($packageBase);

foreach ($basePackages as $packageName => $docLink)
{
	$md[] = '';
	$md[] = '### ' . $packageName;
	$md[] = $docLink;

	if (is_dir($packageBase . '/' . $packageName))
	{
		$subPackages = getFiles($packageBase . '/' . $packageName);

		foreach ($subPackages as $subPackageName => $subPackageLink)
		{
			$md[] = '* ' . $subPackageName . ' ' . $subPackageLink;
		}
	}
}

echo implode("\n", $md);

function getFiles($path)
{
	$items = [];

	/* @type SplFileInfo $fileInfo */
	foreach(new DirectoryIterator($path) as $fileInfo)
	{
		$fileName = $fileInfo->getFilename();

		if('.' == $fileName || '..' == $fileName || $fileInfo->isDir())
		{
			continue;
		}

		$items[str_replace('.php', '', $fileName)] = getDocLink($path . '/' . $fileName);
	}

	ksort($items);

	return $items;
}

function getDocLink($fileName)
{
	$lines = file($fileName);

	foreach ($lines as $line)
	{
		if (preg_match('/@documentation (.+)/', $line, $matches))
		{
			return $matches[1];
		}
	}

	throw new Exception('No @documentation link in file ' . $fileName);
}
