<?php

/**
 * Part of the Joomla Framework Github Package
 *
 * @copyright  Copyright (C) 2005 - 2022 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Package\Data;

use Joomla\Github\AbstractPackage;

/**
 * GitHub API Data Trees class for the Joomla Framework.
 *
 * @link   https://developer.github.com/v3/git/trees/
 *
 * @since  1.0
 */
class Trees extends AbstractPackage
{
    /**
     * Get a Tree
     *
     * @param   string  $owner  The name of the owner of the GitHub repository.
     * @param   string  $repo   The name of the GitHub repository.
     * @param   string  $sha    The SHA1 value to set the reference to.
     *
     * @since   1.0
     *
     * @return object
     */
    public function get($owner, $repo, $sha)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/git/trees/' . $sha;

        return $this->processResponse(
            $this->client->get($this->fetchUrl($path))
        );
    }

    /**
     * Get a Tree Recursively
     *
     * @param   string  $owner  The name of the owner of the GitHub repository.
     * @param   string  $repo   The name of the GitHub repository.
     * @param   string  $sha    The SHA1 value to set the reference to.
     *
     * @since   1.0
     *
     * @return object
     */
    public function getRecursively($owner, $repo, $sha)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/git/trees/' . $sha . '?recursive=1';

        return $this->processResponse(
            $this->client->get($this->fetchUrl($path))
        );
    }

    /**
     * Create a Tree.
     *
     * The tree creation API will take nested entries as well. If both a tree and a nested path
     * modifying that tree are specified, it will overwrite the contents of that tree with the
     * new path contents and write a new tree out.
     *
     * Parameters for the tree:
     *
     * tree.path
     *     String of the file referenced in the tree
     * tree.mode
     *     String of the file mode - one of 100644 for file (blob), 100755 for executable (blob),
     *     040000 for subdirectory (tree), 160000 for submodule (commit) or 120000 for a blob
     *     that specifies the path of a symlink
     * tree.type
     *     String of blob, tree, commit
     * tree.sha
     *     String of SHA1 checksum ID of the object in the tree
     * tree.content
     *     String of content you want this file to have - GitHub will write this blob out and use
     *     that SHA for this entry. Use either this or tree.sha
     *
     * @param   string  $owner     The name of the owner of the GitHub repository.
     * @param   string  $repo      The name of the GitHub repository.
     * @param   array   $tree      Array of Hash objects (of path, mode, type and sha) specifying a tree structure
     * @param   string  $baseTree  The SHA1 of the tree you want to update with new data.
     *
     * @return  object
     *
     * @since   1.0
     */
    public function create($owner, $repo, $tree, $baseTree = '')
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/git/trees';

        $data = [];

        $data['tree'] = $tree;

        if ($baseTree) {
            $data['base_tree'] = $baseTree;
        }

        return $this->processResponse(
            $this->client->post($this->fetchUrl($path), json_encode($data)),
            201
        );
    }
}
