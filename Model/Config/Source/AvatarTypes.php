<?php

namespace Kamephis\Avatar\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Kamephis\Avatar\Enum\AvatarTypes as Types;

class AvatarTypes implements OptionSourceInterface
{
    public function toOptionArray()
    {
        $options = [
            [
                'value' => '',
                'label' => __('none')
            ]
        ];

        foreach (Types::getAll() as $type) {
            $options[] = ['value' => $type->getType(), 'label' => __($type->getName())];
        }

        return $options;
    }
}
