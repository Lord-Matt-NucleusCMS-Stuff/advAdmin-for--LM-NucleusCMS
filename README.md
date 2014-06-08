What is advAdmin?
=================
advAdmin is a project o make advanced changes to the behaviour of the admin area
by way of careful use of object extension. Ideally this should involve little or
no copy and paste code and exactly zero edits to the core files.

The project aim is to use only the best PHP5 design patterns thus allow true OOD
methodologies. Every behaviour of the admin area should be available for changes
without core edits.

This is done by forking the index file and using .htaccess to route calls to the
new version.  No core edits but if the core used an extensible factory this hack 
would not be needed.

Currently plugins can extend this to edit the admin area with simpleXML.

INSTALL
=======
To install you need a copy of NucleusCMS set up.

Copy all root files and folders to the /nucleus/ folder so that the demo plugin 
ends up in plugins where it should be and advAdmin files (with the one exception
of advAdmin_index.php) end up in the advAdmin folder. 

Install the plugin as normal. If you see a pointless box in your admin area it 
all worked. Now uninstall the demo plugin and write something cool.

Progress:
========

0. framework        - A light as possible framework to allow easy admin area 
                      extension. Provides a factory and a singleton parent class
                      for developers.
                      New Events: advAtdminInit
1. advAdmin::ADMIN  - This changes the way the ADMIN class works so that output 
                      happens later and the page is available for inspection and
                      for changes before being sent to the user.
                      New events: allAdminHTMM, allAdminXML

New Events
==========
* advAtdminInit - fires when the advAdmin factory first starts it gives a chance
                  to register an override class name in the factory.
* allAdminHTMM  - inspect the HTML of the admin page prior to changes
* allAdminXML   - the admin area as a simpleXML object changes should be made 
                  here. See advAdmin_admin.php for more notes.

advAdmin Core
=============

+advAdmin_index.php          - a forked version of index.php where we hook 
+ .access                    - force apache to use advAdmin_index.php and taking
                               over with our new file without core edits.
+./advAdmin                  - the core folder
    + .htaccess              - security measure
    + .README                - This file
    + advAdmin.php           - The bootstrap that loads everything else
    + advAdmin_admin.php     - Free edit on all admin pages [See Progress 1]
    + advAdmin_factory.php   - this is our factory class. Things would be much 
                               easier if the core did this but them's the breaks
    + advAdmin_simpleXML.php - extra features for page editing
+./plugins
    + NP_AdvAdminBasicDemoOne - An example of the process being used. It's a bit 
                                useless beyond showing off that it all works.

Wishful thinking
----------------
Stuff I would have added had late static bindings been something with greater 
uptake. Sidelined until PHP5.3 is the mimimum to be expected.
    + advAdmin_singleton.php - a helper class that provides child classes with 
                               the singleton model. Used by factory.

advAdmin_simpleXML
==================
Has all of the features of PHP simpleXML but has extended it with additional 
methods designed to help you edit the page.

prependChild($name, $value)
---------------------------
The method allow you to put a new child at the start of a collection of child 
nodes rather than at the end. Added 08/06/14.


ToDo
====
01. advAdmin.php should register an autoloader function and not use require
02. Solve utf-8 encoding issues.
03. more control over admin functions

Known bugs
==========
# simpleXML forces utf-8 conversion which can leave artifacts in the HTML.