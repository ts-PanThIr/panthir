<?php

namespace App\Financial\Controller;

use App\Financial\DTO\FinancialPaymentConditionDTO;
use App\Financial\Entity\PaymentConditionFinancialEntity;
use App\Financial\Repository\PaymentConditionFinancialRepository;
use App\Shared\ApiController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/api/financial/payment-condition')]
class FinancialPaymentConditionGetAllController extends ApiController
{
    #[Route(path: "/", name: "app_financial_payment_condition_get_all", methods: 'GET')]
    public function get(
        EntityManagerInterface $entityManager
    ): JsonResponse
    {
        /** @var PaymentConditionFinancialRepository $condition */
        $condition = $entityManager->getRepository(PaymentConditionFinancialEntity::class)->findAll();

        $conditionDTO = FinancialPaymentConditionDTO::transformFromObjects($condition);

        return $this->response(items: $conditionDTO, groups: ['financial']);
    }
}
