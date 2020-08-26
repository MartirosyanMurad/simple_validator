<?php
declare(strict_types=1);

use Src\Forms\ProductValidator;
use Src\Forms\UniversalForm;
use Src\Forms\RegistrationValidator;

$validators = [
    REGISTRATION => RegistrationValidator::class,
    PRODUCT => ProductValidator::class,
];
a:
echo "Which entity you want to create(choose the number of entity):\n1. Registration\n2. Product" . PHP_EOL;
$entity = trim(fgets(STDIN));

if (!(is_numeric($entity) && isset(ENTITIES[$entity]))) {
    echo 'Wrong entity, please try again!' . PHP_EOL;
    goto a;
}

$params = [];
foreach (ENTITIES[$entity] as $param) {
    echo strtoupper($param) . ': ';
    $params[$param] = trim(fgets(STDIN));

}

$form = new UniversalForm($params, new $validators[$entity]);
if (!$form->isValid()) {
    print_r($form->getErrors());
} else {
    echo 'Congratulation you successfully create entity!!!' . PHP_EOL;
    foreach (array_keys($params) as $param) {
        echo strtoupper($param) . ': ';
            if (is_array($form->{$param})) {
                print_r($form->{$param});
            } else {
                echo $form->{$param} . PHP_EOL;
            }
    }
}
