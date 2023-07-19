<?php

namespace Panthir\Application\UseCase\Customer\Normalizer;

use Panthir\Application\UseCase\Customer\CustomerSearchHandler;
use Panthir\Domain\Customer\Model\Customer;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class CustomerSearchIdNormalizer implements NormalizerInterface, NormalizerAwareInterface
{
    use NormalizerAwareTrait;

    /**
     * @param Customer $object
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
            'surname' => $object->surname,
            'document' => $object->document,
            'secondaryDocument' => $object->secondaryDocument,
            'birthDate' => $object->getBirthDate(),
            'additionalInformation' => $object->additionalInformation,
            'addresses' => $addresses,
            'contacts' => $contacts
        ];
    }

    public function supportsNormalization(mixed $data, string $format = null)
    {
        return $data instanceof Customer && CustomerSearchHandler::class === $format;
    }
}