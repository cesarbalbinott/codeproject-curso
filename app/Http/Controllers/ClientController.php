<?php

namespace CodeProject\Http\Controllers;

use CodeProject\Repositories\ClientRepository;
use CodeProject\Services\ClientService;
use Illuminate\Http\Request;

class ClientController extends Controller
{
  /**
   * @var ClientRepository
   */
    private $repository;
    private $service;

    public function __construct(ClientRepository $repository, ClientService $service)
    {
      $this->repository = $repository;
      $this->service = $service;
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return $this->repository->all();
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        return $this->service->create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $client = $this->service->search($id);
        if($client['success']){
          return $this->repository->find($id);
        }
        return $client;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
      try{
        $client = $this->service->search($id);
        if($client['success']){
          if($this->service->update($request->all(), $id)){
            return ["success" => true,
                    "message" => "Cliente {$id} alterado com sucesso!",
                    "alteracao" => $client];
          }else{
            return ["success" => false,
                    "message" => "Não foi possível alterar o cliente: {$id}."
                   ];
          }
        }
        return $client;
        }catch (\Exception $e) {
            return [
                'success' => 'false',
                'message' => "Não foi possível alterar o cliente: {$id}"
            ];
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
      try{
        $client = $this->service->search($id);
        if($client['success']){
          if($this->repository->delete($id)){
            return ["success" => true,
                    "message" => "Cliente {$id} excluido com sucesso!"];
          }else{
            return ["success" => false,
                    "message" => "Não foi possível excluir o cliente: {$id}."
                   ];
          }
        }
        return $client;
        }catch (\Exception $e) {
            return [
                'success' => 'false',
                'message' => "Não foi possível excluir o cliente: {$id}"
            ];
        }
    }
}
