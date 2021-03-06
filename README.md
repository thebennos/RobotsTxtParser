[![Build Status](https://travis-ci.org/VIPnytt/RobotsTxtParser.svg?branch=master)](https://travis-ci.org/VIPnytt/RobotsTxtParser)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/VIPnytt/RobotsTxtParser/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/VIPnytt/RobotsTxtParser/?branch=master)
[![Code Climate](https://codeclimate.com/github/VIPnytt/RobotsTxtParser/badges/gpa.svg)](https://codeclimate.com/github/VIPnytt/RobotsTxtParser)
[![Test Coverage](https://codeclimate.com/github/VIPnytt/RobotsTxtParser/badges/coverage.svg)](https://codeclimate.com/github/VIPnytt/RobotsTxtParser/coverage)
[![License](https://poser.pugx.org/VIPnytt/RobotsTxtParser/license)](https://github.com/VIPnytt/RobotsTxtParser/blob/master/LICENSE)
[![Packagist](https://img.shields.io/packagist/v/vipnytt/robotstxtparser.svg)](https://packagist.org/packages/vipnytt/robotstxtparser)
[![Gitter](https://badges.gitter.im/VIPnytt/RobotsTxtParser.svg)](https://gitter.im/VIPnytt/RobotsTxtParser)

# Robots.txt parser
An easy to use, extensible `robots.txt` parser library with _full_ support for every [directive](#directives) and [specification](#specifications) _on the Internet_.

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/6fb47427-166b-45d0-bd41-40f7a63c2b0c/big.png)](https://insight.sensiolabs.com/projects/6fb47427-166b-45d0-bd41-40f7a63c2b0c)

#### Usage cases:
- Permission checks
- Fetch crawler rules
- Sitemap discovery
- Host preference
- Dynamic URL parameter discovery
- `robots.txt` rendering

### Advantages
_(compared to most other robots.txt libraries)_
- Automatic `robots.txt` download.
- Transparent [Caching system](https://github.com/VIPnytt/RobotsTxtParser/blob/master/docs/sql/cache.md).
- Integrated crawl [Delay handler](https://github.com/VIPnytt/RobotsTxtParser/blob/master/docs/sql/delay.md).
- Fully [documented](https://github.com/VIPnytt/RobotsTxtParser/tree/master/docs).
- Full support for [every single directive](#directives), from [every specification](#specifications).
- HTTP Status code handler, _according to [Google](https://developers.google.com/webmasters/control-crawl-index/docs/robots_txt) spec._
- Dedicated `User-Agent` parser and group determiner library, for maximum accuracy.
- Provides additional data like _preferred host_, dynamic _URL parameters_, _Sitemap_ locations, etc.
- Supported protocols: ``HTTP``, ``HTTPS``, ``FTP``, ``SFTP`` and ``FTP/S``.

#### Requirements:
- PHP [>=5.6](http://php.net/supported-versions.php)
- PHP extensions:
  - [cURL](http://php.net/manual/en/book.curl.php)
  - [mbstring](http://php.net/manual/en/book.mbstring.php)

Note: HHVM support is planned once [facebook/hhvm#4277](https://github.com/facebook/hhvm/issues/4277) is fixed.

## Installation
The recommended way to install the robots.txt parser is through [Composer](http://getcomposer.org). Add this to your `composer.json` file:
```json
{
    "require": {
        "vipnytt/robotstxtparser": "~2.0"
    }
}
```
Then run: ```php composer.phar update```

## Getting started
### Basic usage example
```php
$client = new vipnytt\RobotsTxtParser\UriClient('http://example.com');

if ($client->userAgent('MyBot')->isAllowed('http://example.com/somepage.html')) {
    // Access is granted
}
if ($client->userAgent('MyBot')->isDisallowed('http://example.com/admin')) {
    // Access is denied
}
```
### A small excerpt of basic methods
```php
// Syntax: $baseUri, [$statusCode:int|null], [$robotsTxtContent:string], [$encoding:string], [$byteLimit:int|null]
$client = new vipnytt\RobotsTxtParser\TxtClient('http://example.com', 200, $robotsTxtContent);

// Permission checks
$allowed = $client->userAgent('MyBot')->isAllowed('http://example.com/somepage.html'); // bool
$denied = $client->userAgent('MyBot')->isDisallowed('http://example.com/admin'); // bool

// Crawl delay rules
$crawlDelay = $client->userAgent('MyBot')->crawlDelay()->get(); // float | int

// Dynamic URL parameters
$cleanParam = $client->cleanParam()->export(); // array
$cleanParam = $client->cleanParam()->isListed('http://example.com/somepage/?ref=frontpage'); // bool

// Preferred host
$host = $client->host()->get(); // string | null
$host = $client->host()->isPreferred(); // bool

// XML Sitemap locations
$host = $client->sitemap()->export(); // array
```

The above is just a taste the basics, a whole bunch of more advanced and/or specialized methods are available for almost any purpose. Visit the [cheat-sheet](https://github.com/VIPnytt/RobotsTxtParser/tree/master/docs/CheatSheet.md) for the technical details.

Visit the [Documentation](https://github.com/VIPnytt/RobotsTxtParser/tree/master/docs) for more information.

### Directives
- [x] [`Clean-param`](https://github.com/VIPnytt/RobotsTxtParser/blob/master/docs/Directives.md#clean-param)
- [x] [`Host`](https://github.com/VIPnytt/RobotsTxtParser/blob/master/docs/Directives.md#host)
- [x] [`Sitemap`](https://github.com/VIPnytt/RobotsTxtParser/blob/master/docs/Directives.md#sitemap)
- [x] [`User-agent`](https://github.com/VIPnytt/RobotsTxtParser/blob/master/docs/Directives.md#user-agent)
  - [x] [`Allow`](https://github.com/VIPnytt/RobotsTxtParser/blob/master/docs/Directives.md#allow)
    - [x] _inline_ [`Clean-param`](https://github.com/VIPnytt/RobotsTxtParser/blob/master/docs/Directives.md#inline-clean-param)
    - [x] _inline_ [`Host`](https://github.com/VIPnytt/RobotsTxtParser/blob/master/docs/Directives.md#inline-host)
  - [x] [`Cache-delay`](https://github.com/VIPnytt/RobotsTxtParser/blob/master/docs/Directives.md#cache-delay)
  - [x] [`Comment`](https://github.com/VIPnytt/RobotsTxtParser/blob/master/docs/Directives.md#comment)
  - [x] [`Crawl-delay`](https://github.com/VIPnytt/RobotsTxtParser/blob/master/docs/Directives.md#crawl-delay)
  - [x] [`Disallow`](https://github.com/VIPnytt/RobotsTxtParser/blob/master/docs/Directives.md#disallow)
    - [x] _inline_ [`Clean-param`](https://github.com/VIPnytt/RobotsTxtParser/blob/master/docs/Directives.md#inline-clean-param)
    - [x] _inline_ [`Host`](https://github.com/VIPnytt/RobotsTxtParser/blob/master/docs/Directives.md#inline-host)
  - [x] [`NoIndex`](https://github.com/VIPnytt/RobotsTxtParser/blob/master/docs/Directives.md#noindex)
    - [x] _inline_ [`Clean-param`](https://github.com/VIPnytt/RobotsTxtParser/blob/master/docs/Directives.md#inline-clean-param)
    - [x] _inline_ [`Host`](https://github.com/VIPnytt/RobotsTxtParser/blob/master/docs/Directives.md#inline-host)
  - [x] [`Request-rate`](https://github.com/VIPnytt/RobotsTxtParser/blob/master/docs/Directives.md#request-rate)
  - [x] [`Robot-version`](https://github.com/VIPnytt/RobotsTxtParser/blob/master/docs/Directives.md#robot-version)
  - [x] [`Visit-time`](https://github.com/VIPnytt/RobotsTxtParser/blob/master/docs/Directives.md#visit-time)

## Specifications
- [x] [Google robots.txt specifications](https://developers.google.com/webmasters/control-crawl-index/docs/robots_txt)
- [x] [Yandex robots.txt specifications](https://yandex.com/support/webmaster/controlling-robot/robots-txt.xml)
- [x] [W3C Recommendation HTML 4.01 specification](https://www.w3.org/TR/html4/appendix/notes.html#h-B.4.1.1)
- [x] [Sitemaps.org protocol](http://www.sitemaps.org/protocol.html#submit_robots)
- [x] [Sean Conner: _"An Extended Standard for Robot Exclusion"_](http://www.conman.org/people/spc/robots2.html)
- [x] [Martijn Koster: _"A Method for Web Robots Control"_](http://www.robotstxt.org/norobots-rfc.txt)
- [x] [Martijn Koster: _"A Standard for Robot Exclusion"_](http://www.robotstxt.org/orig.html)
- [x] [RFC 7231](https://tools.ietf.org/html/rfc7231), [~~2616~~](https://tools.ietf.org/html/rfc2616)
- [x] [RFC 7230](https://tools.ietf.org/html/rfc7230), [~~2616~~](https://tools.ietf.org/html/rfc2616)
- [x] [RFC 5322](https://tools.ietf.org/html/rfc5322), [~~2822~~](https://tools.ietf.org/html/rfc2822), [~~822~~](https://tools.ietf.org/html/rfc822)
- [x] [RFC 3986](https://tools.ietf.org/html/rfc3986), [~~1808~~](https://tools.ietf.org/html/rfc3986)
- [x] [RFC 1945](https://tools.ietf.org/html/rfc1945)
- [x] [RFC 1738](https://tools.ietf.org/html/rfc1738)
- [x] [RFC 952](https://tools.ietf.org/html/rfc952)
