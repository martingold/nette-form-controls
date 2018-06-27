<?php declare(strict_types=1);

namespace MartinGold\Forms\Renderer;

use Nette\Forms\Controls\BaseControl;
use Nette\Forms\Controls\Button;
use Nette\Forms\Controls\Checkbox;
use Nette\Forms\Controls\CheckboxList;
use Nette\Forms\Controls\RadioList;
use Nette\Forms\Controls\TextInput;
use Nette\Forms\Controls\UploadControl;
use Nette\Forms\IControl;
use Nette\Utils\Html;
use Nette\Utils\Strings;
use MartinGold\Forms\Control\ButtonRadio;

class Bootstrap4Renderer extends \Nette\Forms\Rendering\DefaultFormRenderer {

    /**
     * @var string[]
     */
    public $wrappers = [
        'form' => [
            'container' => null,
        ],

        'error' => [
            'container' => 'div class="row mb-3"',
            'item'      => 'div class="col-12 alert alert-danger"',
        ],

        'group' => [
            'container'   => null,
            'label'       => 'p class="h3 modal-header"',
            'description' => 'p class="pl-3 lead"',
        ],

        'controls' => [
            'container' => null,
        ],

        'pair' => [
            'container' => 'div class="form-group row"',
            '.required' => null,
            '.optional' => null,
            '.odd'      => null,
            '.error'    => 'is-invalid',
        ],

        'control' => [
            'container' => 'div class="col-md-9 col-sm-12"',
            '.odd'      => null,

            'description'    => 'small class="form-text text-muted"',
            'requiredsuffix' => null,
            'errorcontainer' => 'div class="invalid-feedback"',
            'erroritem'      => null,

            '.required' => null,
            '.text'     => null,
            '.password' => null,
            '.file'     => null,
            '.email'    => null,
            '.number'   => null,
            '.submit'   => '_btn',
            '.image'    => null,
            '.button'   => null,
        ],

        'label' => [
            'container'      => 'div class="col-md-3 text-md-right col-sm-12"',
            'suffix'         => null,
            'requiredsuffix' => ' *',
        ],

        'hidden' => [
            'container' => null,
        ],
    ];

    public function renderErrors(?IControl $control = null, $own = true): string {
        $temp = $this->wrappers['control']['errorcontainer'];
        if ($control instanceof Checkbox || $control instanceof RadioList
            || $control instanceof UploadControl
        ) {
            $this->wrappers['control']['errorcontainer']
                = $this->wrappers['control']['errorcontainer']
                  . ' style="display: block"';
        }

        if ($control instanceof BaseControl) {
            $errs = [];
            foreach ($control->getErrors() as $err) {
                $errs[] = $control->getLabel()->getText() . ': ' . $err;
            }

            //            $control->cleanErrors();
            foreach ($errs as $error) {
                $this->form->addError($error);
            }
        }

        $parent = parent::renderErrors($control, $own);

        if ($control instanceof Checkbox || $control instanceof RadioList
            || $control instanceof UploadControl
        ) {
            $this->wrappers['control']['errorcontainer'] = $temp;
        }

        return $parent;
    }

    /**
     * @param mixed[] $controls
     */
    public function renderPairMulti(array $controls): string {
        foreach ($controls as $control) {
            if ($control instanceof Button) {
                if ($control->controlPrototype->class === null
                    || (is_array($control->controlPrototype->class)
                        && ! Strings::contains(implode(' ', array_keys($control->controlPrototype->class)), 'btn btn-'))
                ) {
                    $control->controlPrototype->addClass(
                        (empty($primary) ? 'btn btn-outline-primary'
                            : 'btn btn-outline-secondary')
                    );
                }

                $primary = true;
            }
        }

        return parent::renderPairMulti($controls);
    }

    /**
     */
    public function renderLabel(IControl $control): Html {
        if ($control instanceof Checkbox || $control instanceof CheckboxList) {
            $control->labelPrototype->addClass('form-check-label');
        } elseif ($control instanceof RadioList) {
            $control->labelPrototype->addClass('form-check-label');
        } else {
            $control->labelPrototype->addClass('col-form-label');
        }

        $parent = parent::renderLabel($control);

        return $parent;
    }

    /**
     */
    public function renderControl(IControl $control): Html {
        if ($control instanceof Checkbox || $control instanceof CheckboxList) {
            $control->controlPrototype->addClass('form-check-input');

            if ($control instanceof CheckboxList) {
                $control->separatorPrototype->setName('div')
                    ->addClass('form-check form-check-inline');
            }
        } elseif ($control instanceof RadioList) {
            $control->containerPrototype->setName('div')
                ->addClass('form-check');
            $control->itemLabelPrototype->addClass('form-check-label');
            $control->controlPrototype->addClass('form-check-input');

            if ($control instanceof ButtonRadio) {
                $control->getContainerPrototype()->addAttributes([
                    'class'       => 'btn-group btn-group-toggle',
                    'data-toggle' => 'buttons',
                ]);
                $control->getItemLabelPrototype()
                    ->addAttributes(['class' => 'btn btn-primary']);
            }
        } elseif ($control instanceof UploadControl) {
            $control->controlPrototype->addClass('form-control-file');
        } else {
            if ($control->hasErrors()) {
                $control->controlPrototype->addClass('is-invalid');
            }

            $control->controlPrototype->addClass('form-control');
        }

        $parent = parent::renderControl($control);

        // addons
        if ($control instanceof TextInput) {
            $leftAddon = $control->getOption('left-addon');
            $rightAddon = $control->getOption('right-addon');

            if ($leftAddon !== null || $rightAddon !== null) {
                $children = $parent->getChildren();
                $parent->removeChildren();

                $container = Html::el('div')->setClass('input-group');

                if ($leftAddon !== null) {
                    if ( ! is_array($leftAddon)) {
                        $leftAddon = [$leftAddon];
                    }

                    $div = Html::el('div')->setClass('input-group-prepend');

                    foreach ($leftAddon as $v) {
                        $div->insert(null, Html::el('span')
                            ->setClass('input-group-text')
                            ->setText($v));
                    }

                    $container->insert(null, $div);
                }

                foreach ($children as $child) {
                    $foo = Strings::after($child, $control->getControlPart()->render());

                    if ($foo !== false) {
                        $container->insert(null, $control->getControlPart()->render());
                        $description = $foo;
                    } else {
                        $container->insert(null, $child);
                    }
                }

                if ($rightAddon !== null) {
                    if ( ! is_array($rightAddon)) {
                        $rightAddon = [$rightAddon];
                    }

                    $div = Html::el('div')->setClass('input-group-append');

                    foreach ($rightAddon as $v) {
                        $div->insert(null, Html::el('span')
                            ->setClass('input-group-text')
                            ->setText($v));
                    }

                    $container->insert(null, $div);
                }

                $parent->insert(null, $container);

                if ( ! empty($description)) {
                    $parent->insert(null, $description);
                }
            }
        }

        return $parent;
    }

}
