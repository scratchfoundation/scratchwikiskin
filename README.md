scratchwikiskin
=================

If you'd like to help fix bugs in the skin for the Everything Wiki, please fork, make and test changes, and then submit a pull request. Our design goals are to keep the wiki skin as simple and as easy to use as possible. So we're unlikely to accept pull requests for fancy features, or code that's difficult to maintain.

To install / setup
1. Mediawiki skins change a lot between versions, so you need to use the same version of mediawiki that the Scratch wiki is currently running. You can find that version here: http://everythingwiki.x10.bz/index.php/Special:Version

2. Clone this repository as a subdirectory of your skins folder.

3. Create a symlink in the skins directory that points to the skin's php file, inside the scratchwikiskin directory. i.e
  
  you@yourcomputer:/var/www/w/skins$ ln -s scratchwikiskin/ScratchWikiSkin.php ScratchWikiSkin.php

Credits: Original design by the Scratch Wiki, ported by the Everything Wiki
