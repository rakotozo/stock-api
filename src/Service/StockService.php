<?php

namespace App\Service;

use App\Entity\Product;
use App\Entity\ProductSupplier;
use App\Enum\MovementType;
use Doctrine\ORM\EntityManagerInterface;

class StockService
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
    }

    /**
     * Calcule le stock disponible pour un fournisseur et un produit.
     */
    public function getStockBySupplier(
        ProductSupplier $productSupplier
    ): int {
        $movements = $productSupplier->getStockMovements();

        $stock = 0;

        foreach ($movements as $movement) {
            $quantity = $movement->getQuantity();

            switch ($movement->getType()) {
                case MovementType::IN:
                    $stock += $quantity;
                    break;

                case MovementType::OUT:
                    $stock -= $quantity;
                    break;

                case MovementType::ADJUSTMENT:
                    $stock += $quantity;
                    break;
            }
        }

        return $stock;
    }

    public function getTotalStock(Product $product): int
    {
        $totalStock = 0;

        foreach ($product->getProductSuppliers() as $productSupplier) {
            $totalStock += $this->getStockBySupplier($productSupplier);
        }

        return $totalStock;
    }
}
