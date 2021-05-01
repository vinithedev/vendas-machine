<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Jobs\MailJob;
use App\Models\Product;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function dlfile()
    {
        $table = Order::all();
        $filename = time() . "orders.csv";
        $handle = fopen($filename, 'w+');
        fputcsv($handle, array('id', 'client_id', 'produtos', 'total', 'created_at'));

        foreach($table as $row) {
            fputcsv($handle, array($row['id'], $row['client_id'], $row['produtos'], $row['total'], $row['created_at']));
        }
        fclose($handle);
        
        $headers = ['Content-Type' => 'text/csv'];

        return response()->download($filename, 'test.csv', $headers);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'client_id' => 'required',
            'produtos' => 'required'
        ];
        
        $customMessages = [
            'required' => [
                'field' => ':attribute',
                'message' => 'O :attribute e obrigatorio',
            ]
        ];

        $this->validate($request, $rules, $customMessages);
        $mail = Client::find(request('client_id'))->email;
        dispatch(new MailJob($mail));
        
        $products = $request->get('produtos');
        $n = 0;
        $total = 0;
        foreach ($products as $val) {
            $p_id = $val['product_id'];
            $p_info = Product::find($p_id);
            $p_amount = $val['amount'];

            if (!$p_info) {
                return response()->json(['message' => 'produto com id ' . $p_id . ' nao existe'], 404);
            }
            
            $p_total = $p_info->price * $p_amount;
            $products[$n]['total'] = $p_total;
            $total = $total + $p_total;
            $n++;
        }

        return Order::create([
            'client_id' => $request->json()->get('client_id'),
            'produtos' => json_encode($products),
            'total' => $total
        ]);
        
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
