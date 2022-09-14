<?php

declare(strict_types=1);

use PhpCsFixer\Fixer\Import\OrderedImportsFixer;
use Symplify\EasyCodingStandard\Config\ECSConfig;
use PhpCsFixer\Fixer\ClassNotation\FinalClassFixer;
use PhpCsFixer\Fixer\Strict\DeclareStrictTypesFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitMethodCasingFixer;
use PhpCsFixer\Fixer\FunctionNotation\VoidReturnFixer;
use Symplify\EasyCodingStandard\ValueObject\Set\SetList;

return static function (ECSConfig $config): void {
    $config->paths([
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ]);

    $config->skip([
        PhpCsFixer\Fixer\PhpUnit\PhpUnitStrictFixer::class,
    ]);

    $config->import(SetList::CLEAN_CODE);
    $config->import(SetList::COMMON);
    $config->import(SetList::PSR_12);
    $config->import(SetList::ARRAY);

    $services = $config->services();

    $services->set(FinalClassFixer::class);
    $services->set(VoidReturnFixer::class);
    $services->set(DeclareStrictTypesFixer::class);
    $services->set(OrderedImportsFixer::class)
        ->call('configure', [['sort_algorithm' => 'length']]);
    $services->set(PhpUnitMethodCasingFixer::class)
        ->call('configure', [['case' => 'snake_case']]);
};
