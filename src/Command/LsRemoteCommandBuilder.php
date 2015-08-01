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
 * @copyright  2014 Tristan Lins <tristan@lins.io>
 * @link       https://github.com/bit3/git-php
 * @license    https://github.com/bit3/git-php/blob/master/LICENSE MIT
 * @filesource
 */

namespace Bit3\GitPhp\Command;

/**
 * Ls remote command builder.
 */
class LsRemoteCommandBuilder extends AbstractCommandBuilder
{
    /**
     * {@inheritDoc}
     */
    protected function initializeProcessBuilder()
    {
        $this->processBuilder->add('ls-remote');
    }

    /**
     * Add the heads option to the command line.
     *
     * @return LsRemoteCommandBuilder
     */
    public function heads()
    {
        $this->processBuilder->add('--heads');
        return $this;
    }

    /**
     * Add the tags option to the command line.
     *
     * @return LsRemoteCommandBuilder
     */
    public function tags()
    {
        $this->processBuilder->add('--tags');
        return $this;
    }

    /**
     * Add the upload-pack option to the command line.
     *
     * @param string $exec The value.
     *
     * @return LsRemoteCommandBuilder
     */
    public function uploadPack($exec)
    {
        $this->processBuilder->add('--upload-pack')->add($exec);
        return $this;
    }

    /**
     * Add the exit-code option to the command line.
     *
     * @return LsRemoteCommandBuilder
     */
    public function exitCode()
    {
        $this->processBuilder->add('--exit-code');
        return $this;
    }

    /**
     * Build the command and execute it.
     *
     * @param string      $remote  Name of the remote.
     *
     * @param null|string $refSpec Ref spec to list.
     *
     * @param null|string $_       More optional ref specs to log.
     *
     * @return string
     *
     * @SuppressWarnings(PHPMD.ShortVariableName)
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * @SuppressWarnings(PHPMD.CamelCaseParameterName)
     */
    public function execute($remote, $refSpec = null, $_ = null)
    {
        $this->processBuilder->add($remote);

        $refSpec = func_get_args();
        array_shift($refSpec);
        foreach ($refSpec as $ref) {
            $this->processBuilder->add($ref);
        }

        return $this->run();
    }

    /**
     * Return a list of remote names.
     *
     * @param string      $remote  Name of the remote.
     *
     * @param null|string $refSpec Ref spec to list.
     *
     * @param null|string $_       More optional ref specs to log.
     *
     * @return array
     *
     * @SuppressWarnings(PHPMD.ShortVariableName)
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * @SuppressWarnings(PHPMD.CamelCaseParameterName)
     */
    public function getRefs($remote, $refSpec = null, $_ = null)
    {
        $output = call_user_func_array(array($this, 'execute'), func_get_args());
        $output = explode("\n", $output);
        $output = array_map('trim', $output);
        $output = array_filter($output);

        $refs = array();

        foreach ($output as $line) {
            $line = preg_split('~\s+~', $line);

            if ('^{}' != substr($line[1], -3)) {
                $refs[$line[1]] = $line[0];
            }
        }

        return $refs;
    }
}
