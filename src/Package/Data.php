<?php

/**
 * Part of the Joomla Framework Github Package
 *
 * @copyright  Copyright (C) 2005 - 2022 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Package;

use Joomla\Github\AbstractPackage;

/**
 * GitHub API DB class for the Joomla Framework.
 *
 * @link   https://developer.github.com/v3/git/
 *
 * @since  1.0
 * http://developer.github.com/v3/git/
 *
 * Git DB API.
 *
 * The Git Database API gives you access to read and write raw Git objects to your Git database on GitHub and to list
 * and update your references (branch heads and tags).
 *
 * This basically allows you to reimplement a lot of Git functionality over our API - by creating raw objects directly
 * into the database and updating branch references you could technically do just about anything that Git can do
 * without having Git installed.
 *
 * Git DB API functions will return a 409 if the git repo for a Repository is empty or unavailable. This typically
 * means it is being created still. Contact Support if this response status persists.
 *
 * git db
 *
 * For more information on the Git object database, please read the Git Internals chapter of the Pro Git book.
 *
 * As an example, if you wanted to commit a change to a file in your repository, you would:
 *
 * get the current commit object
 * retrieve the tree it points to
 *  retrieve the content of the blob object that tree has for that particular file path
 *  change the content somehow and post a new blob object with that new content, getting a blob SHA back
 *  post a new tree object with that file path pointer replaced with your new blob SHA getting a tree SHA back
 *  create a new commit object with the current commit SHA as the parent and the new tree SHA, getting a commit SHA back
 *  update the reference of your branch to point to the new commit SHA
 *
 * It might seem complex, but it’s actually pretty simple when you understand the model and it opens up a ton of things
 * you could potentially do with the API.
 *
 * @property-read  Data\Blobs    $blobs    GitHub API object for blobs.
 * @property-read  Data\Commits  $commits  GitHub API object for commits.
 * @property-read  Data\Refs     $refs     GitHub API object for refs.
 * @property-read  Data\Tags     $tags     GitHub API object for tags.
 * @property-read  Data\Trees    $trees    GitHub API object for trees.
 */
class Data extends AbstractPackage
{
}
