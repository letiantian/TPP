#!/bin/bash
#should be run at the root of this repo

echo ">>git add ."
git add .
echo ""

echo ">>git commit -m \"...\""
git commit -m "rm push.md, it is a irrelevant file"
echo ""

echo ">>git merge master"
git merge master
echo ""

echo ">>git push origin master"
git push origin master
echo ""
