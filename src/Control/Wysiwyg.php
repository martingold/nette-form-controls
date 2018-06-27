<?php declare(strict_types=1);

namespace MartinGold\Forms\Control;

class Wysiwyg extends \Nette\Forms\Controls\TextArea {

    public function __construct(string $label) {
        parent::__construct($label);
        $this->getControlPrototype()->addAttributes([
            'class' => 'wysiwyg',
        ]);
    }

}
