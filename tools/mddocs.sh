#!/bin/sh

cd /home/beanow/GitRepos/tuxion.cms/

echo "Parsing code... "
phpdoc parse -c ./phpdoc.dist.xml >> /dev/null
echo "Done!"

echo "Generating markdown files... "
tools/phpdoc-md/bin/phpdocmd structure.xml ./apidocs >> /dev/null
echo "Done!"
