<?php
declare(strict_types=1);

namespace Kamephis\Avatar\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

class Timezone implements OptionSourceInterface
{
    /**
     * Retrieve all available timezones as an array of options.
     *
     * @return array An array of options where each option has a 'value' and 'label' key representing
     *               the timezone identifier and the timezone label respectively.
     */
    public function toOptionArray(): array
    {
        $timezones = [];
        $timestamp = time();

        foreach (timezone_identifiers_list() as $timezone) {
            date_default_timezone_set($timezone);
            $label = sprintf('(%s) %s', date('P', $timestamp), $timezone);
            $timezones[] = ['value' => $timezone, 'label' => $label];
        }
        return $timezones;
    }
}
