<?php

declare(strict_types=1);

/**
 * Polyfill for spomky-labs/base64url Base64Url class.
 * Solves "Failed to open stream: No such file or directory" when vendor/spomky-labs/base64url is missing on cPanel / shared hosting.
 */

namespace Base64Url;

use InvalidArgumentException;

if (!class_exists(\Base64Url\Base64Url::class, false)) {
    final class Base64Url
    {
        /**
         * @param string $data       The data to encode
         * @param bool   $usePadding If true, the "=" padding at end of the encoded value are kept, else it is removed
         *
         * @return string The data encoded
         */
        public static function encode(string $data, bool $usePadding = false): string
        {
            $encoded = strtr(base64_encode($data), '+/', '-_');

            return true === $usePadding ? $encoded : rtrim($encoded, '=');
        }

        /**
         * @param string $data The data to decode
         *
         * @throws InvalidArgumentException
         *
         * @return string The data decoded
         */
        public static function decode(string $data): string
        {
            $decoded = base64_decode(strtr($data, '-_', '+/'), true);
            if (false === $decoded) {
                throw new InvalidArgumentException('Invalid data provided');
            }

            return $decoded;
        }
    }
}
