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
            $url = str_replace(':' . $substitution_key, $substitution_value, $url);
        }
        return $url;
    }
}
