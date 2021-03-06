# Class AllowClient
```php
@package vipnytt\RobotsTxtParser\Client\Directives
```

### Directives:
- [Allow](../Directives.md#allow)
- [Disallow](../Directives.md#disallow)
- [NoIndex](../Directives.md#noindex)

## Public functions
- [cleanParam](#cleanparam)
- [export](#export)
- [host](#host)
- [isListed](#isListed)

### cleanParam
```php
@return CleanParamClient
```
Wrapper for the inline [CleanParam](../Directives.md#cleanparam) directive.

Returns an instance of [CleanParamClient](CleanParamClient.md).

### export
```php
@return array
```
Export an array of the current directives rules.

### host
```php
@return HostInlineClient
```
Wrapper for the inline [Host](../Directives.md#host) directive.

Returns an instance of [HostInlineClient](Hostinlineclient.md).

### isListed
```php
@param  string $uri
@return bool
```
Check if the URI's path is listed in the current directive
