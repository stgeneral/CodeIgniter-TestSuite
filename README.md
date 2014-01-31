CodeIgniter TestSuite
=====================

Yet another attempt to test (unit and integration) application build with CodeIgniter.

Most likely this solution won't work for you "out of the box" but may be some ideas will help sombody who like to test app build ontop untestable framework :)

Some key notes
--------------

- overwrites index.php (bootstrap.php) to add `testing` environment
- overwrites CodeIgniter.php to make global varibles really global
- overwrites some core class to eliminate 'exits'
- tests run in `processIsolation` mode only
- wraps requests and resposes (including redirects) into [Symfony HttpFoundation Component](http://symfony.com/doc/current/components/http_foundation/introduction.html)
- each test emulates HTTP request to framework
- each response is testable via Symfony's [DomCrawler](http://symfony.com/doc/current/components/dom_crawler.html) and [CssSelector](http://symfony.com/doc/current/components/css_selector.html) Components


Thanks everyone who shares their code.
Good luck! :)
