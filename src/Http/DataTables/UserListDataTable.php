<?php

namespace Lawin\Seat\Esintel\Http\DataTables;

use Lawin\Seat\Esintel\Models\Character;
use Lawin\Seat\Esintel\Models\Category;
use Yajra\DataTables\Html\Button;
use Yajra\DataTable\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Lawin\Seat\Esintel\Http\Resources\Character as CharacterResource;



class UserListDataTable extends DataTable
{



    public function html()
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->parameters(['order' => [0, 'asc']]);
    }



    public function query()
    {
        $characters = Character::select('id', 'character_id', 'main_character_id', 'es', 'intel_category');
        return $characters;
    }



    public function ajax()
    {
        return datatables()
            ->eloquent($this->query())
            ->addColumn('name', function (Character $char)
                {
                    return '<img src="' . $char->getPortraitUrl(32) . '" class="img-circle" style="width:16px;"> <a href="' . route('esintel.view', $char->character_id) . '">' . $char->name . '</a>';
                })
            ->addColumn('maincharacter', function (Character $char)
                {
                    if(isset($char->main_character_id))
                    {
                        return '<img src="' . $char->mainchar->getPortraitUrl(32) . '" class="img-circle" style="width:16px;"> <a href="' . route('esintel.view', $char->main_character_id) . '">' . $char->mainchar->name . '</a>';
                    }
                    else
                    {
                        return "";
                    }
                })
            ->addColumn('corporation', function(Character $char){
                return '<img src="' . $char->getCorpLogoUrl(32) . '" class="img-circle" style="width:16px;"> ' . $char->corp->name;
                })
            ->addColumn('alliance', function(Character $char){
                if($char->alliance){
                    return '<img src="' . $char->getAllianceLogoUrl(32) . '" class="img-circle" style="width:16px;"> ' . $char->alliance->name;
                } else {
                    return "";
                }
                })
            ->addColumn('intel_category_text', function(Character $char)
                {
                    return $char->intel_category_name();
                })
            ->editColumn('es', function(Character $char)
                {
                    return '<span class="es-table-' . $char->es . '" style="font-weight: bold;">' . $char->es . '</span>';
                }

                )
            ->rawColumns(['name', 'maincharacter', 'corporation', 'alliance', 'es'])
            ->make(true);
    }


    protected function getColumns()
    {
        return [
            [
                'data' => 'id',
                'title' => 'ID',
                'orderable' => true,
            ],
            [
                'data' => 'name',
                'title' => 'Character',
                'orderable' => false,
            ],
            [
                'data' => 'maincharacter',
                'title' => 'Main Character',
                'orderable' => false,
            ],
            [
                'data' => 'corporation',
                'title' => 'Corporation',
                'orderable' => false,
            ],
            [
                'data' => 'alliance',
                'title' => 'Alliance',
                'orderable' => false,
            ],
            [
                'data' => 'es',
                'title' => 'ES',
                'orderable' => false,
            ],
            [
                'data' => 'intel_category_text',
                'title' => 'Category',
                'orderable' => false,
            ],
        ];
    }
}