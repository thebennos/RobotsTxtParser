# Robots.txt Cache
By caching data to the SQL server, overall performance is increased, you'll limit the number of network lags and timeouts to a bare minimum, and last but not least, no more spamming of the remote host.

It's common practice to cache the `robots.txt` for up to 24 hours.

#### Shared-setup compatible
Multiple crawlers may with benefits share the same database.

### Requirements:
- MySQL

The library is built with cross-system in mind, and everything is set for additional database support. Just [submit an issue](https://github.com/VIPnytt/RobotsTxtParser/issues) and we'll see what we can do about it.

## Usage
```php
$handler = new RobotsTxtParser\Cache($pdo);
$client = $handler->client('http://example.com');
```

See the [Cache class documentation](../methods/Cache.md) for more information and additional available methods.

#### Cron job
Recommended, but not required.

Automates the `robots.txt` cache update process, and makes sure the cache stays up to date. Faster client, less overhead.
```php
$handler = new RobotsTxtParser\Cache($pdo);
$handler->cron();
```

#### Table maintenance
Clean old data:
```php
$handler = new RobotsTxtParser\Cache($pdo);
$handler->clean();
```

Internal tests is showing that 10.000 cached `robots.txt` files, only takes up about 5 Megabytes in the database.

## Issues
In case of problems, please [submit an issue](https://github.com/VIPnytt/RobotsTxtParser/issues).

## Setup instructions
Run this `SQL` script:
```SQL
CREATE TABLE `robotstxt__cache1` (
  `base`       VARCHAR(269)
               CHARACTER SET ascii
               COLLATE ascii_bin           NOT NULL,
  `content`    MEDIUMTEXT COLLATE utf8_bin NOT NULL,
  `statusCode` SMALLINT(3) UNSIGNED DEFAULT NULL,
  `validUntil` INT(10) UNSIGNED            NOT NULL,
  `nextUpdate` INT(10) UNSIGNED            NOT NULL,
  `effective`  VARCHAR(269)
               CHARACTER SET ascii
               COLLATE ascii_bin    DEFAULT NULL,
  `worker`     TINYINT(3) UNSIGNED  DEFAULT NULL,
  PRIMARY KEY (`base`),
  KEY `worker` (`worker`, `nextUpdate`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_bin
```
Source: [/res/Cache/MySQL.sql](https://github.com/VIPnytt/RobotsTxtParser/blob/master/res/Cache/MySQL.sql)

#### Security
For the sake of security, it is recommended to use a dedicated user with a bare minimum of permissions:

- `robotstxt__cache1`
  - `SELECT`
  - `INSERT`
  - `UPDATE`
  - `DELETE`

#### Table version history
- `robotstxt__cache1` - [2.0 beta](https://github.com/VIPnytt/RobotsTxtParser/releases/tag/v2.0.0-beta.1) >>> [latest](https://github.com/VIPnytt/RobotsTxtParser/releases)
- `robotstxt__cache0` - [2.0 alpha](https://github.com/VIPnytt/RobotsTxtParser/releases/tag/v2.0.0-alpha.1)
