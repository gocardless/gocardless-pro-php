<?php

namespace GoCardlessPro\Core;

abstract class Util
{
    /**
     * Replace URL tokens with the substitution mapping to generate urls.
     *
     * For example:
     *
     *     subUrl("/stats_for/:id", array("id" => "foo")) => "/stats_for/foo"
     *
     * @param string $url           Url to substitute
     * @param array  $substitutions Substitutions to make
     *
     * @return string the generated URL
     */
    public static function subUrl($url, $substitutions)
    {
        foreach ($substitutions as $substitution_key => $substitution_value) {
            if (!is_string($substitution_value)) {
                $error_type = ' needs to be a string, not a ' . gettype($substitution_value) . '.';
                throw new \Exception('URL value for ' . $substitution_key . $error_type);
            }
            $url = str_replace(
                ':' . $substitution_key,
                self::escapeUrlParam($substitution_key, $substitution_value),
                $url
            );
        }
        return $url;
    }

    /**
     * Escape a value before it is interpolated into a request path.
     *
     * A URL parameter is a single path segment, so values that could move the request to a
     * different endpoint - path separators, control characters, '.', '..' (escaping can't make
     * these safe - a resolver strips them regardless), and empty values - are rejected instead.
     *
     * @param string $key   Name of the URL parameter, used for error messages
     * @param string $value Value to escape
     *
     * @return string the escaped value
     */
    private static function escapeUrlParam($key, $value)
    {
        if ($value === '') {
            throw new \Exception('No value provided for URL parameter ' . $key . '.');
        }

        if ($value === '.' || $value === '..') {
            throw new \Exception(
                'Invalid value for URL parameter ' . $key . ': \'' . $value . '\' would change ' .
                'which endpoint the request is sent to.'
            );
        }

        if (preg_match('/[\/?#\x00-\x1F\x7F]/', $value) === 1) {
            throw new \Exception(
                'Invalid value for URL parameter ' . $key . ': \'' . $value . '\' contains a ' .
                'character that is not allowed in a path segment.'
            );
        }

        return rawurlencode($value);
    }
}
