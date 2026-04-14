<?php

declare(strict_types=1);

/*
 * This file is part of Contao CTA Bundle.
 *
 * (c) Hamid Peywasti
 *
 * @license MIT
 */

$GLOBALS['TL_DCA']['tl_module']['palettes']['calltoaction'] = '
    {title_legend},name,type;
    {cta_legend},ctaText,ctaIsVisible,ctaUrl,ctaTitle;
    {template_legend:hide},cssID,customTpl;
    {protected_legend:hide},protected;
';

// Define fields
$GLOBALS['TL_DCA']['tl_module']['fields']['ctaIsVisible'] = [
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => ['tl_class' => 'w50 m12'],
    'sql' => ['type' => 'boolean', 'default' => true],
];

$GLOBALS['TL_DCA']['tl_module']['fields']['ctaTitle'] = [
    'inputType' => 'text',
    'eval' => ['mandatory' => true, 'maxlength' => 255, 'tl_class' => 'w50'],
    'sql' => ['type' => 'string', 'length' => 255, 'default' => ''],
];

$GLOBALS['TL_DCA']['tl_module']['fields']['ctaUrl'] = [
    'inputType' => 'text',
    'eval' => ['mandatory' => true, 'rgxp' => 'url', 'decodeEntities' => true, 'maxlength' => 2048, 'dcaPicker' => true, 'tl_class' => 'w50 clr'],
    'sql' => ['type' => 'string', 'length' => 2048, 'default' => ''],
];

$GLOBALS['TL_DCA']['tl_module']['fields']['ctaText'] = [
    'inputType' => 'text',
    'eval' => ['mandatory' => true, 'maxlength' => 255, 'tl_class' => 'w50'],
    'sql' => ['type' => 'string', 'length' => 255, 'default' => ''],
];
