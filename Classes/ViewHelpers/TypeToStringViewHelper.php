<?php
namespace NeosRulez\Neos\Form\NodeProperty\ViewHelpers;

use Neos\Flow\Annotations as Flow;
use Neos\FluidAdaptor\Core\ViewHelper\AbstractViewHelper;

class TypeToStringViewHelper extends AbstractViewHelper
{

    public function initializeArguments()
    {
        $this->registerArgument('propertyValue', 'mixed', 'Value of the property', false);
        $this->registerArgument('dateTimeFormat', 'string|null', 'Format of a datetime property', false);
    }

    /**
     * @return string
     */
    public function render(): string
    {
        if($this->getPropertyValueType() === 'object' && $this->getPropertyValueClass() === 'DateTime' && $this->getPropertyValue()) {
            return $this->getPropertyValue()->format($this->getDateTimeFormat());
        }
        return $this->getPropertyValue();
    }

    /**
     * @return string
     */
    public function getPropertyValueType(): string
    {
        return gettype($this->arguments['propertyValue']);
    }

    /**
     * @return string
     */
    public function getPropertyValueClass(): string
    {
        return get_class($this->arguments['propertyValue']);
    }

    /**
     * @return mixed
     */
    public function getPropertyValue(): mixed
    {
        return $this->arguments['propertyValue'] !== null ? $this->arguments['propertyValue'] : '';
    }

    /**
     * @return string
     */
    public function getDateTimeFormat(): string
    {
        return $this->arguments['dateTimeFormat'] !== null ? $this->arguments['dateTimeFormat'] : 'Y-m-d H:i:s';
    }

}
