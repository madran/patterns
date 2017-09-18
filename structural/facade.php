<?php

class Payment
{
    private $amount;
    
    public function setPaymentMethod() {}
    public function checkout() {}
}

class Product
{
    private $id;
    private $name;
}

class ShopingCart
{
    public function addProduct() {}
    public function changeQuantity() {}
}

class Stock
{
    public function findProduct() {}
    public function getProductsBycategory() {}
}

class Order
{
    public function setProducts() {}
    public function getSummary() {}
}

// Facade
class Shop
{
    private $order;
    private $payment;
    private $stock;
    
    public function __construct()
    {
        $this->stock = new Stock();
        $this->payment = new Payment();
        $this->order = new Order();
    }
    
    public function findProduct()
    {
        $this->stock->findProduct();
    }
    
    public function getProductsBycategory()
    {
        $this->stock->getProductsBycategory();
    }


    public function order(ShopingCart $shopingCart)
    {
        $this->order->setProducts($shopingCart);
        
        return $this->order->getSummary();
    }
    
    public function checkout($paymentMethod)
    {
        $this->payment->setPaymentMethod($paymentMethod);
        $this->payment->checkout();
    }
}