<?php

namespace Lotgd\Local\Twig\Extension\Pattern\ModuleWorldmapen;

trait Legend
{
    /**
     * World map key (Legend).
     *
     * @param bool $showloc
     *
     * @return string
     */
    public function showLegend($showloc): string
    {
        $vloc = [];
        $vname = getsetting('villagename', LOCATION_FIELDS);
        $vloc[$vname] = 'village';
        $vloc = modulehook('validlocation', $vloc);

        $loc = get_module_pref('worldXYZ', 'worldmapen');
        list($worldmapX, $worldmapY, $worldmapZ) = explode(',', $loc);

        $params = [
            'textDomain' => 'module-worldmapen',
            'terrain' => worldmapen_getTerrain($worldmapX, $worldmapY, $worldmapZ),
            'showLocation' => $showloc,
            'enableTerrains' => get_module_setting('enableTerrains', 'worldmapen'),
            'colorUserLoc' => get_module_setting('colorUserLoc', 'worldmapen'),
            'terrainDef' => worldmapen_loadTerrainDefs()
        ];

        return $this->getTheme()->renderModuleTemplate('worldmapen/twig/legend.twig', $params);
    }
}
