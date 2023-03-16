<div class="container mt-5 p-5">

    <div class="card">                
        <div class="card-body d-flex flex-wrap justify-content-center">
            

            @if ($project->exists)
            <form action="{{ route('admin.projects.update', $project->id) }}" method="POST" enctype="multipart/form-data">
                @method('PUT')

                <h3 class="text-center my-3">Edit the Info</h3>
            @else
            <form action="{{ route('admin.projects.store', $project->id) }}" method="POST" enctype="multipart/form-data">
                <h3 class="text-center my-3">Add a new project</h3>
            @endif
                
            @csrf
 
                <div class="row ">
                    <div class="mb-3 col-6 px-5">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $project->title) }}">
                    </div>
                    <div class="mb-3 col-6 px-5">
                        <label for="slug" class="form-label">Slug</label>
                        <input type="text" class="form-control" id="slug" name="slug" disabled value='{{Str::slug(old('title', $project->title), '-')}}'>
                    </div>
                    <div class="mb-3 col-6 px-5">
                        <label for="project_url" class="form-label">Project URL</label>
                        <input type="url" class="form-control" id="project_url" name="project_url" value="{{ old('project_url', $project->project_url) }}">
                    </div>
                    <div class="mb-3 col-6 px-5">
                        <label for="image" class="form-label">Image</label>
                        <input type="file" class="form-control" id="image_url" name="image_url" >
                    </div>
                    <div class="mb-3 col-6 px-5">
                        <label for="description" class="form-label">Description</label>
                        <input type="text" class="form-control" id="description" name="description" value="{{ old('description', $project->description) }}">
                    </div>
                    <div class="mb-3 col-3 px-5 d-flex justify-content-center">
                        <img id="image_preview" class="img-fluid" src="{{ $project['image_url'] ? asset('storage/'.$project['image_url']) : 'https://marcolanci.it/utils/placeholder.jpg'}}" alt="">
                    </div>
                    <div class="mb-3 col-6 px-5">
                        <label class="text-start mb-2" for="type_id">Type</label>
                        <select class="form-control mb-3" name="type_id" id="type_id">
                            <option value="">No type</option>
                            @foreach ($types as $type)
                                <option @if(old('type_id', $project->type?->id) == $type->id) selected @endif value="{{$type->id}}">{{$type->label}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="buttons d-flex justify-content-between">
                    <a class="btn btn-primary mx-5 my-2" href="{{route('admin.projects.index')}}"><i class="fa-solid fa-chevron-left"></i> Go Back</a>
                    <button type="submit" class="btn btn-success mx-5 my-2"><i class="fa-regular fa-floppy-disk"></i> Save</button>
                </div>

            </form>

            @section('scripts')
            <script>
                // Get the elements
                const titleInput = document.getElementById('title');
                const slugInput = document.getElementById('slug');
            
                titleInput.addEventListener('blur', () => {
                    slugInput.value = titleInput.value.toLowerCase().split(' ').join('-');
                });
            </script>
            <script>
                const imgInput = document.getElementById('image_url');
                const imgPreview = document.getElementById('image_preview');

                imgInput.addEventListener('change', () => {

                })
            </script>
            @endsection
            
        </div>
    </div>

</div>

