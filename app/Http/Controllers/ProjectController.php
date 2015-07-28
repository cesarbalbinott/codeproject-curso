<?php

namespace CodeProject\Http\Controllers;

use CodeProject\Repositories\ProjectRepository;
use CodeProject\Services\ProjectService;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
  /**
   * @var ClientRepository
   */
    private $repository;
    private $service;

    public function __construct(ProjectRepository $repository, ProjectService $service)
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
        return $this->repository->with(['user', 'client'])->all();
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
      $project = $this->service->search($id);
      if($project['success']){
        return $this->repository->with(['user', 'client'])->find($id);
      }
      return $project;
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
        $project = $this->service->search($id);
        if($project['success']){
          if($this->service->update($request->all(), $id)){
            return ["success" => true,
                    "message" => "Projeto {$id} alterado com sucesso!",
                    "alteracao" => $project];
          }else{
            return ["success" => false,
                    "message" => "Não foi possível alterar o projeto: {$id}."
                   ];
          }
        }
        return $project;
        }catch (\Exception $e) {
            return [
                'success' => 'false',
                'message' => "Não foi possível alterar o projeto: {$id}"
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
        $project = $this->service->search($id);
        if($project['success']){
          if($this->repository->find($id)->delete()){
            return ["success" => true,
                    "message" => "Projeto {$id} excluido com sucesso!"];
          }else{
            return ["success" => false,
                    "message" => "Não foi possível excluir o projeto: {$id}."
                   ];
          }
        }
        return $project;
        }catch (\Exception $e) {
            return [
                'success' => 'false',
                'message' => "Não foi possível excluir o projeto: {$id}"
            ];
        }

    }
}
