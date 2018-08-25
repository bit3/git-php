<?php

/**
 * This file is part of bit3/git-php.
 *
 * (c) Tristan Lins <tristan@lins.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This project is provided in good faith and hope to be usable by anyone.
 *
 * @package    bit3/git-php
 * @author     Tristan Lins <tristan@lins.io>
 * @author     Christian Schiffler <c.schiffler@cyberspectrum.de>
 * @author     Sven Baumann <baumann.sv@gmail.com>
 * @copyright  2014-2018 Tristan Lins <tristan@lins.io>
 * @license    https://github.com/bit3/git-php/blob/master/LICENSE MIT
 * @link       https://github.com/bit3/git-php
 * @filesource
 */

namespace Bit3\GitPhp\Command;

/**
 * Fetch command builder.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class FetchCommandBuilder extends AbstractCommandBuilder
{
    const RECURSE_SUBMODULES_YES = 'yes';

    const RECURSE_SUBMODULES_ON_DEMAND = 'on-demand';

    const RECURSE_SUBMODULES_NO = 'no';

    /**
     * {@inheritDoc}
     */
    protected function initializeProcessBuilder()
    {
        $this->arguments[] = 'fetch';
    }

    /**
     * Add the all option to the command line.
     *
     * @return FetchCommandBuilder
     */
    public function all()
    {
        $this->arguments[] = '--all';
        return $this;
    }

    /**
     * Add the append option to the command line.
     *
     * @return FetchCommandBuilder
     */
    public function append()
    {
        $this->arguments[] = '--append';
        return $this;
    }

    /**
     * Add the depth option to the command line.
     *
     * @param int $depth The commit depth to use.
     *
     * @return FetchCommandBuilder
     */
    public function depth($depth)
    {
        $this->arguments[] = '--depth=' . $depth;
        return $this;
    }

    /**
     * Add the unshallow option to the command line.
     *
     * @return FetchCommandBuilder
     */
    public function unshallow()
    {
        $this->arguments[] = '--unshallow';
        return $this;
    }

    /**
     * Add the update-shallow option to the command line.
     *
     * @return FetchCommandBuilder
     */
    public function updateShallow()
    {
        $this->arguments[] = '--update-shallow';
        return $this;
    }

    /**
     * Add the dry-run option to the command line.
     *
     * @return FetchCommandBuilder
     */
    public function dryRun()
    {
        $this->arguments[] = '--dry-run';
        return $this;
    }

    /**
     * Add the force option to the command line.
     *
     * @return FetchCommandBuilder
     */
    public function force()
    {
        $this->arguments[] = '--force';
        return $this;
    }

    /**
     * Add the keep option to the command line.
     *
     * @return FetchCommandBuilder
     */
    public function keep()
    {
        $this->arguments[] = '--keep';
        return $this;
    }

    /**
     * Add the multiple option to the command line.
     *
     * @return FetchCommandBuilder
     */
    public function multiple()
    {
        $this->arguments[] = '--multiple';
        return $this;
    }

    /**
     * Add the prune option to the command line.
     *
     * @return FetchCommandBuilder
     */
    public function prune()
    {
        $this->arguments[] = '--prune';
        return $this;
    }

    /**
     * Add the no-tags option to the command line.
     *
     * @return FetchCommandBuilder
     */
    public function noTags()
    {
        $this->arguments[] = '--no-tags';
        return $this;
    }

    /**
     * Add the tags option to the command line.
     *
     * @return FetchCommandBuilder
     */
    public function tags()
    {
        $this->arguments[] = '--tags';
        return $this;
    }

    /**
     * Add the recurse-submodules option to the command line.
     *
     * @param bool|string $recurse The value.
     *
     * @return FetchCommandBuilder
     */
    public function recurseSubmodules($recurse = false)
    {
        $this->arguments[] = '--recurse-submodules' . ($recurse ? '=' . $recurse : '');
        return $this;
    }

    /**
     * Add the no-recurse-submodules option to the command line.
     *
     * @return FetchCommandBuilder
     */
    public function noRecurseSubmodules()
    {
        $this->arguments[] = '--no-recurse-submodules';
        return $this;
    }

    /**
     * Add the submodule-prefix option to the command line.
     *
     * @param string $path The path.
     *
     * @return FetchCommandBuilder
     */
    public function submodulePrefix($path)
    {
        $this->arguments[] = '--submodule-prefix=' . $path;
        return $this;
    }

    /**
     * Add the recurse-submodules-default option to the command line.
     *
     * @param string $recurse The value.
     *
     * @return FetchCommandBuilder
     */
    public function recurseSubmodulesDefault($recurse)
    {
        $this->arguments[] = '--recurse-submodules-default=' . $recurse;
        return $this;
    }

    /**
     * Add the update-head-ok option to the command line.
     *
     * @return FetchCommandBuilder
     */
    public function updateHeadOk()
    {
        $this->arguments[] = '--update-head-ok';
        return $this;
    }

    /**
     * Add the upload-pack option to the command line.
     *
     * @param string $uploadPack The pack.
     *
     * @return FetchCommandBuilder
     */
    public function uploadPack($uploadPack)
    {
        $this->arguments[] = '--upload-pack';
        $this->arguments[] = $uploadPack;
        return $this;
    }

    /**
     * Add the quiet option to the command line.
     *
     * @return FetchCommandBuilder
     */
    public function quiet()
    {
        $this->arguments[] = '--quiet';
        return $this;
    }

    /**
     * Add the verbose option to the command line.
     *
     * @return FetchCommandBuilder
     */
    public function verbose()
    {
        $this->arguments[] = '--verbose';
        return $this;
    }

    /**
     * Build the command and execute it.
     *
     * @param string      $repository Name of the remote to use (Defaults to origin).
     *
     * @param null|string $refspec    Refspec to fetch.
     *
     * @param null|string $_          More optional refspecs to commit.
     *
     * @return string
     *
     * @SuppressWarnings(PHPMD.ShortVariableName)
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * @SuppressWarnings(PHPMD.CamelCaseParameterName)
     */
    public function execute($repository = 'origin', $refspec = null, $_ = null)
    {
        $this->arguments[] = $repository;

        $refspecs = func_get_args();
        array_shift($refspecs);
        foreach ($refspecs as $refspec) {
            $this->arguments[] = $refspec;
        }

        return parent::run();
    }
}
