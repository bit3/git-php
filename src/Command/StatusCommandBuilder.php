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
 * Status command builder.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class StatusCommandBuilder extends AbstractCommandBuilder
{
    const UNTRACKED_FILES_NO = 'no';

    const UNTRACKED_FILES_NORMAL = 'normal';

    const UNTRACKED_FILES_ALL = 'all';

    const IGNORE_SUBMODULES_NONE = 'none';

    const IGNORE_SUBMODULES_UNTRACKED = 'untracked';

    const IGNORE_SUBMODULES_DIRTY = 'dirty';

    const IGNORE_SUBMODULES_ALL = 'all';

    /**
     * {@inheritDoc}
     */
    protected function initializeProcessBuilder()
    {
        $this->arguments[] = 'status';
    }

    /**
     * Add the short option to the command line.
     *
     * @return StatusCommandBuilder
     */
    public function short()
    {
        $this->arguments[] = '--short';
        return $this;
    }

    /**
     * Add the branch option to the command line.
     *
     * @return StatusCommandBuilder
     */
    public function branch()
    {
        $this->arguments[] = '--branch';
        return $this;
    }

    /**
     * Add the porcelain option to the command line.
     *
     * @return StatusCommandBuilder
     */
    public function porcelain()
    {
        $this->arguments[] = '--porcelain';
        return $this;
    }

    /**
     * Add the long option to the command line.
     *
     * @return StatusCommandBuilder
     */
    public function long()
    {
        $this->arguments[] = '--long';
        return $this;
    }

    /**
     * Add the untracked-files option to the command line.
     *
     * @param null|string $mode The mode.
     *
     * @return StatusCommandBuilder
     */
    public function untrackedFiles($mode = null)
    {
        $this->arguments[] = '--untracked-files' . ($mode ? '=' . $mode : '');
        return $this;
    }

    /**
     * Add the ignore-submodules option to the command line.
     *
     * @param null|string $when The value.
     *
     * @return StatusCommandBuilder
     */
    public function ignoreSubmodules($when = null)
    {
        $this->arguments[] = '--ignore-submodules' . ($when ? '=' . $when : '');
        return $this;
    }

    /**
     * Add the ignored option to the command line.
     *
     * @return StatusCommandBuilder
     */
    public function ignored()
    {
        $this->arguments[] = '--ignored';
        return $this;
    }

    /**
     * Add the z option to the command line.
     *
     * @return StatusCommandBuilder
     *
     * @SuppressWarnings(PHPMD.ShortMethodName)
     */
    public function z()
    {
        $this->arguments[] = '-z';
        return $this;
    }

    /**
     * Add the column option to the command line.
     *
     * @param null|string $options The column options.
     *
     * @return StatusCommandBuilder
     */
    public function column($options = null)
    {
        $this->arguments[] = '--column' . ($options ? '=' . $options : '');
        return $this;
    }

    /**
     * Add the  option to the command line.
     *
     * @return StatusCommandBuilder
     */
    public function noColumn()
    {
        $this->arguments[] = '--no-column';
        return $this;
    }

    /**
     * Return the parsed index and work tree status.
     *
     * The result will be an associative array of all files and an status array in the following format:
     * <code>
     * array(
     *     '&lt;pathspec&gt;' => array(
     *         'index'    => [false | "M" | "A" | "D" | "R" | "C" | "U" | "?" | "!"],
     *         'worktree' => [false | "M" | "A" | "D" | "R" | "C" | "U" | "?" | "!"],
     *     )
     * )
     * </code>
     *
     * @param string $pathspec A path spec.
     *
     * @param string $_        Optional list of additional path specs.
     *
     * @return array
     *
     * @SuppressWarnings(PHPMD.ShortVariableName)
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * @SuppressWarnings(PHPMD.CamelCaseParameterName)
     */
    public function getStatus($pathspec = null, $_ = null)
    {
        $this->porcelain();

        $status = \call_user_func_array([$this, 'execute'], \func_get_args());
        $status = \explode("\n", $status);

        $files = [];

        foreach ($status as $line) {
            if (\trim($line)) {
                $index    = \trim(\substr($line, 0, 1));
                $worktree = \trim(\substr($line, 1, 1));

                if ($index && $worktree) {
                    $file         = \trim(\substr($line, 2));
                    $files[$file] = [
                        'index'    => $index ?: false,
                        'worktree' => $worktree ?: false,
                    ];
                }
            }
        }

        return $files;
    }

    /**
     * Return the parsed index status.
     *
     * The result will be an associative array of all files and their modification status in the following format:
     * <code>
     * array(
     *     '&lt;pathspec&gt;' => [false | "M" | "A" | "D" | "R" | "C" | "U" | "?" | "!"],
     * )
     * </code>
     *
     * @param string $pathspec A path spec.
     *
     * @param string $_        Optional list of additional path specs.
     *
     * @return array
     *
     * @SuppressWarnings(PHPMD.ShortVariableName)
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * @SuppressWarnings(PHPMD.CamelCaseParameterName)
     */
    public function getIndexStatus($pathspec = null, $_ = null)
    {
        $this->porcelain();

        $status = \call_user_func_array([$this, 'execute'], \func_get_args());
        $status = \explode("\n", $status);

        $files = [];

        foreach ($status as $line) {
            if ($line = \trim($line)) {
                $index = \substr($line, 0, 1);

                if ($index) {
                    $file         = \trim(\substr($line, 2));
                    $files[$file] = $index;
                }
            }
        }

        return $files;
    }

    /**
     * Return the parsed work tree status.
     *
     * The result will be an associative array of all files and their modification status in the following format:
     * <code>
     * array(
     *     '&lt;pathspec&gt;' => [false | "M" | "A" | "D" | "R" | "C" | "U" | "?" | "!"],
     * )
     * </code>
     *
     * @param string $pathspec A path spec.
     *
     * @param string $_        Optional list of additional path specs.
     *
     * @return array
     *
     * @SuppressWarnings(PHPMD.ShortVariableName)
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * @SuppressWarnings(PHPMD.CamelCaseParameterName)
     */
    public function getWorkTreeStatus($pathspec = null, $_ = null)
    {
        $this->porcelain();

        $status = \call_user_func_array([$this, 'execute'], \func_get_args());
        $status = \explode("\n", $status);

        $files = [];

        foreach ($status as $line) {
            if ($line = \trim($line)) {
                $worktree = \trim(\substr($line, 1, 1));

                if ($worktree) {
                    $file         = \trim(\substr($line, 2));
                    $files[$file] = $worktree;
                }
            }
        }

        return $files;
    }

    /**
     * Build the command and execute it.
     *
     * @param null|string $pathspec A path spec.
     *
     * @param null|string $_        Optional list of additional path specs.
     *
     * @return string
     *
     * @SuppressWarnings(PHPMD.ShortVariableName)
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * @SuppressWarnings(PHPMD.CamelCaseParameterName)
     */
    public function execute($pathspec = null, $_ = null)
    {
        $args = \func_get_args();
        if (\count($args)) {
            $this->arguments[] = '--';
            foreach ($args as $pathspec) {
                $this->arguments[] = $pathspec;
            }
        }
        return parent::run();
    }
}
