@extends('layouts.app')

@section('content')
    <div class="modal-add modal-lg" id="modal#add">
        <div class="modal__content">
            <h2 class="modal__title">Adicionar tarefa</h2>
            <form action="/tasks" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label label__name">Tarefa:</label>
                    <input type="text" class="form-control" id="name" name="name">
                    @error('name')
                        <div class="alert alert-danger">{{ $message }}</div>                        
                    @enderror
                </div>
                <div class="d-flex justify-content-between align-items-center flex-wrap modal-button-container">
                    <button type="submit" class="btn btn-primary">Salvar</button>
                    <a href="#" class="btn btn-secondary" onclick="document.body.classList.remove('no-scroll')">Cancelar</a>
                </div>
            </form>
        </div>
    </div>

    <div class="content">
        @guest
            <p class="p-guest">Você precisa estar logado para visualizar suas tarefas. Clique <a href="/login">aqui</a> para entrar na sua conta.</p>
        @endguest

        @auth
            <div class="d-flex justify-content-start align-items-center">
                <a href="#modal#add" class="btn btn-primary btn-add" onclick="document.body.classList.add('no-scroll')">Adicionar tarefa</a>
            </div>
            
            <div class="kanban-board">
                <div class="kanban-column kanban-column-todo">
                    <h3 class="text-center">Fazer</h3>
                    @foreach($tasks->where('status', 'to_do') as $itemToDo)
                        <div class="task-card">         
                            <p class="fs-5">{{ $itemToDo->name }}</p>
                            <div class="task-actions">
                                <a href="#modal#edit#{{ $itemToDo->id }}" class="btn btn-warning" title="Editar tarefa" onclick="document.body.classList.add('no-scroll')"><ion-icon name="build-outline"></ion-icon></a>
                                <a href="#modal#status#{{ $itemToDo->id }}" class="btn btn-success" title="Mudar status" onclick="document.body.classList.add('no-scroll')"><ion-icon name="code-outline"></ion-icon></a>
                                <form action="/tasks/{{ $itemToDo->id }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" title="Excluir tarefa"><ion-icon name="trash-outline"></ion-icon></button>
                                </form>
                            </div>
                        </div>

                        <div class="modal-edit modal-lg" id="modal#edit#{{ $itemToDo->id }}">
                            <div class="modal__content">
                                <h2 class="modal__title">Editar tarefa</h2>
                                <form action="/tasks/{{ $itemToDo->id }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-3">
                                        <label for="name#{{ $itemToDo->id }}" class="form-label label__name">Tarefa:</label>
                                        <input type="text" class="form-control" id="name#{{ $itemToDo->id }}" name="name#{{$itemToDo->id}}" 
                                            @error( 'name#' . $itemToDo->id ) 
                                                value="{{ old('name#' . $itemToDo->name) }}" 
                                            @enderror 

                                            value="{{ $itemToDo->name }}"
                                        >

                                        @error('name#' . $itemToDo->id)
                                            <div class="alert alert-danger">{{ $message }}</div>                        
                                        @enderror
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center flex-wrap modal-button-container">
                                        <button type="submit" class="btn btn-primary">Salvar</button>
                                        <a href="/tasks" class="btn btn-secondary" onclick="document.body.classList.remove('no-scroll')">Cancelar</a>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="modal-status modal-lg" id="modal#status#{{ $itemToDo->id }}">
                            <div class="modal__content">
                                <h2 class="modal__title">Mudar status da tarefa</h2>
                                <div class="d-flex align-items-center justify-content-evenly mt-4 mb-5">
                                    <form action="/tasks/status/{{ $itemToDo->id }}/todo" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="btn-status">
                                            <button type="submit" class="btn btn-lg rounded-1 btn-status__todo">Fazer</button>
                                        </div>
                                    </form>

                                    <form action="/tasks/status/{{ $itemToDo->id }}/doing" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="btn-status">
                                            <button type="submit" class="btn btn-lg rounded-1 btn-status__doing">Fazendo</button>
                                        </div>
                                    </form>

                                    <form action="/tasks/status/{{ $itemToDo->id }}/done" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="btn-status">
                                            <button type="submit" class="btn btn-lg rounded-1 btn-status__done">Terminado</button>
                                        </div>
                                    </form>
                                </div>

                                <div class="text-end">
                                    <a href="#" class="btn btn-secondary" onclick="document.body.classList.remove('no-scroll')">Cancelar</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                


                <div class="kanban-column kanban-column-doing">
                    <h3 class="text-center">Fazendo</h3>
                    @foreach($tasks->where('status', 'doing') as $itemDoing)
                        <div class="task-card">         
                            <p class="fs-5">{{ $itemDoing->name }}</p>
                            <div class="task-actions">
                                <a href="#modal#edit#{{ $itemDoing->id }}" class="btn btn-warning" title="Editar tarefa" onclick="document.body.classList.add('no-scroll')"><ion-icon name="build-outline"></ion-icon></a>
                                <a href="#modal#status#{{ $itemDoing->id }}" class="btn btn-success" title="Mudar status" onclick="document.body.classList.add('no-scroll')"><ion-icon name="code-outline"></ion-icon></a>
                                <form action="/tasks/{{ $itemDoing->id }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" title="Excluir tarefa"><ion-icon name="trash-outline"></ion-icon></button>
                                </form>
                            </div>
                        </div>

                        <div class="modal-edit modal-lg" id="modal#edit#{{ $itemDoing->id }}">
                            <div class="modal__content">
                                <h2 class="modal__title">Editar tarefa</h2>
                                <form action="/tasks/{{ $itemDoing->id }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-3">
                                        <label for="name#{{ $itemDoing->id }}" class="form-label label__name">Tarefa:</label>
                                        <input type="text" class="form-control" id="name#{{ $itemDoing->id }}" name="name#{{$itemDoing->id}}"
                                            @error( 'name#' . $itemDoing->id ) 
                                                value="{{ old('name#' . $itemDoing->name) }}" 
                                            @enderror 

                                            value="{{ $itemDoing->name }}"
                                        >

                                        @error('name#' . $itemDoing->id)
                                            <div class="alert alert-danger">{{ $message }}</div>                        
                                        @enderror
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center flex-wrap modal-button-container">
                                        <button type="submit" class="btn btn-primary">Salvar</button>
                                        <a href="/tasks" class="btn btn-secondary" onclick="document.body.classList.remove('no-scroll')">Cancelar</a>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="modal-status modal-lg" id="modal#status#{{ $itemDoing->id }}">
                            <div class="modal__content">
                                <h2 class="modal__title">Mudar status da tarefa</h2>
                                <div class="d-flex align-items-center justify-content-evenly mt-4 mb-5">
                                    <form action="/tasks/status/{{ $itemDoing->id }}/todo" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="btn-status">
                                            <button type="submit" class="btn btn-lg rounded-1 btn-status__todo">Fazer</button>
                                        </div>
                                    </form>

                                    <form action="/tasks/status/{{ $itemDoing->id }}/doing" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="btn-status">
                                            <button type="submit" class="btn btn-lg rounded-1 btn-status__doing">Fazendo</button>
                                        </div>
                                    </form>

                                    <form action="/tasks/status/{{ $itemDoing->id }}/done" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="btn-status">
                                            <button type="submit" class="btn btn-lg rounded-1 btn-status__done">Terminado</button>
                                        </div>
                                    </form>
                                </div>

                                <div class="text-end">
                                    <a href="#" class="btn btn-secondary" onclick="document.body.classList.remove('no-scroll')">Cancelar</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>



                <div class="kanban-column kanban-column-done">
                    <h3 class="text-center">Terminado</h3>
                    @foreach($tasks->where('status', 'done') as $itemDone)
                        <div class="task-card">         
                            <p class="text-body-secondary text-decoration-line-through fs-5">{{ $itemDone->name }}</p>
                            <div class="task-actions">
                                <a href="#modal#edit#{{ $itemDone->id }}" class="btn btn-warning" title="Editar tarefa" onclick="document.body.classList.add('no-scroll')"><ion-icon name="build-outline"></ion-icon></a>
                                <a href="#modal#status#{{ $itemDone->id }}" class="btn btn-success" title="Mudar status" onclick="document.body.classList.add('no-scroll')"><ion-icon name="code-outline"></ion-icon></a>
                                <form action="/tasks/{{ $itemDone->id }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" title="Excluir tarefa"><ion-icon name="trash-outline"></ion-icon></button>
                                </form>
                            </div>
                        </div>

                        <div class="modal-edit modal-lg" id="modal#edit#{{ $itemDone->id }}">
                            <div class="modal__content">
                                <h2 class="modal__title">Editar tarefa</h2>
                                <form action="/tasks/{{ $itemDone->id }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-3">
                                        <label for="name#{{ $itemDone->id }}" class="form-label label__name">Tarefa:</label>
                                        <input type="text" class="form-control" id="name#{{ $itemDone->id }}" name="name#{{$itemDone->id}}"
                                            @error( 'name#' . $itemDone->id ) 
                                                value="{{ old('name#' . $itemDone->name) }}" 
                                            @enderror 

                                            value="{{ $itemDone->name }}"
                                        >

                                        @error('name#' . $itemDone->id)
                                            <div class="alert alert-danger">{{ $message }}</div>                        
                                        @enderror
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center flex-wrap modal-button-container">
                                        <button type="submit" class="btn btn-primary">Salvar</button>
                                        <a href="/tasks" class="btn btn-secondary" onclick="document.body.classList.remove('no-scroll')">Cancelar</a>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="modal-status modal-lg" id="modal#status#{{ $itemDone->id }}">
                            <div class="modal__content">
                                <h2 class="modal__title">Mudar status da tarefa</h2>
                                <div class="d-flex align-items-center justify-content-evenly mt-4 mb-5">
                                    <form action="/tasks/status/{{ $itemDone->id }}/todo" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="btn-status">
                                            <button type="submit" class="btn btn-lg rounded-1 btn-status__todo">Fazer</button>
                                        </div>
                                    </form>

                                    <form action="/tasks/status/{{ $itemDone->id }}/doing" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="btn-status">
                                            <button type="submit" class="btn btn-lg rounded-1 btn-status__doing">Fazendo</button>
                                        </div>
                                    </form>

                                    <form action="/tasks/status/{{ $itemDone->id }}/done" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="btn-status">
                                            <button type="submit" class="btn btn-lg rounded-1 btn-status__done">Terminado</button>
                                        </div>
                                    </form>
                                </div>

                                <div class="text-end">
                                    <a href="#" class="btn btn-secondary" onclick="document.body.classList.remove('no-scroll')">Cancelar</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endauth
    </div>
@endsection