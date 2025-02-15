=== CommentLuv ===
Contributors: seanbarton
Tags: commentluv, comments, last blog post, linkluv, comment luv , commentlove, comment love
Requires at least: 4.8
Tested up to: 5.3
Stable tag: 3.0
	
Reward your readers by automatically placing a link to their last blog post at the end of their comment. Encourage a community and discover new posts.

== Description ==

[Find out about how to upgrade to CommentLuv Pro!](https://comluvplugin.com "Upgrade to CommentLuv Pro")

CommentLuv Pro has even more amazing features that can bring even more traffic and comments to your blog by giving you the ability to fight spam, add keywords, integrate twitterlink, add a top commentators widget, social enticements and, by having it installed on your site, you get advanced backlink features on EVERY CommentLuv blog when you comment (there are 10's of thousands of CommentLuv blogs)

[About](https://comluvplugin.com/ "About") | [Features](https://comluvplugin.com "Features") | [Pricing](https://comluvplugin.com "Pricing")

This plugin will visit the site of the comment author while they type their comment and retrieve their last blog posts which they can choose to include at the bottom of their comment when they click submit.

It has been found to increase comments and the community spirit for the thousands of blogs that have installed it. With a simple install you will immediately start to find new and interesting blog posts from your own blog and community. You will even be able to build your list/network/community even more by offering your readers the opportunity to register to your site to unlock advanced features of the plugin like being able to choose from any of their 10 last posts when they comment or other features like dofollow links and more.

The plugin will work with administrators and logged on users provided they have their homepage url set in their profile page in the dashboard of the site.

[youtube http://www.youtube.com/watch?v=7wod9ZtiHaU]

Now with updated functions to allow you to delete or spam comments where the user has removed their url after getting a last blog post link (helps prevents spammer abuse)

NOTE!

The links that CommentLuv adds are valuable for the people that leave comments so you will need to make sure that spammers do not try to take advantage of your blog by filling it with useless comments just to get a link. Be a good blogger and prevent them from leaving their crap on your site by requiring moderation on first comments and do not accept 'great post thanks!' type of comments.

remember.. if you let anyone comment on your blog without restriction then you WILL get spammed whether you have CommentLuv or not. Be strict with your comment policy and be take responsibility for your own blog by being selective with the comments you accept and the internet will be a happier, spam free and useful place again! :-)

== Installation ==

Wordpress : Extract the zip file and just drop the contents in the wp-content/plugins/ directory of your WordPress installation and then activate the Plugin from Plugins page or visit the plugins page in your dashboard, click 'add new' and search for 'commentluv'

If you're upgrading from an older version, please use the 'reset to default settings' button.

== Frequently Asked Questions ==

= Does this plugin add any database tables? =

No. The link and associated data is saved to the comment meta table

= My comments form does not show the name and url fields, just the textarea

Make sure you log out of your blog and view the form as a user would. A logged in user does not see the name, email and url fields because your blog already knows them.

= My comment replies are not showing as indented or the thread of the comment is not working

This is entirely down to your theme. Commentluv does nothing to the display of the comments, it just adds the link

= I installed the plugin but I don't see the comment form or the badge shows but commentluv is not working

The plugin only works on wordpress comments systems, it does not work on Disqus or livefyre or jetpack or others. If you are using standard wordpress comments but do not see the form or it is asking you to register then make sure your theme supports comments or you have enabled comments in the settings of your blog or theme

= I am having a problem getting it to work =

Please see the videos in the settings page for explanations of how they work.

= Accents in my language are not showing correctly =

Please tick the box marked "disable UTF8 encoding" in the technical settings area of the plugins settings page

== Screenshots ==

1. settings page

2. in use

3. comments admin

4. edit post comments

== ChangeLog ==

= 3.0.3/3.0.4 =
* November 19, 2019
* Version bump. Changed author name and checked/confirmed compatibility with WP 5.3

= 3.0.2 =
* December 17, 2018
* Removed function to create the comment meta table as it's been a part of WP for years now. Also supports PHP7.2 as a result

= 3.0.1 =
* December 15, 2018
* Fixed an issue with the settings form no longer working
* Added some CSS to make the white and default images smaller as they were very large!

= 3.0 =
* December 14, 2018
* Facelifted and rebranded... new CSS, new settings page. More to come!
* Now works with HTTPS urls

= 2.95 =
* October 5, 2018
* fixed : many blogs now use caching, so we are testing out removal of a nonce check to see the impact

= 2.94.8 =
* October 5, 2018
* fixed : a few PHP notice errors
* fixed : allow commenters to use https:// or http:// in URL field. Previously, only http:// was allowed
* fixed : After blog domain name changes or SSL site migrations, API URL setting could be incorrect. If this setting is incorrect, we use various methods to ensure the plugin still functions on the frontend.
* fixed : possible fix for errors when fetching recent posts from commenters when their blog is SSL
* fixed : using newer plugin-included simplepie library to assist with connecting to various SSL hosts
* updated : easier for commenters to use by triggering recent posts fetch on textarea focus AND website blur, helps eliminate need to toggle CommentLuv checkbox off/on to trigger a fetch

= 2.94.7 =
* updated : compatibility
* updated : no longer encoding to UTF8

= 2.94.5 = 
* updated : compatibility

= 2.94.4 =
* added : Thai translation

= 2.94.3 =
* added : swahili translation

= 2.94.1 =
* updated : added message about free 10 week course.
* updated : compatibility notice

= 2.94 = 

* fixed : undefined index error on display of feed if can't found in settings page
* added : you can now uncheck the option to use the security nonce for ajax calls (in cases where blogs are using a peristent cache)

= 2.93.9 =

* updated FAQ

= 2.93.8 =

*fixed : videos where not showing in popup (server move broke URLs)
*updated : compatibility declaration

= 2.93.6 =

*fixed : feed display in settings page allows for non array return
*fixed : undefined index in ajax processer broke ajax if settings set to show all errors (rare)

= 2.93.5 =

* added : option to allow disable of utf8 encode on feed  (thanks Eli http://www.un-jardin-bio.com for testing)

= 2.93.4 =

* updated : experimental - force to utf8 characters when outputting feed
* updated : vietnamese language update

= 2.93.3 =

* updated : readme now says minimum wp 3.6 required
* updated : add_removeluv_link now detects if $post is not available (prevents error on dashboard comments)
* fixed : sidebar for wordpress 3.8 now shows properly (removed width setting on #poststuff div)
* updated : sidebar facebook widget updated to use comluv.com version

= 2.93.2 =

* updated : get_user_by_email removed from functions.

= 2.93.1 =

* updated : prevent notice in admin for $authurl , check it is in $comment before trying to use it

= 2.93 =

* fixed : removed deprecated .live from javascript

= 2.92.9 =

* updated : settings page panel for ads
* updated : compatibility setting

= 2.92.8 =

* updated : translation for Bengali
* updated : translation for Turkish
* added : allow swap of [type] with 'blog post' so old versions that are updated but not modified will look better

= 2.92.7 =

* fixed : enclose title in cdata tags in send feed file function to prevent invalid xml errors

= 2.92.6 =

* fixed : special feed was showing special chars for hyphen and quotes in post titles
* fixed : strip tags from feed before displaying in drop down

= 2.92.5 =

* fixed : simplepie library changed to use separate class file for File
* updated : better error reporting with simplepie for sites with undiscovered feeds

= 2.92.4 =

* updated : make ajax fetch more secure

= 2.92.3 =

* updated : fetch feed function updated to try 1 more alternative if all else fails
* fixed : wpdb->prepare notice fix

= 2.92.2 =

* updated : updated Italian translation (thanks Gianni!)
* added : Serbian translation (thanks Diana!)
* updated : version checking to show ionCube status
* updated : add version number of plugin to version number of register script call

= 2.92.1 =

* added : ability to allow Jetpack comments to activate. (thought it best to still allow free choice, maybe someone wants the advantage they get with commentluv when they comment on other commentluv blogs?)

= 2.92 =

* prevent jetpack comments module from being activated so comment is not affected by jetpack plugin upgrades.
* updated : Italian translation

= 2.91.1 =
* minor mishap with ajax notify signup action. It was in the wrong place!

= 2.91 =
* new changes implimented for author/category urls
* remove ugly red box for upgrade notice. replace with calming yellow one with a convenient link to update the plugin.
* fixed : prevent DOING_AJAX from being defined if is already defined
* updated : clear output buffer before sending feed
* updated : prevent simplepie deprecated notices from showing when fetching feed if php is set to show them
* updated : add trailing slash to url for fetching feed (some sites that have errors bork without trailing slash)
* updated : do first round of effecient action setting so ajax only functions are much better for memory

= 2.90.9.9.3 =
* changed : try no whitespace in send_feed_file
* changed : send application/atom+xml header before feed file to maybe prevent invalid mime type errors
* changed : request feed set to feed = atom in fetch_feed
* updated : can now request author/category and tag posts by using appropriate url in comment form of a commentluv enabled site

= 2.90.9.9.2 =
* added : try to increase memory available to commentluv
* changed : set encoding to match that of the blog in send_feed_file

= 2.90.9.9.1 =
* fixed : trying new encoding of send_feed_file to match blog encoding

= 2.90.9.9 =
* fixed : trying updated detection routines to be compatible with new WP 3.4 query code

= 2.90.9.8 =
* added : Hungarian Translation
* added : Vietnamese Translation
* added : Slovak Translation
* fixed : send_feed only to send post_type of post
* updated : fall back to /?feed=rss2 in url for fetch feed if no feed found
* updated : add query arg to site url when fetching feed so w3 total cache knows not to cache the response
* updated : user can now choose to delete or spam a comment that has a link but no author url (prevent spammer abuse)
* updated : Slovak flag fixed

= 2.90.9.7 =
* updated : Italian translation by Gianni
* added : make wp_query->is_feed = true if commentluv request detected

= 2.90.9.6 =
* added : code to prevent wp_head and wp_footer actions on a commentluv request from other sites
* fixed : minor translation string bug in __construct

= 2.90.9.5 =
* fixed : upgrading to 3.3 meant it would show the link even if admin set to not show link if no author URL in comment
* fixed : footer error about invalid argument if minifying set to on
* fixed : do not show unregistered in info panel if not set to 'registered' for who to show 10 posts

= 2.90.9.4 =
* added : Hebrew translation
* fixed : do not echo WP 3.0 requirement, use wp_die instead

= 2.90.9.3 =
* fix : another empty src badge bug
* fix : link not showing in admin page if a setting was enabled
* added : empty index files in directories to prevent indexing of plugins folders
* updated : images updated by Byteful Traveller (byteful.com)

= 2.90.9.2 =
* fix : sometimes badge was showing empty src
* added : Bengali language
* settings page header
* modify settings page intro
* added : prevent links for comments that have had the URL removed

= 2.90.9.1 =
* removed : w3 total cache stuff causes fatal errors on activation. removing all w3 stuff completely

= 2.90.9 =
* added : Danish language
* fixed : minor problems with some checkbox vars
* fixed : issue where an empty link might get added to a comment
* fixed : small bug in settings page that prevented checkbox from being checked for default on if default admin on was unchecked
* fixed : use `home_url()` instead of deprecated `get_bloginfo('home')` in `send_feed()` function
* fixed : url value check compatible with iPad which adds a capital letter for the first letter of a form field

= 2.90.8.3 =
* fixed : fixed the error with cl_settings not defined (it was not localizing the script)

= 2.90.8.2 =
* added : french translation
* fixed : sorry! I messed up the code when I tried to remove notices from happening in debug mode which made some blogs have an error.

= 2.90.8.1 =
* updated italian language (thanks Gianni)
* fixed : fixed all notices when running in DEBUG mode
* fixed : default image display in settings page was not showing after resetting settings

= 2.90.8 =
* added : Tamil language
* added : Ukranian language
* added : check for home page in detect commentluv request and send back 10 last posts instead of relying on object which my be populated with the contents of a homepage slider
* added : function to count number of approved comments with luvlink made in the past 14 days
* added : Latvian language
* fixed : small issue with Polish language showing weird characters in settings page.
* updated : Polish translation (thanks Mariusz!)
* fixed : minor issue with settings page localized js for badge choice in IE
* added : Romanian language
* fixed : couple of undefined index warnings showing when on debug mode
* fixed : error responseText for parseerror should now show the response body
* added : check for wp_rss function existence before including rss.php to prevent a fatal error if another plugin is including rss.php in every page (eg. energizer plugin)
* added : Norwegian language

= 2.90.7 =
* added : more detailed error messages to javascript
* added : update version number in db on activation if existing version is less
* added : not authorized error in fetch function if nonce check fails
* added : allow disabling of commentluv request detection (for those getting xml errors when commenting on other sites)
* added : if w3 total cache active, clear cache on commentluv activation/upgrade.
* added : German translation
* added : warning if saving settings with 10 posts only for registered users but registration not enabled
* added : include note about registration not enabled to drop down list (only for admin to see)
* added : auto add commentluv to list of useragents to ignore for w3 pagecache 
* bugfix : prevent theme from outputting data before send_feed if commentluv useragent detected
* added : Persian translation

= 2.90.6 = 
* bugfix : causing fatal error on upgrade to 2.90.5 sorry!! It was all my fault
* bugfix : escape titles of other posts when showing info panel.
* bugfix : compatibility with W3 total cache
* removed : attempt at detecting useragent and object buffering to counteract W3 total cache 
* added : detection of headers already sent
* added : add register link to drop down list if the link is missing and regisration is enabled
* added : spanish translation
* change : settings page field for register link set to disabled and descriptive text added
* change : add random number of seconds up to 1 week to cron time setting on activation to prevent overload on server when plugin update is released


= 2.90.5 =
* bugfix : send feed function needed to wrap titles in <![CDATA[ ]]> to prevent & from causing xml error (thanks @bienvoyager for testing!)
* added : use ob_start as early as possible if commentluv useragent detected
* added : version check with parameters
 
= 2.90.3 = 
* Added some ajax error messages in case of 404 or 500 server errors
* Added Indonesian language
* Fixed Malaysian language
* Tweaked click notification function to be non blocking

= 2.90.1 =
* whole new version rewritten from scratch that makes it standalone.

= 2.81.8 =
* settings page notification block 

= 2.81.7 =
* added : Lithuanian translation
* added : Set nofollow on all links, no links or just unregistered users links
* fix : xhtml compliance on checkbox (thanks @winkpress)
* fix : check commentmeta data is an array

= 2.81.6 =
* added : Portuguese (Brazil) translation
* fixed : added ; to functions in js file
* added : option to enable compression compatibility for js files and move cl_settings js to footer
* added : Romanian language
* added : Arabic language
* added : Georgian language

= 2.81.5 =
* fixed : commentluv now available on pages too
* update : change click to hover for showing drop down of last blog posts that were fetched
* added : Polish translation
* update : settings page prettifying (hmm perdy!)
* update : set drop down for last blogs posts event to hover instead of click

= 2.81.4 =
* Fixed : removeluv link in comments admin would result in 404 (thanks @techpatio)

= 2.81.3 =
* Change the way to detect if on a multi site install or not
* updated one of the badges

= 2.81.2 =
* silly me, put the version number wrong!
* Set back to default settings if upgrading from less than 2.81
* Show url field for logged on user if buddypress is active 

= 2.81.1 =
* Prevent empty last post from being included. Also included in API
* Fixed Dutch translation (thanks Rene http://wpwebshop.com)
* Also have commentluv on pages
* updated badges to new version (thanks Byteful Traveller)

= 2.81 =
* New style.css format for info panel (thanks @Hishaman)
* Only show remove luv link for approved comments
* bug fix : sometimes showed two cluv spans (on beta version comments)

= 2.80 =
* Wordpress 3.0 Compatible
* Use comments meta table instead of hard coding into the comment content
* Drastically improved commmunication with API for comment status changes
* Near 100% accuracy for API to identify members links for info panel
* New heart icon for registered members. Improves hover rates.
* Removed depreciated function to clean old style additional data
* Added link to remove someones luvlink data in the comments admin page
* Dutch Translation by Rene wppg.me
* Added comments_array filter to make Thesis behave
* Added check to see if link already added (WP 3.0 compatibility)
* thanks to @hishaman for helping the thesis testing
* Added code to settings manager to prevent viewing outside wordpress (and fixed the typo later, thanks speedforce.org)

= 2.7691 =
* bugfix : choosing a link from an additional url's posts would result in wrong link being included

= 2.769 =
* Modified hidden post fields so only URL and title sent instead of html A href link
* Modified javascript to take account of new hidden fields.
* Temporary fix to try and fix 404 on wp-post-comments.php when commentluv enabled for logged out user
* thanks to @kwbridge @duane_scott @dannybrown @morpheas7887 for testing and feedback!

= 2.768 =
* Added nothing.gif to images (for updated error message from API)

= 2.767 =
* Added conncettimeout to curl call
* Added warning next to 'use template insert' checkbox in settings page 

= 2.766 =
* Check if function has been called before to prevent two links being added.
* updated images (supplied by http://byteful.com)

= 2.765 =
* Hollys changes. Allow user choice of colour for the info panel background.

= 2.764 =
* Removed json_decode. Some wp2.9 installs were getting errors

= 2.763 =
* Added check for hidden fields display to prevent double instances.
* Make css file valid
* Added French translation by Leo http://referenceurfreelance.com

= 2.762 =
* Added permalink as refer variable in ajax calls for better stat collecting since WP started to use paginated comments
* Added Chinese translation by Denis http://zuoshen.com/
* Added Hebrew translation by Maor http://www.maorb.info/
* Added Russian translation by FatCow 
* Updated readme.txt to use new features like changelog
* Check for http:// in url field before firing (to prevent errors for forms that use js hints in form fields)

= 2.761 =
* 19 Jun 2009 -  fix for htmlspecialchars decode causing error in wp < 2.8

= 2.76 = 
* 16 Jun 2009 - Bug fix, use_template checkbox not displaying when selected on settings page (breaker). typo in settings page now uses &lt;?php cl\_display\_badge(); ?&gt;
* added global variable for badgeshown to prevent mulitple instances (template contains function call AND use template check is off)
* fixed output of prepend html using decode html and stripslashes. Added green background to update settings button.

= 2.74 =
* 14 Jun 2009 - Italian translation added (and fix CR in string on manager page). Thanks go to Gianni Diurno

= 2.71 =
* 13 Jun 2009 - fix php4 from not allowing last string pos (strrpos)

= 2.7 =
* 12 Jun 2009 - small fixes for valid xhtml on images and checkbox . remove identifying .-= / =-. from inserted link on display time. 

== Upgrade Notice ==

= 2.93 =
                                                                   
updated javascript compatibility and wp3.8 compatibility

== Configuration ==

Display Options : Enter the text you want displayed in the comment for the link that is added.

* [name] -> replaced with comment author name

* [lastpost] -> replaced with the titled link.

* CommentLuv on by default -> check this box to enable CommentLuv by default

* Show info panel -> Shows the heart icon next to links so users can find out more about the comment author

* Use template insert to show badge and checkbox -> check this box if you want to place the badge and pull down box in a particular place on your page by using the template code.

* display badge -> choose from 3 different badges, choose no badge or use your own or specified text

Technical Settings:

* Authors name field name -> The name value of the field used on your comment form for the comment authors name

* Email field name -> The name value of the field used on your comment form for the comment authors email

* Authors URL field name -> The name value of the field used on your comment form for the comment authors site URL

* Comments Text Area Name -> The name value of the field used on your comment form for the comment 

* update -> updates the settings

* reset -> if you get in trouble, click this to reset to default settings

== Adding to your template ==

Use `<?php cl_display_badge(); ?>` in your comments.php file where you want the badge and checkbox to be shown

This plugin inserts fields to the comment form at run time. If you find there is no badge shown on the comment form after you first install it, please check your comments.php file for the command `<?php do_action('comment_form', $post->ID); ?>` before the `</form>` tag

For logged on users and administrators, be sure to check your profile on your own dashboard and make sure there is a url entered.