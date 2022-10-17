<?php

namespace App\Shared;

use App\Shared\Notify\NotifyInterface;
use PhpParser\Node\Expr\Cast\Object_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

abstract class ApiController extends AbstractController
{
    /**
     * @param NotifyInterface $notify
     * @param SerializerInterface $serializer
     */
    public function __construct(private NotifyInterface $notify, private SerializerInterface $serializer){}

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
                    return $object;
                },
            ]);
            $returnable = $this->notify->newReturn($json);
        } catch (\Exception) {
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

//    /**
//     * @param array $data
//     * @param Object $object
//     * @return Object
//     */
//    protected function arrayToObject(array $data, string $objectName): Object
//    {
////        $entityAsArray = $serializer->normalize($entity, null);
////        $serializer = new Serializer(
////            [new GetSetMethodNormalizer(), new ArrayDenormalizer()],
////            [new JsonEncoder()]
////        );
////
////        return $serializer->deserialize($data, $objectName);
//    }
}