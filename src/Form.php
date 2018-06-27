<?php declare(strict_types=1);

namespace MartinGold\Forms;

use MartinGold\Forms\Control\ButtonRadio;
use MartinGold\Forms\Control\Datepicker;
use MartinGold\Forms\Control\DateRange;
use MartinGold\Forms\Control\Wysiwyg;

class Form extends \Nette\Application\UI\Form {

    public function addDatePicker(string $name, string $label): DatePicker {
        $control = new DatePicker($label);
        $this[$name] = $control;
        return $control;
    }

    public function addWysiwyg(string $name, string $label): Wysiwyg {
        $control = new Wysiwyg($label);
        $this[$name] = $control;
        return $control;
    }

    /**
     * @param mixed[]|null $items
     */
    public function addButtonRadio(string $name, string $label, ?array $items): ButtonRadio {
        $control = new ButtonRadio($label, $items);
        $this[$name] = $control;
        return $control;
    }

    public function addDateRange(string $name, string $label): DateRange {
        $control = new DateRange($label, null);
        $this[$name] = $control;
        return $control;
    }

}
