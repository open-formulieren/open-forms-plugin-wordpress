=== Open Forms ===
Contributors:      Maykin
Tags:              openforms, block, commonground
Tested up to:      6.1
Stable tag:        0.1.0
License:           GPLv2 or later
License URI:       https://github.com/open-formulieren/open-forms-plugin-wordpress/LICENSE

Easily integrate Open Forms in your Wordpress website.

== Description ==

With the Open Forms plugin you can easily integrate forms from
[Open Forms](https://github.com/open-formulieren/open-forms) into your Wordpress
website.

There are 2 main features:

1. Configuration to connect to Open Forms is added to your Wordpress settings.
2. Add Open Forms as a Wordpress block plugin on any page, you get a list of 
   forms in Open Forms to choose from.

If you have [Sentry](https://sentry.io/) available, you can configure Sentry as 
well so Open Forms can report errors to it.

== Installation ==

There are two ways to install the Open Forms plugin on Wordpress.  

1. To install the plugin via the listing page, type **Open Forms** in the search 
   box on the Wordpress plugin listing page and click on **Install**.

*OR*

2. Upload the Open Forms plugin zip file using Wordpress' **Upload Plugin** 
   feature. The plugin can be activated immediately after upload.

After installing and activating the plugin, you should now see an Open Forms
entry in the settings menu, on the right sidebar of the admin page.

= Configuration =

**Heads up:** Open Forms should be properly configured to allow your Wordpress 
website to connect to Open Forms. Consult the 
[Open Forms documentation](https://open-forms.readthedocs.io/) on how to do 
this, or ask your Open Forms supplier.

1. You should obtain an Open Forms API token, API root URL and relevant Open 
   Forms SDK URLs.

2. In the Wordpress admin, navigate to: *Settings* > *Open Forms*

3. Fill in all the relevant fields as obtained in step 1.

4. Click on **Save**.

A message should appear whether the connection to Open Forms succeeded or not.

= Usage =

1. Go to any page, and add an **Open Forms** block (listed under Embed).

2. Select the desired form, and hit **Update** in the top right corner to save 
   everything.

3. You can now preview your page with the selected form.

== Frequently Asked Questions ==

= The Open Forms settings page keeps showing a connection error =

Make sure you have your Open Forms API token and API root URL correct and
Open Forms (the service, not this plugin) is correctly configured.

= The form won't show on my page =

If you can select a form in the editor but the form doesn't work in the preview
or live page, Open Forms (the service, not this plugin) is probably not 
properly configured.

== Screenshots ==

1. Open Forms settings in Wordpress
2. Add Open Forms to your page

== Changelog ==

= 0.1.0 =

* Initial release
