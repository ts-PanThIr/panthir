<?php

namespace Panthir\Application\UseCase\Customer\Normalizer;

use Panthir\Application\UseCase\Customer\CustomerSearchHandler;
use Panthir\Domain\Customer\Model\Customer;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class CustomerSearchNormalizer implements NormalizerInterface
{
    /**
     * @param Customer $object
     * @param string|null $format
     * @param array $context
     * @return array
     */
    public function normalize(mixed $object, string $format = null, array $context = [])
    {
        if(empty($object)) return [];

        /**
         * @var $r Customer
         */
        $arr = [];
        foreach ($object as $r) {
            $arr[] = [
                'name' => $r->name,
                'id' => $r->id,
                'surname' => $r->surname,
                'document' => $r->document,
                'secondaryDocument' => $r->secondaryDocument,
                'birthDate' => $r->getBirthDate()
            ];
        }

        return $arr;
    }

    public function supportsNormalization(mixed $data, string $format = null)
    {
        return is_array($data) && CustomerSearchHandler::class === $format;
    }
}