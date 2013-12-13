#!/bin/bash
#should be run at the root of this repo

echo ">>git add ."
git add .
echo ""

echo ">>git commit -m \"...\""
git commit -m "modify README.md"
echo ""

echo ">>git merge master"
git merge master
echo ""

echo ">>git push origin master"
git push origin master
echo ""
