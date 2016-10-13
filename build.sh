#!/bin/sh


# testing code
find -L . -name '*.php' -print0 | xargs -0 -n 1 -P 4 php -l

rm category-color-extended.zip

zip -r category-color-extended.zip * -x *.yml *.zip
