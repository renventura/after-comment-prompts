# WP Auto Login

This plugin was created for quick login when working locally. In the settings, you add the username and password for any account (i.e. "admin" and "admin"). By visiting /wp-admin/?wp_auto_login=true, you will be automatically logged into the account owning the credentials you set.

## Installation ##

__Automatically__

1. Search for WP Auto Login in the Add New Plugin section of the WordPress admin
2. Install & Activate

__Manually__

1. Download the zip file, unzip it and upload plugin folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress

## Frequently Asked Questions ##

*How do I use this plugin?*

First, I highly discourage you from using this plugin on a live/production environment because it creates obvious security problems (anyone can sign into an admin account). Therefore, you should only use this plugin to skip the login process on local environments.

Once installed and activated, the plugin adds its settings to the General settings page. To use the plugin, simply choose an account to sign into and enter the username and password. For example, on my local sites, I use "admin" for the username and password. Therefore, I'd enter "admin" into these fields and save.

To automatically log in, visit your local site's /wp-admin/?wp_auto_login=true and the plugin will do the rest.

Again, DO NOT USE THIS PLUGIN ON LIVE WEBSITES.

## Bugs ##
If you find an issue, let me know!

## Changelog ##

__1.0__
* Initial version