<?php

namespace ApiCycle\Generated\ApiMoviesClient\Normalizer;

class NormalizerFactory
{
    public static function create()
    {
        $normalizers = array();
        $normalizers[] = new \Joli\Jane\Runtime\Normalizer\ArrayDenormalizer();
        return $normalizers;
    }
}