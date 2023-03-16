@extends('layouts.main')

@section('title', 'Projects')

@section('content')
<div class="container">
    <div class="d-flex align-items-center justify-content-between">
        <h2 class="my-4">
            {{ __('Projects') }}
        </h2>
        <div class="button">
            <a class="btn btn-primary" href="{{route('admin.projects.create')}}"><i class="fa-solid fa-plus"></i> Add</a>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col">
            <div class="card">
                <div class="card-header text-center">{{ __('P O R T F O L I O') }}</div>
                <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">Title</th>
                        <th scope="col">Slug</th>
                        <th scope="col">Category</th>
                        <th scope="col">Visible</th>
                        <th scope="col">Created</th>
                        <th scope="col">Updated</th>
                        <th scope="col">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($projects as $project)
                      <tr>
                        <th class="align-middle" scope="row"><a style="text-transform: uppercase;" href="{{route('admin.projects.show', $project->id)}}">{{$project->title}}</a></th>
                        <td class="align-middle"><input type="text" disabled value='{{Str::slug(old('title', $project->title), '-')}}'></td>
                        <td class="align-middle text-center text-white"><span id="label" style="background-color: {{$project->type->color}}">{{$project->type?->label}}</span></td>
                        <td class="align-middle text-center">
                          @if ($project->is_published)
                          <i class="fa-solid fa-toggle-on text-success fs-2"></i>
                          @else
                          <i class="fa-solid fa-toggle-off text-danger fs-2"></i>                       
                          @endif
                        </td>
                        <td class="align-middle">{{$project->created_at}}</td>
                        <td class="align-middle">{{$project->updated_at}}</td>
                        <td class="align-middle d-flex">
                          <a class="btn btn-primary" href="{{route('admin.projects.show', $project->id)}}"><i class="fa-solid fa-eye text-white"></i></a>
                          <a class="btn btn-warning mx-1" href="{{route('admin.projects.edit', $project->id)}}"><i class="fa-solid fa-pen-to-square text-white"></i></a>
                          <form class="delete-form" action="{{ route('admin.projects.destroy', $project->id) }}" method="POST" data-project-name="{{ $project->name }}">
                            @method('DELETE')
                            @csrf
                            <button class="btn btn-small btn-danger me-2"><i class="fa-solid fa-trash"></i></button>
                        </form>
                        </td>
                      </tr>
                      @endforeach

                    </tbody>
                  </table>
                  <hr>
                  <div class="d-flex justify-content-center">
                    @if ($projects->hasPages())
                        {{$projects->links()}}
                    @endif
                  </div>
            </div>
        </div>
    </div>
</div>
@endsection