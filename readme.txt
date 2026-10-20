=== N0KMO LCARS ===
Contributors: n0kmo
Requires at least: 6.2
Tested up to: 6.7
Requires PHP: 7.4
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

An LCARS-inspired WordPress theme for n0kmo.com, styled after the LCARS website templates at TheLCARS.com.

== Description ==

N0KMO LCARS gives a WordPress site the look of a Starfleet LCARS console:

* Elbow-framed header and content panels with segmented colour bars.
* An animated data cascade in the header. It stops for visitors who prefer reduced motion.
* Header navigation as rectangular LCARS buttons, with a toggle on small screens.
* A "Side frame panels" menu shown as the column of panels in the page frame, alongside the header buttons.
* The frame can sit on the left or the right of the page, mirrored with the same look.
* A live UTC clock and TNG-style stardates in the header and on posts.
* Four colour schemes: Classic, Nemesis Blue, Lower Decks and Red Alert.
* A slashed zero in the banner, so a callsign such as N0KMO does not read as NOKMO.
* Optional LCARS chirps on button presses, synthesised in the browser with no audio files.
* Sidebar and footer widget areas, threaded comments, a full-width template and a custom logo.
* Block editor styles and an LCARS colour palette, plus block styles (LCARS Panel button, LCARS Text Bar heading, LCARS Bar separator, LCARS Frame group, LCARS List) and patterns.
* Elementor support: Canvas and Full Width templates, Hide Title, full-width layouts and Elementor Pro Theme Builder locations (header, footer, single, archive).

Star Trek and LCARS are trademarks of CBS Studios Inc. This theme is an unofficial fan work and is not affiliated with or endorsed by CBS Studios, Paramount or TheLCARS.com.

== Installation ==

1. In the WordPress admin, go to Appearance > Themes > Add New > Upload Theme.
2. Upload the theme zip and activate it.
3. Go to Appearance > Menus and assign menus to "Header buttons", "Side frame panels" and "Footer".
4. Go to Appearance > Customize > LCARS Interface to choose a colour scheme and the header readouts.

== Frequently Asked Questions ==

= How many header buttons fit? =

The header shows top-level items only. On wide screens, up to four items sit in two columns, five or six in three columns and seven or more in four columns; tablets use at most three columns and phones two. Put deeper navigation in the "Side frame panels" menu, which shows one level of sub-items.

= Can the frame go on the right? =

Yes. Under Appearance > Customize > LCARS Interface, set "Frame side" to Right. The frame column, its elbows, the bars and the side panel menu move to the right, and the panel labels, banner and header buttons flip with them. The sidebar widget area moves to the left. Content still reads left to right.

= What if no menus are assigned? =

The header buttons list the home page and the top-level pages, and the side column shows decorative numbered panels.

= How are stardates calculated? =

The theme uses a common fan convention: 1987, the year The Next Generation premiered, is stardate 41000, and each calendar year adds 1000.

= Does it work with Elementor? =

Yes, with Elementor and Elementor Pro:

* Elementor Canvas shows a blank page in the theme's colours and font. Elementor Full Width keeps the LCARS frame and gives the layout the whole content area, with no sidebar.
* On the default page template, Elementor layouts use the full content width and the sidebar stays.
* The "Hide Title" page setting hides the text bar and the title.
* Elementor Pro Theme Builder templates can replace the header (the LCARS top frame), the footer (inside the frame), and single and archive content, which also hides the sidebar.
* Stretched sections stretch to the content area rather than the window, so they don't cover the side column.
* When the theme is activated, it switches off Elementor's default colours and fonts, unless you have already set them, so widgets pick up the LCARS colours and Antonio. You can switch them back on in Elementor's settings.
* Add lcars-heading-bar (Heading), lcars-panel-button (Button) or lcars-frame (Container, Section or Column) under Advanced > CSS Classes for the LCARS text bar, panel button and elbow frame.

= Can I turn off the animation, clock or sounds? =

Yes. Each one has a checkbox under Appearance > Customize > LCARS Interface. Sounds are off by default.

== Changelog ==

= 1.2.0 =
* New "Frame side" option: the LCARS frame, its elbows and the side panel menu can sit on the left or the right of the page.
* The "Side panels" menu location is now labelled "Side frame panels". Menus already assigned to it stay assigned.
* Menu colours and column counts no longer shift in the Customizer preview.

= 1.1.0 =
* Elementor and Elementor Pro support: Theme Builder header, footer, single and archive locations; Canvas and Full Width templates; Hide Title; full-width Elementor layouts; stretched sections kept inside the frame; LCARS defaults for Elementor buttons; lcars-heading-bar, lcars-panel-button and lcars-frame helper classes.
* The bottom bar now reserves the space under its inner curve, so any footer clears it.

= 1.0.0 =
* Initial release.

== Copyright ==

N0KMO LCARS WordPress Theme, Copyright 2026 N0KMO.
N0KMO LCARS is distributed under the terms of the GNU GPL v2 or later.

This program is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 2 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

This theme bundles the following third-party resources:

Antonio font
Copyright 2013 The Antonio Project Authors (https://github.com/googlefonts/antonioFont)
License: SIL Open Font License, Version 1.1 (assets/fonts/antonio/OFL.txt)
Source: https://fontsource.org/fonts/antonio

The layout, colour names and overall look follow the LCARS website templates at https://www.thelcars.com/. The theme's code is an original implementation and contains no files from TheLCARS.com.

screenshot.png was captured from the theme itself. Its sample images were drawn for this theme and are released under the same licence as the theme.
