<?php

namespace Lotgd\Local\Twig\Extension\Pattern\ModuleWorldmapen;

trait MapEditor
{
    /**
     * Show map for edit.
     *
     * @return string
     */
    public function showMapEditor(): string
    {
        $vloc = [];
        $vname = getsetting('villagename', LOCATION_FIELDS);
        $vloc[$vname] = 'village';
        $vloc = modulehook('validlocation', $vloc);

        $cityMap = [];
        foreach ($vloc as $city => $val)
        {
            $cityX = get_module_setting($city.'X', 'worldmapen');
            $cityY = get_module_setting($city.'Y', 'worldmapen');

            $cityMap["{$cityX},{$cityY}"] = $city;
        }

        $params = [
            'textDomain' => 'module-worldmapen',
            'colorUserLoc' => get_module_setting('colorUserLoc', 'worldmapen'),
            'sizeX' => get_module_setting('worldmapsizeX', 'worldmapen'),
            'sizeY' => get_module_setting('worldmapsizeY', 'worldmapen'),
            'cityMap' => $cityMap,
            'worldMap' => worldmapen_loadMap(),
            'terrainColor' => worldmapen_getColorDefinitions()
        ];

        return $this->getTheme()->renderModuleTemplate('worldmapen/twig/map-editor.twig', $params);
    }
}
