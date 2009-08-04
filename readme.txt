=== Easy Google Syntax Highlighter ===
Contributors: Neil Burlock
Donate link:
Tags: code, google, syntax, highlighter, blog, html
Requires at least:2.0.0
Tested up to: 2.8.3
Stable tag: 1.1.1

An implementation of Alex Gorbachev's Google Syntax Highlighter with a front end to allow configuration.

== Description ==

This plugin is an implementation of the [Google Syntax Highlighter 2.0](http://alexgorbatchev.com/wiki/SyntaxHighlighter) by Alex Gorbatchev with a front end to allow configuring all the global settings that are available, such having the plugin automatically include languages to highlight, thereby improving page loading performance.

= Syntax Supported =

ActionScript3, Bash/shell, C#, C++, CSS, Delphi, Diff,
Groovy, JavaScript, Java, JavaFX, Perl, PHP, Plain Text,
PowerShell, Python, Ruby, Scala, SQL, Visual Basic, XML

= Themes =

Default, Django, Emacs, FadeToGrey, Midnight, RDark

== Frequently Asked Questions ==

<h4>How do I get the best performance out of this plugin?</h4>

<p>* Disable any syntax types that your blog doesn't use, especially if you are only using a few of the syntax brushes.
* If your blog has a footer, you should enable the option to put the brushes in the footer.
* Also, if your blog has a footer, then Enable the automatic feature which will only include the language brushes that are referenced on each page of your blog.
</p>

== Changelog == 

= 1.1.1 =
* Fixed incorrect path for script copy swf file

= 1.1.0 =
* Option to automatically include language brushes that are referenced on the blog page being viewed
* Minor tweaks to allow this plugin to work with wp-minify

= 1.0.0 =
* First version

== Screenshots ==

1. Simple Javascript example

== Installation ==

1. Extract plugin into /wp-content/plugins directory.
2. Activate the plugin.
3. Specify your code snippets in your blog post using the [Usage Directions](http://alexgorbatchev.com/wiki/SyntaxHighlighter:Usage).

This example will highligh the source as Javascript: 

	<pre class="brush:js">
		alert("Hello world");
	</pre>

