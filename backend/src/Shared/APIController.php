<?php

namespace App\Shared;

use App\Shared\Notify\NotifyInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

abstract class APIController extends AbstractController
{
    /**
     * @param NotifyInterface $notify
     * @param SerializerInterface $serializer
     * @param LoggerInterface $logger
     */
    public function __construct(
        protected readonly NotifyInterface     $notify,
        protected readonly SerializerInterface $serializer,
        protected readonly LoggerInterface     $logger
    ){}

    /**
     * @param mixed $items
     * @param array|null $groups
     * @return JsonResponse
     */
    protected function response(mixed $items, ?array $groups = []): JsonResponse
    {
        if (is_array($items) && empty($items)){
            $this->notify->addMessage($this->notify::ERROR, "No data found.");
        }
        try {
            $json = $this->serializer->serialize($items, "json", [
                'groups' => $groups,
                AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object) {
                    return $object->getId();
                },
                AbstractObjectNormalizer::SKIP_NULL_VALUES => true
            ]);
            $returnable = $this->notify->newReturn($json);
        } catch (\Exception $exception) {
            $this->logger->error($exception->getMessage());
            $this->notify->addMessage($this->notify::ERROR, "System failure. Can't serialize object");
            $returnable = $this->notify->newReturn("Error");
        }
        return JsonResponse::fromJsonString(
            $returnable, 200, array('Symfony-Debug-Toolbar-Replace' => 1)
        );
    }

    /**
     * @param Request $request
     * @return array|null
     */
    protected function requestToArray(Request $request): ?array
    {
        $post = json_decode($request->getContent(), true);
        $get = $request->query->all();
        $data = array_merge((array)$post, (array)$get);

        return array_merge($data, $request->query->all());
    }
}
