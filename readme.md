# Form controls

Collection of useful form controls

## Features

### Form inputs
This package contains extended Nette Form. Just use `MartinGold\Forms\Form` instead of `Nette\Application\UI\Form`
and you can use all these extension methods (`$form->addDatepicker(...)`) to add one of the new input controls:

 - [ButtonRadio](https://getbootstrap.com/docs/4.0/components/button-group/)
 - [DatePicker](https://github.com/uxsolutions/bootstrap-datepicker)
 - [DateRange](https://github.com/uxsolutions/bootstrap-datepicker)
 - Wysiwyg
 
All controls assume you are using [Bootstrap 4](https://getbootstrap.com/)
and [bootstrap-datepicker](https://github.com/uxsolutions/bootstrap-datepicker).
 
##### RadioButton
```php
$form->addRadioButton('enabled', 'Povoleno', [
    true => 'Ano',
    false => 'Ne',
])->setDefaultValue(false);
```
##### DatePicker and DateRange
Create DatePicker with today's date
```php
$form->addDatePicker('date', 'Datum')
    ->setDefaultValue(DateTime::from(null));
```
Create DateRange with today dates
```php
$form->addDateRange('date', 'Datum')
    ->setDefaultValue(DateTime::from(null));
```
#### Wysiwyg
```php
$form->addWysiwyg('description', 'Popis');
```

## Instalation

 - Include Bootstrap 4 and bootstrap-datepicker and file js/forms.js
 (or copy contents to your already included js file) to your @layout.
 - Execute this command to install
```shell
composer require martingold/forms
```

