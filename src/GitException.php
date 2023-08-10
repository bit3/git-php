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

namespace Bit3\GitPhp;

use Symfony\Component\Process\Process;

/**
 * Exception thrown when execution of git failed.
 *
 * @final
 */
class GitException extends \RuntimeException
{
    /**
     * The working directory path.
     *
     * @var string
     */
    protected $workingDirectory;

    /**
     * The executed command line.
     *
     * @var string
     */
    protected $commandLine;

    /**
     * The git commands standard output.
     *
     * @var string
     */
    protected $commandOutput;

    /**
     * The git commands error output.
     *
     * @var string
     */
    protected $errorOutput;

    /**
     * Create a new git exception.
     *
     * @param string $message          The error message.
     * @param string $workingDirectory The working directory.
     * @param string $commandLine      The used command line.
     * @param string $commandOutput    The command output.
     * @param string $errorOutput      The command error output.
     */
    public function __construct(
        string $message,
        string $workingDirectory,
        string $commandLine,
        string $commandOutput,
        string $errorOutput
    ) {
        parent::__construct($message, 0, null);
        $this->workingDirectory = $workingDirectory;
        $this->commandLine      = $commandLine;
        $this->commandOutput    = $commandOutput;
        $this->errorOutput      = $errorOutput;
    }

    /**
     * Return the working directory git was executed in.
     *
     * @return string
     */
    public function getWorkingDirectory(): string
    {
        return $this->workingDirectory;
    }

    /**
     * Return the command line to execute git.
     *
     * @return string
     */
    public function getCommandLine(): string
    {
        return $this->commandLine;
    }

    /**
     * Return the git commands standard output.
     *
     * @return string
     */
    public function getCommandOutput(): string
    {
        return $this->commandOutput;
    }

    /**
     * Return the git commands error output.
     *
     * @return string
     */
    public function getErrorOutput(): string
    {
        return $this->errorOutput;
    }

    /**
     * Create new exception from process.
     *
     * @param string  $message The message to use.
     *
     * @param Process $process The process to create the message from.
     *
     * @return static
     *
     * @final
     */
    public static function createFromProcess(string $message, Process $process)
    {
        $workdir = $process->getWorkingDirectory() ?? '?';
        return new static(
            \sprintf('%s [%s]', $message, $process->getCommandLine()) .
            PHP_EOL . \sprintf('work dir: %s', $workdir) .
            PHP_EOL . $process->getErrorOutput(),
            $workdir,
            $process->getCommandLine(),
            $process->getOutput(),
            $process->getErrorOutput()
        );
    }
}
