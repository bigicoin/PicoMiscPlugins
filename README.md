# PicoMiscPlugins
A miscellaneous set of Pico CMS plugins that probably aren't useful for many others, but for my own.

You are free to use any or all of them in your Pico setup. Simply drop any one of them into your
plugins directory, and add a config line to enable them, for example:

```
$config[ 'PicoOldLinksRedirect.enabled' ] = true;
```

Below is a quick overview of each of the individual plugins in this repository. For detailed
setup instruction, read the header comments section for each one.

## PicoOldLinksRedirect

If you've moved CMS or moving a site from static html to Pico-driven, chances are there are some
pages that has an old style formatted URLs (e.g. `/folder/page.html`) that you want to convert to
a better Pico formatted one that is SEO friendly (e.g. `/folder/My-Page-Title`).

You can use this plugin to set up such redirection, so that any external sites that link to your
old URLs will continue to work and you won't lose those traffic.

## PicoFBComments

It's exactly as it sounds: it allows you to add FB comments to some pages of your site.

There is an [existing plugin](https://github.com/netomx/pico-fb) for this but it's inflexible.

This one allows you to add it only to certain markdown pages by a meta data field, and also
allow you to place it at custom place in the theme file instead of always after the content.

## PicoShareButtons

It's exactly as it sounds: it allows you to add share buttons to some pages of your site.
The only catch is it currently only supports share buttons powered by jiathis.com, which is
Chinese-oriented and less English-oriented, as I originally made this for a Chinese site.

This plugin allows you to add it only to certain markdown pages by a meta data field, and also
allow you to place it at custom place in the theme file instead of always after the content.

## PicoOpenGraph

Adds the proper open graph attributes for social network sharing.

This is a modified/updated version of [this plugin](https://github.com/ahmet2106/pico-opengraph)
which does mostly the same thing but is outdated with the current Pico version.

It also adds a functionality, that is to define a custom image in the page's meta data and save
the time needed to parse through the content for images.

