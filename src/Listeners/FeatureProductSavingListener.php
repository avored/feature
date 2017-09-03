<?php

namespace Mage2\Feature\Listeners;

use Mage2\Attribute\Models\Attribute;
use Mage2\Attribute\Models\ProductAttributeValue;

class FeatureProductSavingListener
{
    /**
     * Handle the event.
     *
     * @param  mag2 .user.registered  $event
     * @return void
     */
    public function handle($event)
    {
        $product = $event->product;
        $request = $event->request;

        $featuredAttribute = Attribute::whereIdentifier('is_featured')->first();

        if(NULL != $request->get('is_featured')) {

            $attrValueModel = ProductAttributeValue::whereProductId($product->id)->whereAttributeId($featuredAttribute->id)->first();

            if(null == $attrValueModel) {
                ProductAttributeValue::create(['attribute_id' => $featuredAttribute->id,
                                            'product_id' => $product->id,
                                            'value' => $request->get('is_featured')
                                        ]);
            } else {
                $attrValueModel->update(['value' => $request->get('is_featured')]);
            }

        }
    }
}
