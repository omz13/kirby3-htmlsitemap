<?php

Kirby::plugin('omz13/htmlsitemap', [
//  'options' => [
//      'disable' => false,
//      'includeUnlistedWhenSlugIs' => [],
//      'excludePageWhenTemplateIs' => [],
//      'excludeChildrenWhenTemplateIs' => [],
//      'linkyChildrenWhenTemplateIs' => [],
//      'excludePageWhenSlugIs' => [],
//  ],

  'routes' => [
    [
      'pattern' => 'sitemap',
      'action' => function () {
        $dqv=omz13\HTMLSitemap::getConfigurationForKey('debugqueryvalue');
        $dodebug = isset($dqv) && $dqv == get('debug');
        return new Kirby\Cms\Response(omz13\htmlsitemap::getSitemap(kirby()->site()->pages(), $dodebug), "text/html", 200, ["X-OMZ13" =>"htmlsitemap"]);
      }
    ]

//    [
//      'pattern' => 'sitemap.css',
//      'action' => function () {
//          return new Kirby\Cms\Response(omz13\htmlsitemap::getStylesheet(), "text/css");
//      }
//    ]

  ],
]);

require_once __DIR__ . '/htmlsitemap.php';
