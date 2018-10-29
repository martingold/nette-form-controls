<?php declare(strict_types=1);

namespace MartinGold\Forms\Control;

use \DateTime;
use Nette\Utils\Html;

class Datepicker extends \Nette\Forms\Controls\TextInput {

    /**
     * @var string
     */
    protected $format;

    public function __construct(string $label, $format = 'd.m.Y') {
        parent::__construct($label, null);
        $this->format = $format;
        parent::setDefaultValue((new DateTime)->format($this->format));
    }


    public function getValue(): ?DateTime {
        if (strlen($this->value) > 0) {
            $date = DateTime::createFromFormat($this->format, $this->value);
            return $date instanceof DateTime ? $date : null;
        }
        return null;
    }

    public function getControl(): Html {
        $control = parent::getControl();
        $control->addAttributes([
            'class'        => 'datepicker form-control',
            'autocomplete' => 'false',
        ]);

        return $control;
    }

    public function setDefaultValue(?DateTime $value): self {
        if ($value instanceof DateTime) {
            parent::setDefaultValue($value->format($this->format));
        } else {
            parent::setDefaultValue('');
        }
        return $this;
    }

}
