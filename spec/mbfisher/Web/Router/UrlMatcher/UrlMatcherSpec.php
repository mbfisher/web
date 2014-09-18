<?php

namespace spec\mbfisher\Web\Router\UrlMatcher;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UrlMatcherSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('mbfisher\Web\Router\UrlMatcher\UrlMatcher');
    }

    function it_matches_a_plain_pattern()
    {
        $this->match('/foo', '/foo')->shouldReturn([]);
    }
}
