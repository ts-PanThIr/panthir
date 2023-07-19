<?php

namespace Panthir\Application\UseCase\Supplier\Normalizer;

use Panthir\Application\UseCase\Supplier\SupplierSearchHandler;
use Panthir\Domain\Supplier\Model\Supplier;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class SupplierSearchIdNormalizer implements NormalizerInterface, NormalizerAwareInterface
{
    use NormalizerAwareTrait;

    /**
     * @param Supplier $object
     * @param string|null $format
     * @param array $context
     * @return array
     * @throws ExceptionInterface
     */
    public function normalize(mixed $object, string $format = null, array $context = [])
    {
        $addresses = [];
        foreach ($object->addresses as $address) {
            $addresses[] = $this->normalizer->normalize($address, $format, $context);
        }

        $contacts = [];
        foreach ($object->contacts as $contact) {
            $contacts[] = $this->normalizer->normalize($contact, $format, $context);
        }

        return [
            'id' => $object->id,
            'name' => $object->name,
            'nickName' => $object->nickName,
            'document' => $object->document,
            'secondaryDocument' => $object->secondaryDocument,
            'additionalInformation' => $object->additionalInformation,
            'addresses' => $addresses,
            'contacts' => $contacts
        ];
    }

    public function supportsNormalization(mixed $data, string $format = null)
    {
        return $data instanceof Supplier && SupplierSearchHandler::class === $format;
    }
}
