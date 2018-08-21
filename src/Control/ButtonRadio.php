<?php declare(strict_types=1);

namespace MartinGold\Forms\Control;

class ButtonRadio extends \Nette\Forms\Controls\RadioList {

    /**
     * @param mixed[] $items
     */
    public function __construct(string $label, ?array $items = null) {
        parent::__construct($label, $items ?? [
                false => 'Ne',
                true  => 'Ano',
            ]);
        $this->setRequired(true);
    }

    /**
     * @param mixed $value
     */
    public function setDefaultValue($value): ButtonRadio {
        if (is_bool($value)) {
            parent::setDefaultValue($value ? 1 : 0);
        } else {
            parent::setDefaultValue($value);
        }

        return $this;
    }

}
