<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        $this->middleware('auth');
    }

    //datatable
    protected function dataTableFormat($query, $request)
    {
        $start = $request->get('start', 0);
        $length = $request->get('length', 10);
        $orders = $request->get('order', []);
        $search = $request->get('search');
        $columns = $this->prepareDataColumns($request->get('columns', []));
        $filters = $this->prepareDataFilter($request->except([
            'columns',
            'order',
            'search',
            'draw',
            'start',
            'length'
        ]));

        $query->filter($filters);

        if (!empty($search['value'])) {
            $query->where(function ($query) use ($columns, $search) {
                foreach ($columns as $column) {
                    if (json_decode($column['searchable'])) {
                        $query->orWhere($column['data'], 'LIKE', '%' . $search['value'] . '%');
                    }
                }
            });
        }

        $count = $query->count();

        foreach ($orders as $key => $order) {
            if (!empty($columns[$order['column']]['data']) && $columns[$order['column']]['orderable']) {
                $query->orderBy($columns[$order['column']]['data'], $order['dir']);
            }
        }

        $data = $length == -1 ? $query->get() : $query->skip(intval($start))->take(intval($length))->get();

        return [
            'draw' => $request->draw,
            'recordsTotal' => $count,
            'recordsFiltered' => $count,
            'data' => $this->customFormat($data),
            'input' => $request->all()
        ];
    }

    protected function customFormat($data)
    {
        return $data;
    }

    protected function prepareDataFilter($data)
    {
        return $data;
    }

    protected function prepareDataColumns($columns)
    {
        return $columns;
    }
}
