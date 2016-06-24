<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Ibnab\CustomAttribute\Setup;
use Magento\Framework\Module\Setup\Migration;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Catalog\Setup\CategorySetupFactory;
 
/**
 * @codeCoverageIgnore
 */
class InstallData implements InstallDataInterface
{
    /**
     * Category setup factory
     *
     * @var CategorySetupFactory
     */
    private $categorySetupFactory;
 
    /**
     * Init
     *
     * @param CategorySetupFactory $categorySetupFactory
     */
    public function __construct(CategorySetupFactory $categorySetupFactory)
    {
        $this->categorySetupFactory = $categorySetupFactory;
    }
    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
         $installer->startSetup();
 
        $categorySetup = $this->categorySetupFactory->create(['setup' => $setup]);
        $entityTypeId = $categorySetup->getEntityTypeId(\Magento\Catalog\Model\Category::ENTITY);
        $attributeSetId = $categorySetup->getDefaultAttributeSetId($entityTypeId);
         $categorySetup->removeAttribute(
        \Magento\Catalog\Model\Category::ENTITY, 'my_attribute');
        $categorySetup->addAttribute(
        \Magento\Catalog\Model\Category::ENTITY, 'my_attribute', [
             'type' => 'int',
             'label' => 'My Atrribute ',
             'input' => 'select',
             'source' => 'Magento\Eav\Model\Entity\Attribute\Source\Boolean',
             'required' => false,
             'sort_order' => 100,
             'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
             'group' => 'General Information',
        ]
    );
    $idg =  $categorySetup->getAttributeGroupId($entityTypeId, $attributeSetId, 'General Information');
    $categorySetup->addAttributeToGroup(
        $entityTypeId,
        $attributeSetId,
        $idg,
        'my_attribute',
        46
    );
$installer->endSetup();
    }
}
