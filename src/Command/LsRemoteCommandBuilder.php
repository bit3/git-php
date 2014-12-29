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
    protected function initializeProcessBuilder()
    {
        $this->processBuilder->add('ls-remote');
    }

    public function heads()
    {
        $this->processBuilder->add('--heads');
        return $this;
    }

    public function tags()
    {
        $this->processBuilder->add('--tags');
        return $this;
    }

    public function uploadPack($exec)
    {
        $this->processBuilder->add('--upload-pack')->add($exec);
        return $this;
    }

    public function exitCode()
    {
        $this->processBuilder->add('--exit-code');
        return $this;
    }

    public function execute($remote, $refs = null, $_ = null)
    {
        $this->processBuilder->add($remote);

        $refs = func_get_args();
        array_shift($refs);
        foreach ($refs as $ref) {
            $this->processBuilder->add($ref);
        }

        return $this->run();
    }

    /**
     * Return a list of remote names.
     *
     * @return array
     */
    public function getRefs($remote, $refs = null, $_ = null)
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
