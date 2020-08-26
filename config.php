<?php
declare(strict_types=1);

const REGISTRATION = 1;
const PRODUCT = 2;

const ENTITIES = [
    REGISTRATION => [
        'username',
        'email',
        'password',
        'name',
    ],
    PRODUCT => [
        'name',
        'count',
        'extra',
        'description',
    ]
];