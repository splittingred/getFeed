/**
 * @package ezfaq
 */

File: Readme.txt
Snippet: EZfaq
$Revision: 29 $
$Date: 2008-09-29 16:05:10 -0700 (Tue, 22 Sep 2008) $
Compatibility: MODx Revolution

Author: Bob Ray (based on an idea from SorenG and JavaScript code from DynamicDrive.com)

Thanks to MODx user Sinbad for information on using Flash and Lightbox with EZfaq.

EZfaq allows you to create and display a functional FAQ page. Only the
questions are shown until a user clicks on a question, then that question
is expanded. A number of options control the actions of the page.

You can see the results at http://bobsguides.com/modx-faq.html


USING EZfaq
-----------

If you choose to install the Sample FAQ, you can just edit the content with your
own questions and answers.

The contents of the FAQ page are stored in an unpublished standard MODx document with the following form:


This will be rendered above the first question (optional)

Q:How much is two plus two?

A:Four

Extra: This will always be rendered between questions. (optional)
(Important: Be sure to use Extra:, not EXTRA:)

Q:Who is the fifth avatar of Vishnu?

A:Vamana the Dwarf.

Q:What is Sigmund Freud's middle name?

A:Schlomo

(etc.)
Q:END-FAQ

Work in progress can go here and won't be displayed. (optional)

EZfaq Snippet call
------------------
The minimal snippet call is:
[[!EZfaq? &docID=`##`]]

(where ## is the document identifier of the content document described above).
Snippet names and parameter names are case-sensitive so be careful when typing them.
Parameters must be enclosed in "back-ticks" not single quotes.
Note that the docID is NOT the document identifier of the document containing the
snippet call. It is the document identifier of the document containing the Qs and As.

EZfaq Manual Installation
-------------------------
If you are not using the automatic installation in MODx Revolution, EZfaq can
be installed manually by following these steps:

1. Extract the contents of the EZfaq zip file to your assets/components directory.
The files should end up in a directory called /assets/components/ezfaq.

2. Create a new document for your FAQ content as described above. Add some
questions and answers.

3. This document should be unplublished and should not show in menu.
It just holds the content. You can leave most of the fields blank.

4. Make a note of the document id (in parentheses in the document tree after you save it).

5. Create a new document for your FAQ page. You can probably use your standard template.

6. Give that document a title, longtitle, alias, menu alias, etc.

7. Make sure it's published and will show in the menu.

8. The document's content will usually be just the snippet call:
[[EZfaq? &docID=`##`]]

9. Replace ## with the document number of your unpublished FAQ content document created above.

10. Create a new snippet named EZfaq in the MODx Manager.

11. Cut and paste the code from the ezfaq.inc.php file in the /assets/components/ezfaq directory into the body of the snippet and save it.

EZfaq Optional Parameters
-------------------------
The following parameters change the behavior of EZfaq in various ways.

&showHideAllOption // [display the show/hide all buttons - default "true"]

&statusOpenHTML  // [symbol to put next to open topics (can be an image URL) - defaults to "[-]"]

    // Note: To use a URL replace the "=" sign with "EQUALS" in the snippet call
    // Example: &statusOpenHTML=`<img srcEQUALS"assets/components/ezfaq/images/minus.png">`

&statusClosedHTML  // [symbol to put next to closed topics (can be an image URL) - defaults to "[+]"]

    // Note: To use a URL replace the "=" sign with "EQUALS" in the snippet call
    // Example: &statusClosedHTML=`<img srcEQUALS"assets/components/ezfaq/images/plus.png">`

&openColor  // [color for open questions (name or hex value #ffffff) - default "red"]

&closedColor // [color for closed questions (name or hex value #ffffff) - default "black"]

&setPersist  // [does open state persist across visits/reloads? - default "true";]

        // Note: Doesn't seem to work when all answers are expanded, only when one is.

&collapsePrevious // [if set, only one answer can be open at a time - default "true"]

&defaultExpanded  // [expand answers n1 through n2 ("0,1" expands items 1 through 2) when page is opened (default, none)]

&cssPath // [URL to your own .css file for EZfaq]

       // Note: use &cssPath = `` if you want to put the .css in your site .css file and use no file here

 &faqPath // [URL to the EZfaq directory] - default /assets/components/ezfaq


Available open/closed image pairs
---------------------------------

Open            Closed
----------------------
minus.png        plus.png
minus2.png       plus2.png  (these have outlines)
check.png        x.png

Image URL full example:

[[EZfaq? &docID=`12` &statusOpenHTML=`<img srcEQUALS"assets/components/ezfaq/images/minus.png">` &statusClosedHTML=`<img srcEQUALS"assets/components/ezfaq/images/plus.png">`]]


Styling EZfaq
-------------
Some styling is accomplished with the parameters in the snippet call. Other styling issues require changes to the file:
/assets/components/ezfaq/ezfaq.css



Using Flash Videos and lightbox in the FAQ
An FAQ answer can be in the form of a Flash video using the MODx swfObject snippet (http://modxcms.com/SWFObject-1815.html) and the following format:

Q:How do I play Flash in here?

A:[[swfObject? &swfid=`0` &swfFile=`assets/flash/playback.swf` &swfWidth=`325` &swfHeight=`155`]]

For lightbox images, use:

Q:How do I work with lightbox?

A:<a href="http://domain.com/assets/images/small-pic.jpg" rel="lightbox"><img src="http://domain.com/assets/images/large-pic.jpg" alt="" width="120" height="120" border="0" /></a>

Bob Ray


