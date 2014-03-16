GIT repository
==============

This repository allows you to work with git repositories.

Usage examples
--------------

### clone a git repository

```php
use ContaoCommunityAlliance\BuildSystem\Repository\GitRepository;

$targetDirectory = '/path/to/git/target/directory';

$git = new GitRepository();
$git->cloneRepository($targetDirectory);
```

(c) This file is part of the *Contao Community Alliance Build System* - ccabs [[si:caps]]
