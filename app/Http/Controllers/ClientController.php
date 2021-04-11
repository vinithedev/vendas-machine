<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use Illuminate\Validation\Validator;
use App\Models\Order;

class ClientController extends Controller
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

    public function pedidos(Request $request)
    {
        $data = Order::all();

        if ($request->has('pedido_data_maior')) {
            $data = $data->where('created_at', '>', $request->pedido_data_maior);
        }
        if ($request->has('pedido_total_menor_igual')) {
            $data = $data->where('total', '<=', $request->pedido_total_menor_igual);
        }
        if ($request->has('pedido_total_maior')) {
            $data = $data->where('total', '>', $request->pedido_total_maior);
        }
        if ($request->has('exportar')) {
            // - Exportar como relatório `Se passar o parametro deverá exportar como um relatório e enviar por e-mail, fazer como um job.`
        }

        $z = response()->json([
            "client_id" => $data[0]->client_id,
            "name" => Client::find($data[0]->client_id)->nome,
            "orders" => $data->where('client_id', '=', $data[0]->client_id)
        ]);

        return $z;
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
            'nome' => 'required',
            'documento' => 'required|cpf_ou_cnpj|unique:clients',
            'email' => 'required|email:rfc|unique:clients',
        ];

        $customMessages = [
            'required' => 'Campo :attribute e necessario.',
            'email' => 'E-mail invalido',
            'cpf_ou_cnpj' => 'Documento invalido',
            'unique' => ':attribute nao e unico',
        ];

        $this->validate($request, $rules, $customMessages);
        
        return Client::create([
            'nome' => request('nome'),
            'documento' => request('documento'),
            'email' => request('email'),
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
        $data = Client::find($id);
        if (!$data) {
            return response()->json(['message' => 'Pagina nao encontrada'], 404);
        }else{
            return Client::find($id);
        }
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
        $client = Client::find($id);
        $client->update($request->all());
        return $client;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Client::destroy($id);
    }
}
