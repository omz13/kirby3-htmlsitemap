# Kirby3 htmlsitemap

 ![License](https://img.shields.io/github/license/mashape/apistatus.svg) ![Kirby Version](https://img.shields.io/badge/Kirby-3%2B-black.svg) [![Issues](https://img.shields.io/github/issues/omz13/kirby3-htmlsitemap.svg)](https://github.com/omz13/kirby3-htmlsitemap/issues)

**Requirement:** Kirby 3

## Documentation

### Purpose

For a kirby3 site, this plugin (_omz13/htmlsitemap_) generates a human-facing html-based sitemap at '/sitemap'.

- Generates an html-based sitemap as a structured unordered list (`<ul>`).
- Pages or their children can be excluded based in the following criteria, and in the following priority:
  - The homepage is always included.
  - The error page is always excluded; who wants to see the error page?
  - Only pages that have a status of "published" are included, i.e. those with "draft" or "unpublished" are excluded.
  - Unpublished pages can be explicitly included based on their slugname; c.f. `includeUnlistedWhenSlugIs` in _Configuration_.
  - Pages made using certain templates can be excluded; c.f. `excludePageWhenTemplateIs` in _Configuration_.
  - Pages with certain slugnames can be excluded; c.f. `excludePageWhenSlugIs` in _Configuration_.
  - Pages with a content field `excludefromhtmlsitemap` that is `true` are excluded.
  - Pages with a method `issunset` that returns `true` are excluded.
  - Pages with a method `isunderembargo` that returns `true` are excluded.
  - The children of pages made using certain templates can be excluded; c.f. `excludeChildrenWhenTemplateIs` in _Configuration_.
  - The children of pages made using certain templates can be included as anchored links to their parent; c.f. `linkyChildrenWhenTemplateIs` in _Configuration_.
- For debugging purposes, the generated html sitemap can include additional information as html comments; c.f. `debugqueryvalue` in _Configuration_.

_In the current proof-of-concept, the sitemap is a presented as a simple unordered list: it is envisioned that this will be transformed into something with more aesthetics through css._

#### Related

For a computer-oriented xml-based sitemp, kindly see [omz13/kirby3-xmlsitemap](https://github.com/omz13/kirby3-xmlsitemap).

For a plugin that provides the methods `issunset` and `isunderembargo`, kindly see [omz13/kirby3-suncyclepages](https://github.com/omz13/kirby3-suncyclepages).

#### Caveat

Kirby3 is under beta, therefore this plugin, and indeed kirby3 itself, may or may not play nicely with each other, or indeed work at all: use it for testing purposes only; if you use it in production then you should be aware of the risks and know what you are doing.

#### Roadmap

For 1.0, the non-binding list of planned features and implementation notes are:

- [x] MVP
- [x] Debugging option
- [x] Respect page status
- [x] Allow specific unlisted pages to be included c.f. `includeUnlistedWhenSlugIs`
- [x] Exclusion of pages by template – c.f. `excludePageWhenTemplateIs`
- [x] Exclusion of individual pages – c.f. `excludePageWhenSlugIs`
- [x] Exclude embargoed pages
- [x] Exclude sunset pages
- [x] One-pager support c.f. `excludeChildrenWhenTemplateIs` and `linkyChildrenWhenTemplateIs`
- [ ] If the site has content at '/sitemap', do not hijack
- [ ] Provide tags/snippets to include a html sitemap
- [ ] Allow configuration of sitemap `<div>` and `class` attributes.
- [ ] Consider style using [slickmap](https://github.com/astuteo/slickmap)
- [ ] Consider style using [Pure CSS Tree Menu](https://codepen.io/bisserof/pen/fdtBm)
- [ ] Consider style using [CSS to create a simple tree structure with connecting lines](https://gist.github.com/dylancwood/7368914)
- [ ] Consider style using [Nested Folders](https://codepen.io/achudars/pen/cAsEJ)
- [ ] Cache (DoS mitigation)
- [ ] Automate GitHub release – [gothub](https://github.com/itchio/gothub)? [github-release-notes](https://github.com/github-tools/github-release-notes)?

### Installation

#### via composer

If your kirby3-based site is managed using-composer, simply invoke `composer require omz13/kirby3-htmlsitemap`, or add `omz13/kirby3-htmlsitemap` to the "require" component of your site's `composer.json` as necessary, e.g. to be on the bleeding-edge:

```yaml
"require": {
  ...
  "omz13/kirby3-htmlsitemap": "dev-master as 1.0.0",
  ...
}
```
#### via git

Clone github.com/omz13/kirby3-xmlsitemap into your `site/plugins` and then in `site/plugins/kirby3-htmlsitemap` invoke ``composer update --no-dev`` to generate the `vendor` folder and the magic within.

```sh
$ git clone github.com/omz13/kirby3-htmlsitemap site/plugins/kirby3-htmlsitemap
$ cd site/plugins/kirby3-htmlsitemap
$ composer update --no-dev
```

If your project itself is under git, then you need to add the plugin as a submodule and possibly automate the composer update; it is assumed if you are doing this that you know what to do.

### Configuration

The following mechanisms can be used to modify the plugin's behaviour.

#### via `config.php`

In your site's `site/config/config.php` the following entries under the key `omz13.xmlsitemap` can be used:

- `disable` : a boolean which, if true, to disable the xmlsitemap functionality (c.f. `xmlsitemap` in _via `site.txt`_).
- `debugqueryvalue` : a string to be as the value for the query parameter `debug` to return the sitemap page with debugging information (embedded as html comments). The global kirby `debug` configuration must also be true for this to work. The url must be to `/sitemap.xml?debug=debugqueryvalue` and not `/sitemap?debug=_debugqueryvalue_` (i.e. the `.xls` part is important). Be aware that the debugging information will show, if applicable, details of any pages that have been excluded (so if you are using this in production and you don't want things to leak, set `debugqueryvalue` to something random). Furthermore, the site debug flag needs to be set too (i.e. the `debug` flag in `site/config.php`).
- !!! `includeUnlistedWhenSlugIs` : an array of slugnames whose pages are to be included if their status is unlisted.
- `excludePageWhenTemplateIs` : an array of templates names whose pages are to be excluded from the xml-sitemap.
- `excludePageWhenSlugIs` : an array of slug names whose pages are to be excluded from the xml-sitemap.
- `excludeChildrenWhenTemplateIs` : an array of templates names whose children are to be ignored (but pages associated with the template is to be included); this is used for one-pagers (where the principal page will be included and all the 'virtual' children ignored).
- `linkyChildrenWhenTemplateIs` : an array of templates names whose children are to be included as anchored links to their parent; this is used for one-pagers (where the principal page will be included and all the 'virtual' children need their own entry in the sitemap). Note that it is your responsibility to ensure that the anchor names are generated by the templates for the child pages.

For example, for the [Kirby Starter Kit](https://github.com/k-next/starterkit), the following would be applicable:

```php
<?php

return [
  'omz13.htmlsitemap' => [
    'debugqueryvalue' => false,
    'excludePageWhenTemplateIs' => array('sandbox'),
    'excludePageWhenSlugIs' => [ 'form','contact' ],
    'excludeChildrenWhenTemplateIs' => array('events','one-pager','shop','testimonials'),
    'linkyChildrenWhenTemplateIs' => array('team')
  ],
];
```

And to have a debugged sitemap returned  at `/sitemap?debug=wombat`, it would be:

```php
<?php

return [
  'debug'  => true,

  'omz13.htmlsitemap' => [
    'debugqueryvalue' => 'aardvark',
    'excludePageWhenTemplateIs' => array('sandbox'),
    'excludePageWhenSlugIs' => [ 'form','contact' ],
    'excludeChildrenWhenTemplateIs' => array('events','one-pager','shop','testimonials'),
    'linkyChildrenWhenTemplateIs' => array('team')
  ],
];
```

#### via content fields

If a page's content has a field called `excludefromxmlsitemap` and this is set to `true`, then that page (and any children, if present) will be excluded. Similarly to `site.txt`, this can be easily achieved in a blueprint.

```yaml
type:          fields
fields:
  excludefromhtmlsitemap:
    label:     Exclude from sitemap
    type:      toggle
    default:   off
    text:
      - include implicitly
      - explicitly exclude
```

As pages are implicitly included within a sitemap, this mechanism should only be used when you have a reason to explcitly exclude a page when it is not possible to do otherwise (c.f. `excludePageWhenTemplateIs`).

## Disclaimer

This plugin is provided "as is" with no guarantee. Use it at your own risk and always test it yourself before using it in a production environment. If you find any issues, please [create a new issue](https://github.com/omz13/kirby3-htmlsitemap/issues/new).

## License

[MIT](https://opensource.org/licenses/MIT)

You are prohibited from using this plugin in any project that promotes racism, sexism, homophobia, animal abuse, violence or any other form of hate speech.

### Buy Me A Coffee

To show your support for this project you are welcome to [buy me a coffee](https://buymeacoff.ee/omz13).

<!-- If you are using this plugin on a kirby3 site that has a Personal licence, to show your support for this project you are welcome to [buy me a coffee](https://buymeacoff.ee/omz13).

If you are using this plugin with a kirby3 site that has a Pro licence, to show your support for this project you are greatly encouraged to [buy me a coffee](https://buymeacoff.ee/omz13).
-->
