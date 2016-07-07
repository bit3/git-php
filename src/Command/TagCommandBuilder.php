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
 * @license    https://github.com/bit3/git-php/blob/master/LICENSE MIT
 * @link       https://github.com/bit3/git-php
 * @filesource
 */

namespace Bit3\GitPhp\Command;

/**
 * Tag command builder.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class TagCommandBuilder extends AbstractCommandBuilder
{
    const CLEANUP_VERBATIM = 'verbatim';

    const CLEANUP_WHITESPACE = 'whitespace';

    const CLEANUP_STRIP = 'strip';

    /**
     * Flag if signing shall be done.
     *
     * @var bool
     */
    protected $signIsset = false;

    /**
     * Flag determining if the local user has been set.
     *
     * @var bool
     */
    protected $localUserIsset = false;

    /**
     * {@inheritDoc}
     */
    protected function initializeProcessBuilder()
    {
        $this->processBuilder->add('tag');
    }

    /**
     * Add the annotate option to the command line.
     *
     * @return TagCommandBuilder
     */
    public function annotate()
    {
        $this->processBuilder->add('--annotate');
        return $this;
    }

    /**
     * Add the sign option to the command line.
     *
     * @return TagCommandBuilder
     */
    public function sign()
    {
        $this->signIsset = true;
        $this->processBuilder->add('--sign');
        return $this;
    }

    /**
     * Add the local-user option to the command line.
     *
     * @param string $keyId The id of the local user key.
     *
     * @return TagCommandBuilder
     */
    public function localUser($keyId)
    {
        $this->localUserIsset = true;
        $this->processBuilder->add('--local-user=' . $keyId);
        return $this;
    }

    /**
     * Add the force option to the command line.
     *
     * @return TagCommandBuilder
     */
    public function force()
    {
        $this->processBuilder->add('--force');
        return $this;
    }

    /**
     * Add the delete option to the command line.
     *
     * @return TagCommandBuilder
     */
    public function delete()
    {
        $this->processBuilder->add('--delete');
        return $this;
    }

    /**
     * Add the verify option to the command line.
     *
     * @return TagCommandBuilder
     */
    public function verify()
    {
        $this->processBuilder->add('--verify');
        return $this;
    }

    /**
     * Add the n option to the command line.
     *
     * @param int $num The number.
     *
     * @return TagCommandBuilder
     *
     * @SuppressWarnings(PHPMD.ShortMethodName)
     */
    public function n($num)
    {
        $this->processBuilder->add('-n' . $num);
        return $this;
    }

    /**
     * Add the l option to the command line.
     *
     * @param string $pattern The pattern.
     *
     * @return TagCommandBuilder
     *
     * @SuppressWarnings(PHPMD.ShortMethodName)
     */
    public function l($pattern)
    {
        $this->processBuilder->add('--list')->add($pattern);
        return $this;
    }

    /**
     * Add the column option to the command line.
     *
     * @param null|string $options The column options.
     *
     * @return TagCommandBuilder
     */
    public function column($options = null)
    {
        $this->processBuilder->add('--column' . ($options ? '=' . $options : ''));
        return $this;
    }

    /**
     * Add the no-column option to the command line.
     *
     * @return TagCommandBuilder
     */
    public function noColumn()
    {
        $this->processBuilder->add('--no-column');
        return $this;
    }

    /**
     * Add the contains option to the command line.
     *
     * @param string $commit The commit hash.
     *
     * @return TagCommandBuilder
     */
    public function contains($commit)
    {
        $this->processBuilder->add('--contains')->add($commit);
        return $this;
    }

    /**
     * Add the points-at option to the command line.
     *
     * @param string $object The object the tag points at.
     *
     * @return TagCommandBuilder
     */
    public function pointsAt($object)
    {
        $this->processBuilder->add('--points-at')->add($object);
        return $this;
    }

    /**
     * Add the message option to the command line.
     *
     * @param string $message The message.
     *
     * @return TagCommandBuilder
     */
    public function message($message)
    {
        $this->processBuilder->add('--message=' . $message);
        return $this;
    }

    /**
     * Add the file option to the command line.
     *
     * @param string $file The file.
     *
     * @return TagCommandBuilder
     */
    public function file($file)
    {
        $this->processBuilder->add('--file=' . $file);
        return $this;
    }

    /**
     * Add the cleanup option to the command line.
     *
     * @param string $mode The cleanup mode.
     *
     * @return TagCommandBuilder
     */
    public function cleanup($mode)
    {
        $this->processBuilder->add('--cleanup=' . $mode);
        return $this;
    }

    /**
     * Build the command and execute it.
     *
     * @param string      $tagName Name of the tag.
     *
     * @param null|string $commit  Commit hash to tag.
     *
     * @return string
     *
     * @SuppressWarnings(PHPMD.ShortVariableName)
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * @SuppressWarnings(PHPMD.CamelCaseParameterName)
     */
    public function execute($tagName, $commit = null)
    {
        if (!$this->signIsset && $this->repository->getConfig()->isSignTagsEnabled()) {
            $this->sign()->localUser($this->repository->getConfig()->getSignCommitUser());
        } else {
            if ($this->signIsset && !$this->localUserIsset && $this->repository->getConfig()->isSignTagsEnabled()) {
                $this->localUser($this->repository->getConfig()->getSignCommitUser());
            }
        }

        $this->processBuilder->add($tagName);

        if ($commit) {
            $this->processBuilder->add($commit);
        }

        return parent::run();
    }
}
