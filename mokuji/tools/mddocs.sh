#!/bin/sh

# Get the location of the script.
apath=$(cd "${0%/*}" 2>/dev/null; echo "$PWD"/"${0##*/}")
dname=$(dirname $apath)

# Escape one level since it's in the tools subfolder.
cd $dname/../

echo "Parsing code... "
# Parse the code.
php tools/phpDocumentor.phar parse >> /dev/null
echo "Done!"

echo "Generating markdown files... "
# Generate markdown files.
tools/phpdoc-md/bin/phpdocmd structure.xml ./apidocs >> /dev/null
echo "Done!"
