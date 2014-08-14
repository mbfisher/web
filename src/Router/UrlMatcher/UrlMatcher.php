<?php

namespace mbfisher\Web\Router\UrlMatcher;

class UrlMatcher implements UrlMatcherInterface
{
    public function match($template, $path)
    {
        $pattern = preg_replace(
            [
                '/\{(\w+)\}/',
                '/\*/'
            ],
            [
                '(?<$1>[^/]+)',
                '.*'
            ],
            $template
        );

        if (preg_match("|^$pattern$|i", $path, $match)) {
            $args = array_filter(array_keys($match), 'is_string');
            return array_intersect_key($match, array_flip($args));
        } else {
            return false;
        }
    }
}
