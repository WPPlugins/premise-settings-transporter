=== Premise Settings Transporter ===
Contributors: daveshine, deckerweb
Donate link: http://genesisthemes.de/en/donate/
Tags: premise, landing pages, member access, accesspress, settings, plugins, export, import, exporter, transport, transporter, data, copyblogger, deckerweb
Requires at least: 3.3
Tested up to: 3.6
Stable tag: 1.1.0
License: GPL-2.0+
License URI: http://www.opensource.org/licenses/gpl-license.php

Adds a settings Import/ Export feature to the "Premise" premium landing page & member access plugin.

== Description ==

> #### Backup or Transfer Settings
> Finally, transfer Premise settings from one site to another. Or just make backups. Third-party plugins from Premise are supported as well. Especially useful for developers to speed up their work!
> 
> A **great helper tool** for the premium "Premise" plugin!

= Features, Advantages & Benefits =
* *Premise Main settings* supported!
* *ALL Premise Designs/ Themes* supported! (complete set) --- WHOA, great time safer for Marketers!
* *ALL Premise Configured Buttons* supported! (complete set) --- Another WHOA, great time safer for Marketers :)
* *Premise Custom Code content(s)* supported!
* Module *"MemberAccess" settings* supported! (only if activated)
* Third-party plugins for Premise that have extra settings are also supported! (Currently: "Premise iDevAffiliate Integration")
* *1st alternative:* Combined settings `.JSON` file, speeds up development especially! (For example: ALL Premise main settings, plus ALL MemberAccess main settings, plus ALL Landing Page Design Sets, plus ALL Button configuritions -- very handy ;-)
* *2nd alternative:* Seperate `.JSON` files of settings sections could be useful for testing purposes for developers etc.
* New plugins may be added, that support the WordPress / Premise Settings Field/ API!
* Fully internationalized plugin, fully transalateable.
* This plugin just leverages the AWESOMENESS of Premise and WordPress! Therefore it's a really simple, lightweight, flexible plugin.
* What's not supported: *individual* "Design Settings" (already has built-in exporter!) and "Landing Pages" (export via WordPress built-in exporter for post types!) -- [See FAQ for more info on that topic](http://wordpress.org/plugins/premise-settings-transporter/faq/)

= Useful for: =
* Marketers who want to transfer their sets of Landing Page Design Sets and Button configurations on other projects/ installations. --- SAVE YOUR TIME with reconfiguring!
* Users who want to backup their settings - in a combined way, or seperate for supported settings and/ or plugins.
* Developers and/ or agencies who want to speed up their development times and just use pure Premise awesomeness :).

> #### Typical Workflow Example
> *Transfer settings from a development install to the live/ production install.*
> 
> **1) Prerequisites/ Requirements:**
> 
> * On BOTH sites/ installations you have installed & activated "Premise".
> * On BOTH sites/ installations you have installed & activated this plugin, "Premise Settings Transporter".
> * It's recommended to have THE VERY SAME VERSIONS installed on the original site and also the receiving site. Reason: sometimes settings differ between plugin versions. So with making sure you have the same versions installed you just ensure the correct settings are included within the export file.
> 
> **2) Transfer:**
> 
> * On the development install: Just make an Export file via "Premise > Import/Export" admin page:
> * In the "Export" section there enable all checkboxes you need.
> * Save the .JSON file to your computer.
> * On the live/ production site, just import this .JSON file and you're done! ;-)

**Please note:** This plugin requires the **premium plugin "Premise"** (released by Copyblogger Media LLC), at least version 2.1 or higher.

= Localization =
* English (default) - always included
* German (de_DE) - always included
* .pot file (`premise-settings-transporter.pot`) for translators is also always included :)
* Easy plugin translation platform with GlotPress tool: [Translate "Premise Settings Transporter"...](http://translate.wpautobahn.com/projects/wordpress-plugins-deckerweb/premise-settings-transporter)
* *Your translation? - [Just send it in](http://genesisthemes.de/en/contact/)*

[A plugin from deckerweb.de and GenesisThemes](http://genesisthemes.de/en/)

= Feedback =
* I am open for your suggestions and feedback - Thank you for using or trying out one of my plugins!
* Drop me a line [@deckerweb](http://twitter.com/deckerweb) on Twitter
* Follow me on [+David Decker](http://deckerweb.de/gplus) on Google Plus ;-)

= More =
* My 'exporter plugin' for Genesis: [*"Genesis Extra Settings Transporter"*](http://wordpress.org/plugins/genesis-extra-settings-transporter/)
* [Also see my other plugins](http://genesisthemes.de/en/wp-plugins/) or see [my WordPress.org profile page](http://profiles.wordpress.org/daveshine/)
* Tip: [*GenesisFinder* - Find then create. Your Genesis Framework Search Engine.](http://genesisfinder.com/)
* Hey, come & join the [Genesis Community on Google+ :)](http://ddwb.me/genesiscommunity)

== Installation ==

1. Upload `premise-settings-transporter` folder to the `/wp-content/plugins/` directory -- or just upload the ZIP package via 'Plugins > Add New > Upload' in your WP Admin
2. Activate the plugin through the "Plugins" menu in WordPress
3. Then go to the new Premise "Import/ Export" page under "Premise > Import/Export" and check the available options.
4. Make your export(s), just for backup or transport settings into other installations, etc. ...
5. Enjoy :)

**Usage:** See plugin description for a ["Typical Workflow Example"](http://wordpress.org/plugins/premise-settings-transporter/).

**Note: The "Premise" premium plugin is required for this plugin in order to work!** At least version 2.1 or higher, but it's recommended to always use the latest version, that is 2.4 or higher!

**Own translation/wording:** For custom and update-secure language files please upload them to `/wp-content/languages/premise-settings-transporter/` (just create this folder) - This enables you to use fully custom translations that won't be overridden on plugin updates. Also, complete custom English wording is possible with that, just use a language file like `premise-settings-transporter-en_US.mo/.po` to achieve that (for creating one see the tools on "Other Notes").

== Frequently Asked Questions ==

= What's the recommended usage of this plugin? =
Just see plugin [description page](http://wordpress.org/plugins/premise-settings-transporter/) for a typical workflow example.

= Some settings seem not to be included, what should I do? =
Just make sure you have the very same versions of the Premise plugin installed on the various installations. If you have a development and live install, just make sure, both have the very same version of "Premise" installed. -- Reason: Sometimes setting field names could differ between different versions, or settings may be added or removed in newer/ older versions.

= Why are the *individual "Desgin Settings"* not included? =
No worries, the *individual "Design Settings"* have a built-in export/ import feature in "Premise" already! If you have already created more than one Design just can open each one and export/ import it individually. You can export all Designs except the default one. To export the default Design just duplicate it and then it also becomes exportable ;-).

= Why are the "Landing Pages" not included? =
Again, no worries, the Premise "Landing Pages" are a custom post type and therefore it could be exported/ imported via WordPress own's export functionality for custom post types. Just go to "Tools > Export Data" select "Landing Pages" from the list there and make an `.xml` export file for your landing pages only.

To import the "Landing Pages" `.xml` file, just install & activate the [official "WordPress Importer" plugin](http://wordpress.org/plugins/wordpress-importer/), then go to "Tools > Import Data" and upload your export file. Also very simple, yeah :).

= Hands down, how does it all work? =
I just ported the awesome (!) Genesis exporter feature for the Premise plugin. So, you have to applaud the developers of Genesis Framework for their awesome work, they did all the heavy lifting!

== Screenshots ==

1. Premise Settings Transporter: new Import and Export admin page for "Premise" plugin. ([Click here for larger version of screenshot](https://www.dropbox.com/s/4n1omd466dvh2zp/screenshot-01.png))
2. Premise Settings Transporter: plugin help tab. ([Click here for larger version of screenshot](https://www.dropbox.com/s/m63u1xi56413r0d/screenshot-02.png))

== Changelog ==

= 1.1.0 (2013-06-14) =
* NEW: Added plugin support for "Premise Infusionsoft® Integration" (premium, by Eugen Oprea) -- big probs to Eugen Oprea for helping me adding support for the plugin, check it out at: [www.eugenoprea.com](http://www.eugenoprea.com/wordpress-plugins/premise-infusionsoft-integration/)
* NEW: Added plugin support for "WP Premise Box" (free, by Jimmy Peña).
* NEW: Added plugin support for "GA Ecommerce Tracking for Premise" (free, by Eugen Oprea).
* NEW: Added a "Select / Unselect ALL Checkboxes" button the Export/ Import admin page :).
* UPDATE: Improved translation loading.
* CODE: Minor code/ documentation updates & improvements.
* UPDATE: Updated German translations and also the .pot file for all translators!

= 1.0.0 (2013-04-07) =
* *Initial release*
* Includes support for 1 third-party plugin! (Currently: "Premise iDevAffiliate Integration")

== Upgrade Notice ==

= 1.1.0 =
Several additions & improvements: Extended plugin support; code/ documentation improvements. Also updated .pot file for translators plus German translations.

= 1.0.0 =
Just released into the wild.

== Plugin Links ==
* [Translations (GlotPress)](http://translate.wpautobahn.com/projects/wordpress-plugins-deckerweb/premise-settings-transporter)
* [User support forums](http://wordpress.org/support/plugin/premise-settings-transporter)

== Donate ==
Enjoy using *Premise Settings Transporter*? Please consider [making a small donation](http://genesisthemes.de/en/donate/) to support the project's continued development.

== Translations ==

* English - default, always included
* German (de_DE): Deutsch - immer dabei! [Download auch via deckerweb.de](http://deckerweb.de/material/sprachdateien/genesis-plugins/#premise-settings-transporter)
* For custom and update-secure language files please upload them to `/wp-content/languages/premise-settings-transporter/` (just create this folder) - This enables you to use fully custom translations that won't be overridden on plugin updates. Also, complete custom English wording is possible with that as well, just use a language file like `premise-settings-transporter-en_US.mo/.po` to achieve that.

**Easy plugin translation platform with GlotPress tool:** [**Translate "Premise Settings Transporter"...**](http://translate.wpautobahn.com/projects/wordpress-plugins-deckerweb/premise-settings-transporter)

*Note:* All my plugins are internationalized/ translateable by default. This is very important for all users worldwide. So please contribute your language to the plugin to make it even more useful. For translating I recommend the awesome ["Codestyling Localization" plugin](http://wordpress.org/plugins/codestyling-localization/) and for validating the ["Poedit Editor"](http://www.poedit.net/), which works fine on Windows, Mac and Linux.

== Idea Behind / Philosophy ==
Really enjoying the Genesis Export/ Import feature I just thought it would be awesome to have the same thing available for "Premise". So, based on the Genesis Exporter I adapted this for the "Premise" plugin, including its (optional) "MemberAccess Module" as well as third-party plugins (official, plus from the community!). I hope it helps other users and developers as well! :) ENJOY!

== Credits ==
* **Eugen Oprea** for helping me adding support for his **Premise Infusionsoft® Integration** plugin! THANK YOU! You can [buy the plugin from its offical site](http://www.eugenoprea.com/wordpress-plugins/premise-infusionsoft-integration/) -- also, don't forget to checkout his website at [www.eugenoprea.com](http://www.eugenoprea.com/).