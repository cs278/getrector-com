<?php

declare(strict_types=1);

namespace Rector\Website\Utils\Rector\NodeFactory;

use PhpParser\Node\Arg;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\ClassConstFetch;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Name\FullyQualified;
use PhpParser\Node\Scalar\String_;
use Rector\Website\Utils\Rector\ValueObject\ValueObject\RouteMetadata;

final class RouteGetCallFactory
{
    public function create(RouteMetadata $routeMetadata): Expr
    {
        $args = [];
        $args[] = new Arg(new String_($routeMetadata->getRoutePath()));
        $args[] = new Arg(new ClassConstFetch(new FullyQualified($routeMetadata->getRouteTarget()), 'class'));

        $getStaticCall = new StaticCall(new FullyQualified('Illuminate\Support\Facades\Route'), 'get', $args);

        if ($routeMetadata->getRouteName()) {
            return new MethodCall($getStaticCall, 'name', [new Arg(new String_($routeMetadata->getRouteName()))]);
        }

        return $getStaticCall;
    }
}
