<?php

namespace Pyro\MenusModule\Uri;

use League\Uri\Contracts\UriInterface;
use League\Uri\Exceptions\SyntaxError;

class UriValidator
{
    public static function validate(UriInterface $uri): bool
    {
        $scheme = $uri->getScheme();
        if($scheme === 'javascript'){
            return false;
        }
        if (null === $scheme && '' === $uri->getHost()) {
            return false;//throw new SyntaxError(sprintf('an URI without scheme can not contains a empty host string according to PSR-7: %s', (string) $uri));
        }

        $port = $uri->getPort();
        if (null !== $port && ($port < 0 || $port > 65535)) {
            return false; //throw new SyntaxError(sprintf('The URI port is outside the established TCP and UDP port ranges: %s', (string) $uri->getPort()));
        }
        return true;
    }
}
