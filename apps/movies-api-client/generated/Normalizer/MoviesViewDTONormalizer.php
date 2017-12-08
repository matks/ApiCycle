<?php

namespace ApiCycle\Generated\ApiMoviesClient\Normalizer;

use Joli\Jane\Runtime\Reference;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
class MoviesViewDTONormalizer implements DenormalizerInterface, NormalizerInterface, DenormalizerAwareInterface, NormalizerAwareInterface
{
    use DenormalizerAwareTrait;
    use NormalizerAwareTrait;
    public function supportsDenormalization($data, $type, $format = null)
    {
        if ($type !== 'ApiCycle\\Generated\\ApiMoviesClient\\Model\\MoviesViewDTO') {
            return false;
        }
        return true;
    }
    public function supportsNormalization($data, $format = null)
    {
        if ($data instanceof \ApiCycle\Generated\ApiMoviesClient\Model\MoviesViewDTO) {
            return true;
        }
        return false;
    }
    public function denormalize($data, $class, $format = null, array $context = array())
    {
        if (!is_object($data)) {
            throw new InvalidArgumentException();
        }
        $object = new \ApiCycle\Generated\ApiMoviesClient\Model\MoviesViewDTO();
        if (property_exists($data, 'total')) {
            $object->setTotal($data->{'total'});
        }
        if (property_exists($data, 'count')) {
            $object->setCount($data->{'count'});
        }
        if (property_exists($data, 'data')) {
            $values = array();
            foreach ($data->{'data'} as $value) {
                $values[] = $value;
            }
            $object->setData($values);
        }
        return $object;
    }
    public function normalize($object, $format = null, array $context = array())
    {
        $data = new \stdClass();
        if (null !== $object->getTotal()) {
            $data->{'total'} = $object->getTotal();
        }
        if (null !== $object->getCount()) {
            $data->{'count'} = $object->getCount();
        }
        if (null !== $object->getData()) {
            $values = array();
            foreach ($object->getData() as $value) {
                $values[] = $value;
            }
            $data->{'data'} = $values;
        }
        return $data;
    }
}