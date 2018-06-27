<?php declare(strict_types=1);

namespace MartinGold\Forms\Control;

use Nette\Forms\Form;
use Nette\Utils\DateTime;
use Nette\Utils\Html;

final class DateRange extends \Nette\Forms\Controls\TextInput {

    /**
     * @var string
     */
    private $format = 'd.m.Y';

    public function __construct(string $label, ?int $maxLength = null) {
        parent::__construct($label, $maxLength);
        $this->setDefaultValue(new DateTime);
    }

    /**
     * @return DateTime[]
     */
    public function getValue(): array {
        $data = $this->getHttpData(Form::DATA_TEXT | Form::DATA_KEYS, '[]');
        $from = DateTime::createFromFormat($this->format, $data['from']);
        $to = DateTime::createFromFormat($this->format, $data['to']);
        return [$from, $to];
    }

    public function getControl(): Html {
        $attributes = [
            'class'        => 'datepicker form-control',
            'autocomplete' => 'false'
        ];

        $wrap = Html::el('div', [
            'class' => 'input-group input-daterange input-group-sm'
        ]);

        if(parent::getValue() instanceof \DateTime) {
            $default = parent::getValue()->format($this->format);
        } else {
            $default = (new \DateTime)->format($this->format);
        }

        $from = parent::getControl()->addAttributes($attributes + [
                'name' => $this->getName() . '[from]',
                'value' => $default,
            ]);
        $to = parent::getControl()->addAttributes($attributes + [
                'name' => $this->getName() . '[to]',
                'value' => $default,
            ]);

        $addonText = Html::el('div')
            ->setAttribute('class', 'input-group-text')
            ->setText('do');
        $addon = Html::el('div', [
            'class' => 'input-group-prepend input-group-append'
        ])->setHtml($addonText);

        $wrap->addHtml($from);
        $wrap->addHtml($addon);
        $wrap->addHtml($to);

        return $wrap;
    }

    /** @see http://php.net/manual/en/function.date.php#refsect1-function.date-parameters */
    public function setFormat(string $format): void {
        $this->format = $format;
    }

}
