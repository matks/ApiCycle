<?php

namespace ApiCycle\Generated\ApiMoviesClient\Normalizer;

class NormalizerFactory
{
    public static function create()
    {
        $normalizers = array();
        $normalizers[] = new \Symfony\Component\Serializer\Normalizer\ArrayDenormalizer();
        $normalizers[] = new BadQueryResponseNormalizer();
        $normalizers[] = new BadResponseNormalizer();
        $normalizers[] = new MovieDTONormalizer();
        $normalizers[] = new MoviesViewDTONormalizer();
        $normalizers[] = new SuccessResponseNormalizer();
        $normalizers[] = new MoviesPostBodyNormalizer();
        return $normalizers;
    }
}