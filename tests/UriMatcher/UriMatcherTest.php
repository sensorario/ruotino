<?php

namespace App\Tests\UriMatcher;

use App\UriMatcher\UriMatcher;
use PHPUnit\Framework\TestCase;

class UriMatcherTest extends TestCase
{
    /**
     * @test
     * @dataProvider provider
     **/
    public function check($path, $currentUrl, $match)
    {
        $matcher = new UriMatcher($path, $currentUrl);
        $this->assertSame($match, $matcher->match());
    }

    public function provider()
    {
        return [
            ['/foo/:bar', '/foo/bar', true],
            ['/foo/:bar', '/foo/bar/atro', false],
            ['/foo/:bar/atro', '/foo/bar/atro', true],
            [['/foo/:bar/atro'], '/foo/bar/atro', true],
            [['/foo/:bar/atro'], '/foo/bar/atro/fake', false],
        ];
    }
    /** @test **/
    public function adsfasdfasadasdas()
    {
        $matcher = new UriMatcher([
            '/uno/due/tre',
            '/foo/:bar/atro',
        ], '/foo/bar/atro');

        $this->assertSame(true, $matcher->match());
        $this->assertSame('/foo/:bar/atro', $matcher->getPath());
    }
}