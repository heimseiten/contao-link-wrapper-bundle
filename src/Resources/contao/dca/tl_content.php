<?php

declare(strict_types=1);

use Contao\CoreBundle\DataContainer\PaletteManipulator;
use Contao\DataContainer;

$GLOBALS['TL_DCA']['tl_content']['fields']['linkWrapper'] = [ 
    'label'     => &$GLOBALS['TL_LANG']['tl_content']['linkWrapper'],
    'exclude'                 => true,
	'search'                  => true,
	'inputType'               => 'text',
	'eval'                    => array('rgxp'=>'url', 'decodeEntities'=>true, 'maxlength'=>255, 'dcaPicker'=>true, 'tl_class'=>'w50'),
	'sql'                     => "varchar(255) NOT NULL default ''"
];

$GLOBALS['TL_DCA']['tl_content']['fields']['openInNewWindow'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['openInNewWindow'],
    'inputType' => 'checkbox', 
    'eval'      => array('tl_class' => 'w50 m12'),
    'sql'       => "char(1) NOT NULL default ''" 
];

$GLOBALS['TL_DCA']['tl_content']['config']['onload_callback'][] = function (DataContainer $dc): void {
    foreach ($GLOBALS['TL_DCA'][$dc->table]['palettes'] as $key => $palette) {
        if (\is_string($palette)) {
            if ($key == 'text') { 
                PaletteManipulator::create()
                ->addField('linkWrapper', 'text_legend', PaletteManipulator::POSITION_APPEND)
                ->addField('openInNewWindow', 'text_legend', PaletteManipulator::POSITION_APPEND)
                ->applyToPalette($key, $dc->table);
            }
        }
    }
};
