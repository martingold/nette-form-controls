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
        $this->setDefaultValue(new DateTime);
    }


    public function getValue(): ?DateTime {
        if (strlen($this->value) > 0) {
            $date = DateTime::createFromFormat($this->format, $this->value);
            return $date;
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

    /**
     * @param mixed $value
     * @return \MartinGold\Forms\Control\Datepicker
     * @throws \MartinGold\Forms\Exception\InvalidArgumentType
     */
    public function setDefaultValue($value): self {
        if ($value instanceof DateTime) {
            parent::setDefaultValue($value->format($this->format));
        } else {
            throw new \MartinGold\Forms\Exception\InvalidArgumentType(
                DateTime::class,
                $value,
                __METHOD__,
                'value'
            );
        }
    }

}
