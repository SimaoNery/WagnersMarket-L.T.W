<?php
declare(strict_types = 1);
class Shipping
{
    public int $shippingFormId;
    public int $sellerId;
    public int $receiverId;
    public string $sellerCountry;
    public string $receiverCountry;
    public string $sellerAddress;
    public string $receiverAddress;
    public string $sellerPostalCode;
    public string $receiverPostalCode;
    public string $timestamp;


    public function __construct(int $shippingFormId, int $sellerId, int $receiverId, string $sellerCountry, string $receiverCountry, string $sellerAddress, string $receiverAddress, string $sellerPostalCode, string $receiverPostalCode, string $timestamp)
    {
        $this->shippingFormId = $shippingFormId;
        $this->sellerId = $sellerId;
        $this->receiverId = $receiverId;
        $this->sellerCountry = $sellerCountry;
        $this->receiverCountry = $receiverCountry;
        $this->sellerAddress = $sellerAddress;
        $this->receiverAddress = $receiverAddress;
        $this->sellerPostalCode = $sellerPostalCode;
        $this->receiverPostalCode = $receiverPostalCode;
        $this->timestamp = $timestamp;
    }


}