<?php

namespace App\Traits;

use App\Classes\Enum\CompanyTypeEnum;

trait ProjectTotalPrice
{

    /**
     * Get the total price product in project
     *
     * @return array
     */
    public function totalPrice(): array
    {
        $sumENBLUE = 0;
        $sumTERAS = 0;

        if (!empty($this->company) && $this->projectProducts->count() > 0) {
            $priceShippingFee = 0;
            $quantityShippingFee = 0;
            $purchasePriceShippingFee = 0;

            if ($this->projectProductShippingFees->count() > 0) {
                $priceShippingFee = (int)$this->projectProductShippingFees->first()->price;
                $quantityShippingFee = (int)$this->projectProductShippingFees->first()->quantity;
                $purchasePriceShippingFee = (int)$this->projectProductShippingFees->first()->purchase_price;
            }
            $totalPriceShippingFee = $priceShippingFee * $quantityShippingFee;
            $totalPurchasePriceShippingFee = $purchasePriceShippingFee * $quantityShippingFee;
            $totalEnblueShippingFee = ($totalPriceShippingFee - $totalPurchasePriceShippingFee) / 2 + $totalPurchasePriceShippingFee;

            foreach ($this->projectProducts as $key => $projectProduct) {
                $productSpecifications = $projectProduct->getProductSpecifications();
                $price = $productSpecifications['price'];
                $quantity = $productSpecifications['quantity'];

                $totalEstProduct = $price * $quantity;

                if ($this->company->getCompanyTypeEnblue()) {
                    $sumENBLUE += $totalEstProduct;

                    $sumEnblueStatistical = $projectProduct->Enblue_purchase;
                    $sumTERAS += $sumEnblueStatistical;
                } else if ($this->company->getCompanyTypeTerrace()) {
                    $sumTERAS += $totalEstProduct;
                } else if ($this->company->getCompanyTypeEnblueAlone()) {
                    $sumENBLUE = $sumENBLUE + $totalEstProduct;
                }
            }
        }
        if ($sumENBLUE != 0) {
            $sumENBLUE+=$totalPriceShippingFee;
        }

        if ($sumTERAS != 0) {
            if ($this->company->getCompanyTypeTerrace()) {
                $sumTERAS+=$totalPriceShippingFee;
            } else {
                $sumTERAS+=$totalEnblueShippingFee;
            }
        }

        return [$sumENBLUE*1.1, $sumTERAS*1.1];
    }
}
