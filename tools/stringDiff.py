#!/usr/bin/env python
# -*- coding: utf-8 -*-

import xml.etree.ElementTree as ET
import sys, getopt

def printUsage():
    print 'usage: stringDiff.py --oldFile <oldStringsFile> --newFile <newStringsFile> [-o <output>]'

def main(argv):
    oldStringsFile = ''
    newStringsFile = ''
    outputFile = 'modifiedStrings.xml'
    try:
        opts, args = getopt.getopt(argv, "ho:", ["oldFile=", "newFile=", "output="])
    except getopt.GetoptError:
          printUsage()
          sys.exit(2)
    for opt, arg in opts:
        if opt == '-h':
           printUsage()
           sys.exit()
        elif opt == "--oldFile":
           oldStringsFile = arg
        elif opt == "--newFile":
           newStringsFile = arg
        elif opt in ("-o", "--output"):
           outputfile = arg
    if (oldStringsFile == '' or newStringsFile == ''):
        printUsage()
        sys.exit(2)

    print "Parsing files for differences..."
    oldXml = ET.parse(oldStringsFile)
    newXml = ET.parse(newStringsFile)
    root = ET.Element("strings")
    for stringElement in newXml.findall('string'):
        xpathQuery = ".//string[@name='" + stringElement.get("name") + "']"
        oldElement = oldXml.getroot().find(xpathQuery)
        if oldElement is not None:
            encoding = "UTF-8"
            oldValue = ET.tostring(oldElement, encoding)
            newValue = ET.tostring(stringElement, encoding)
            if oldValue != newValue:
                root.append(stringElement)
            else:
                root.append(stringElement)
    locFile = open(outputFile, "w")
    locFile.write(ET.tostring(root))
    print 'Output written to ', outputFile

'''
oldXml = ET.parse("strings_old.xml")
newXml = ET.parse("strings_new.xml")
root = ET.Element("strings")
for stringElement in newXml.findall('string'):
    xpathQuery = ".//string[@name='" + stringElement.get("name") + "']"
    oldElement = oldXml.getroot().find(xpathQuery)
    if oldElement is not None:
        encoding = "UTF-8"
        oldValue = ET.tostring(oldElement, encoding)
        newValue = ET.tostring(stringElement, encoding)
        if oldValue != newValue:
            print "Adding string " + stringElement.get("name")
            root.append(stringElement)
    else:
        root.append(stringElement)
locFile = open("strings_diff.xml", "w")
locFile.write(ET.tostring(root))
'''

if __name__ == "__main__":
   main(sys.argv[1:])

