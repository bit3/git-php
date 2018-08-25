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
 * @author     Matthew Gamble <git@matthewgamble.net>
 * @author     Christian Schiffler <c.schiffler@cyberspectrum.de>
 * @author     Sven Baumann <baumann.sv@gmail.com>
 * @copyright  2014-2018 Tristan Lins <tristan@lins.io>
 * @license    https://github.com/bit3/git-php/blob/master/LICENSE MIT
 * @link       https://github.com/bit3/git-php
 * @filesource
 */

namespace Bit3\GitPhp\Command;

/**
 * Config command builder.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class ConfigCommandBuilder extends AbstractCommandBuilder
{
    /**
     * {@inheritDoc}
     */
    protected function initializeProcessBuilder()
    {
        $this->arguments[] = 'config';
    }

    /**
     * Specify a single config file that should be looked at.
     * Has special support for the global, system and local flags.
     *
     * @param string $file The config file to use.
     *
     * @return ConfigCommandBuilder
     */
    public function file($file)
    {
        if (\in_array($file, ['global', 'system', 'local'])) {
            $this->arguments[] = '--' . $file;
        } else {
            $this->arguments[] = '--file';
            $this->arguments[] = $file;
        }
        return $this;
    }

    /**
     * Add the blob option to the command line.
     *
     * See "SPECIFYING REVISIONS" section in gitrevisions(7) for a list of ways to spell blob names.
     *
     * @param string $blobId The blob id to use.
     *
     * @return ConfigCommandBuilder
     */
    public function blob($blobId)
    {
        $this->arguments[] = '--blob ' . $blobId;
        return $this;
    }

    /**
     * Add a type option to the command line.
     *
     * @param string $type The type name.
     *
     * @return ConfigCommandBuilder
     *
     * @throws \InvalidArgumentException When an invalid type name is encountered.
     */
    public function type($type)
    {
        if (\in_array($type, ['bool', 'int', 'bool-or-int', 'path'])) {
            $this->arguments[] = '--' . $type;
        } else {
            throw new \InvalidArgumentException('Invalid configuration type supplied.');
        }
        return $this;
    }

    /**
     * Add the add option and associated parameters to the command line.
     *
     * @param string $name  The config value name.
     *
     * @param string $value The value to use.
     *
     * @return ConfigCommandBuilder
     */
    public function add($name, $value)
    {
        $this->arguments[] = '--add';
        $this->arguments[] = $name;
        $this->arguments[] = $value;
        return $this;
    }

    /**
     * Add the replace-all option and associated parameters to the command line.
     *
     * @param string      $name       The config value name.
     *
     * @param string      $value      The value to use.
     *
     * @param null|string $valueRegex The value regex to use.
     *
     * @return ConfigCommandBuilder
     */
    public function replaceAll($name, $value, $valueRegex = null)
    {
        $this->arguments[] = '--replace-all';
        $this->arguments[] = $name;
        $this->arguments[] = $value;
        if ($valueRegex !== null) {
            $this->arguments[] = $valueRegex;
        }
        return $this;
    }

    /**
     * Adds the NUL byte termination option to the command line.
     *
     * @return ConfigCommandBuilder
     */
    public function terminateWithNUL()
    {
        $this->arguments[] = '--null';
        return $this;
    }

    /**
     * Add the get option and associated parameters to the command line.
     *
     * @param string      $name       The config value name.
     *
     * @param null|string $valueRegex The value regex to use.
     *
     * @return ConfigCommandBuilder
     */
    public function get($name, $valueRegex = null)
    {
        $this->arguments[] = '--get';
        $this->addNameAndPattern($name, $valueRegex);
        return $this;
    }

    /**
     * Add the get-all option and associated parameters to the command line.
     *
     * @param string      $name       The config value name.
     *
     * @param null|string $valueRegex The value regex to use.
     *
     * @return ConfigCommandBuilder
     */
    public function getAll($name, $valueRegex = null)
    {
        $this->arguments[] = '--get-all';
        $this->addNameAndPattern($name, $valueRegex);
        return $this;
    }

    /**
     * Add the get-regexp option and associated parameters to the command line.
     *
     * @param string      $nameRegex  The config name regex.
     *
     * @param null|string $valueRegex The value regex to use.
     *
     * @return ConfigCommandBuilder
     */
    public function getRegexp($nameRegex, $valueRegex = null)
    {
        $this->arguments[] = '--get-regexp';
        $this->addNameAndPattern($nameRegex, $valueRegex);
        return $this;
    }

    /**
     * Add the get-urlmatch option and associated parameters to the command line.
     *
     * @param string $name The config name.
     *
     * @param string $url  The url to match.
     *
     * @return ConfigCommandBuilder
     */
    public function getUrlmatch($name, $url)
    {
        $this->arguments[] = '--get-urlmatch';
        $this->addNameAndPattern($name, $url);
        return $this;
    }

    /**
     * Add the unset option and associated parameters to the command line.
     *
     * @param string      $name       The name of the config value to unset.
     *
     * @param null|string $valueRegex The value regex to use.
     *
     * @return ConfigCommandBuilder
     */
    public function unsetOpt($name, $valueRegex = null)
    {
        $this->arguments[] = '--unset';
        $this->addNameAndPattern($name, $valueRegex);
        return $this;
    }

    /**
     * Add the unset-all option and associated parameters to the command line.
     *
     * @param string      $name       The name of the config value to unset.
     *
     * @param null|string $valueRegex The value regex to use.
     *
     * @return ConfigCommandBuilder
     */
    public function unsetAll($name, $valueRegex = null)
    {
        $this->arguments[] = '--unset-all';
        $this->addNameAndPattern($name, $valueRegex);
        return $this;
    }

    /**
     * Add the passed name and the passed pattern if not null.
     *
     * @param string      $name    The name to add.
     *
     * @param null|string $pattern The pattern to add (if not null).
     *
     * @return void
     */
    private function addNameAndPattern($name, $pattern)
    {
        $this->arguments[] = $name;
        if ($pattern !== null) {
            $this->arguments[] = $pattern;
        }
    }

    /**
     * Add the rename-section option and associated parameters to the command line.
     *
     * @param string $oldName The old section name.
     *
     * @param string $newName The new section name.
     *
     * @return ConfigCommandBuilder
     */
    public function renameSection($oldName, $newName)
    {
        $this->arguments[] = '--rename-section';
        $this->arguments[] = $oldName;
        $this->arguments[] = $newName;
        return $this;
    }

    /**
     * Add the remove-section option to the command line.
     *
     * @param string $name The section name.
     *
     * @return ConfigCommandBuilder
     */
    public function removeSection($name)
    {
        $this->arguments[] = '--remove-section';
        $this->arguments[] = $name;
        return $this;
    }

    /**
     * Add the list option to the command line.
     *
     * @return ConfigCommandBuilder
     */
    public function listOpt()
    {
        $this->arguments[] = '--list';
        return $this;
    }

    /**
     * Add the get-color option and associated parameters to the command line.
     *
     * @param string      $name    The name of the color to retrieve.
     *
     * @param null|string $default The default value to return.
     *
     * @return ConfigCommandBuilder
     */
    public function getColor($name, $default = null)
    {
        $this->arguments[] = '--get-color';
        $this->arguments[] = $name;
        if ($default !== null) {
            $this->arguments[] = $default;
        }
        return $this;
    }

    /**
     * Add the get-colorbool option and associated parameters to the command line.
     *
     * @param string    $name        The name of the color to check.
     *
     * @param bool|null $stdoutIsTty Flag if stdout is a tty.
     *
     * @return ConfigCommandBuilder
     */
    public function getColorBool($name, $stdoutIsTty = null)
    {
        $this->arguments[] = '--get-colorbool';
        $this->arguments[] = $name;
        if (\is_bool($stdoutIsTty)) {
            $this->arguments[] = $stdoutIsTty ? 'true' : 'false';
        }
        return $this;
    }

    /**
     * Add the includes or no-includes option to the command line.
     *
     * @param bool $allow Flag if include.* directives in config files shall be respected when looking up values.
     *
     * @return ConfigCommandBuilder
     */
    public function includes($allow = true)
    {
        $this->arguments[] = $allow ? '--includes' : '--no-includes';
        return $this;
    }

    /**
     * Build the command and execute it.
     *
     * @param null|string $name       Pass name of setting here to perform a basic get or set operation.
     *
     * @param null|string $value      Pass a value for the setting to turn this into a set command.
     *
     * @param null|string $valueRegex Pass a regex to limit changing of a multi-value setting to certain settings.
     *
     * @return mixed
     *
     * @SuppressWarnings(PHPMD.ShortVariableName)
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * @SuppressWarnings(PHPMD.CamelCaseParameterName)
     */
    public function execute($name = null, $value = null, $valueRegex = null)
    {
        if ($name !== null) {
            $this->arguments[] = $name;
            if ($value !== null) {
                $this->arguments[] = $value;
                if ($valueRegex !== null) {
                    $this->arguments[] = $valueRegex;
                }
            }
        }
        return parent::run();
    }
}
