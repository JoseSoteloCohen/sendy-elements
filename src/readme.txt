=== Sendy Elements ===
Contributors: josesotelocohen
Donate link: https://compras.inboundlatino.com/sendy-elements/
Tags: sendy, elementor, forms, newsletters, email marketing, subscription form
Requires at least: 4.7
Tested up to: 5.4
Requires PHP: 5.4
Stable tag: 1.0.4
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl-3.0.html
Requires [Elementor Pro](https://elementor.com) 2.9 or greater

Simple plugin that integrates Elementor Pro form widget with Sendy via API.


== Description ==


Simple solution for users of Sendy and Elementor that do not wish to modify the functions.php file of their theme. This plugin will allow you to send subscriptions made via Elementor's Pro form widget to your Sendy list.


== Installation ==

= Minimum Requirements =

* WordPress 4.7 or greater
* PHP version 5.4 or greater
* MySQL version 5.0 or greater
* [Elementor Pro](https://elementor.com) 2.5 or greater

= We recommend your host supports: =

* PHP version 7.0 or greater
* MySQL version 5.6 or greater
* WordPress Memory limit of 64 MB or greater (128 MB or higher is preferred)


= Installation =

1. Install using the WordPress built-in Plugin installer, or Extract the zip file and drop the contents in the `wp-content/plugins/` directory of your WordPress installation.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Go to Pages > Add New
4. Press the 'Edit with Elementor' button.
5. Now you can drag and drop the form widget of Elementor Pro from the left panel onto the content area, and find the Sendy action in the "Actions after submit" dropdown.
6. Fill your Sendy List details and all your subscribers will be sent to that list.
7. Your Sendy URL needs to end in /
8. Name Field ID and Email Field ID are a MUST and you can configure them like this:

[Click here to see the tutorial](https://storyxpress.co/video/k8o0bfds33qbakuqi)


== Frequently Asked Questions ==

**Why do I need this plugin?**

Because there's no native way to send subscribers from Elementor Pro form widget to Sendy, so if you want to avoid modifying your Functions.php to achieve this, you can just install Sendy Elements with a couple of clicks.

**Why is Elementor Pro required?**

Because this integration works with the Form Widget, which is a Elementor Pro unique feature not available in the free plugin.

**Can I still use other integrations if I install Sendy Elements?**

Yes, all the other form widget integrations will be available. You can even use more than one at the same time per form.

**Do I need to know how to code to use Sendy Elements?**

No, you don't and that's the main reason that I created this plugin, so you can integrate both Sendy and Elementor without knowing how to code.


== Screenshots ==

1. **Select from the Dropdown.** Just select Sendy from the "Actions After Submit" dropdown in the form widget.
2. **Sendy List ID.** You can find the list ID in your Sendy Lists dashboard.
3. **Sendy URL.** This is the domain where you installed Sendy. It must finish with /


== Changelog ==

= 2.0.0 - 2020-08-01 =
* Improvement: Option for GDPR/CCPA Compliance - thanks to @tmgreen
* Improvement: The name field force the first character to UPPER CASE - thanks to @tmgreen
* Improvement: Added custom fields as repeaters so you can add as many as you want

= 1.0.4 - 2020-03-25 =
* Elementor moved the Utils from Classes to Core, so modified that.

= 1.0.3 - 2019-12-20 =
* Solved a bug in which it caused a fatal error when Elementor Pro wasn't active or installed.

= 1.0.2 - 2019-11-26 =
* ONLY UPDATE IF YOU HAVE THE SENDY VERSION 4.0.3.3 +
* Added the API Key field that was implemented in Sendy version 4.0.3.3.

= 1.0.1 - 2019-05-23 =
* Tweak: Corrected the Elementor version.
* Tweak: Improved the Installation and Screenshot documentation.
* Tweak: Removed unnecessary code calling custom widgets.

= 1.0.0 - 2019-05-19 =
* Initial Release