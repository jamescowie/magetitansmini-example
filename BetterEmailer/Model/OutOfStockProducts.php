<?php namespace MageTitans\BetterEmailer\Model;

class OutOfStockProducts
{
    public function getOutOfStockProducts()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();

        $productCollection = $objectManager->create('Magento\Catalog\Model\ResourceModel\Product\CollectionFactory');

        $collection = $productCollection->create()
            ->addAttributeToSelect('*')
            ->addAttributeToFilter('stock_status', 0)
            ->load();

        $productHtml = '';

        foreach ($collection as $product) {
            $productHtml .= '<p>' . $product->getName() . '</p>';
        }

        return $productHtml;
    }
}
