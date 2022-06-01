#!/bin/sh

rm -rf release/rangerssdk*
rm -rf release/phpsdk*

zip -r release/phpsdk.zip datarangers/*

