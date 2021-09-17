<?php

namespace App\Http\Controllers;
use Loan;

use Illuminate\Http\Request;

class TestjamController extends Controller
{
   
    private $model = 'App' . '\\' . 'Loan';
    public function index()
    {
        $data_show = $this->model->orderBy()->get();
        return view('',['data' => $data_show]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Loan $loan)
    {
        $data['row'] = $loan;
        return view('',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Loan $loan)
    {
        $new = new $this->model;
        $table_columns = $loan->getTableColumns();
        foreach ($request->all() as $key => $value) {
            if(in_array($key,$table_columns))
            {
                $loan->$key = $value;
            }
        }
        $loan->save();
        $return_data['success'] = true;

        return response()->json($return_data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Loan $loan)
    {
        $data['row'] = $loan;
        return view('',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Loan $loan)
    {
        $table_columns = $loan->getTableColumns();
        foreach ($request->all() as $key => $value) {
            if(in_array($key,$table_columns))
            {
                $loan->$key = $value;
            }
        }
        $loan->save();
        $return_data['success'] = true;

        return response()->json($return_data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Loan $loan)
    {
        $loan->delete();
        $return_data['success'] = true;

        return response()->json($return_data);
    }
    
    public function display(Request $request, Loan $loan)
    {
        $table_columns = $loan->getTableColumns();
        $data_id = $table_columns[0];
        $id = $request->data_id;
        $check = $this->model::where($data_id,$id)->first();
        $loan->display = !($check->display);
        $loan->save();

        $return_data['success'] = true;

        return response()->json($return_data);
    }
    
    public function search(Request $request)
    {
        $buffer = new $this->model;
        $search = [];
        foreach ($request->all() as $key => $value) {
            $search[$key] = $value;
            if(isset($value)){
                $buffer = $buffer->where($key,'like','%'.$value.'%');
            }
        }
        $data = $buffer->get();
        $res = [];
        foreach($data as $v)
        {
            $ar = [];
            for($i; $i < count($this->specify); $i++)
            {
                array_push($ar,$v->this->specify[$i]);
            }
            array_push($res,$ar);
        }
        return response()->json($res);

    }
    public function specify()
    {
        $filter_column = [
                            '',
                            '',
                            ''
                                ];
        return $filter_column;
    }
    public function import()
    {
        $fileName_import;
    }
    public function export()
    {

    }

}
