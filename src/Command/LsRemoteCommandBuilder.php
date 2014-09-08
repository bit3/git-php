<?php

/**
 * This file is part of the Contao Community Alliance Build System tools.
 *
 * @copyright 2014 Contao Community Alliance <https://c-c-a.org>
 * @author    Tristan Lins <t.lins@c-c-a.org>
 * @package   contao-community-alliance/build-system-repository-git
 * @license   MIT
 * @link      https://c-c-a.org
 */

namespace ContaoCommunityAlliance\BuildSystem\Repository\Command;

use Guzzle\Http\Client;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\ProcessBuilder;

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

	public function execute($repository, $refs = null, $_ = null)
	{
        $this->processBuilder->add($repository);

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
    public function getRefs($repository, $refs = null, $_ = null)
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
