@extends('layout_admin.v_index')
@section('title', 'Edit Project')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2" style="align-items: flex-end">
            <div class="col-sm-6">
                <h1 class="m-0">Detail Project</h1>
                <ol class="breadcrumb float-sm">
                    <li class="breadcrumb-item"><a href="/admin/project">Project</a></li>
                    <li class="breadcrumb-item active">Detail Project</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>

<section class="content">
    <div class="container-fluid">

        <form action="/admin/project/update/{{ $project->id_project }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="content">

                <h4>Title</h4>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="nav-icon fa fa-shopping-bag"></i></span>
                    </div>
                    <input type="text" name="title" class="form-control" value="{{ $project->title }}">
                    <div class="text-danger">
                        @error('title')
                        {{ $message }}
                        @enderror
                    </div>
                </div>


                <h4>Type</h4>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="nav-icon fa fa-file-alt"></i></span>
                    </div>
                    <input type="text" name="type" class="form-control" value="{{ $project->type }}">
                    <div class="text-danger">
                        @error('type')
                        {{ $message }}
                        @enderror
                    </div>
                </div>


                <h4>Area Size</h4>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="nav-icon fa fa-money-bill"></i></span>
                    </div>
                    <input type="number" name="area_size" class="form-control" value="{{ $project->area_size }}">
                    <div class="text-danger">
                        @error('area_size')
                        {{ $message }}
                        @enderror
                    </div>
                </div>

                <h4>Design Style</h4>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="nav-icon fa fa-chart-line"></i></span>
                    </div>
                    <input type="text" name="design_style" class="form-control" value="{{ $project->design_style }}">
                    <div class="text-danger">
                        @error('design_style')
                        {{ $message }}
                        @enderror
                    </div>
                </div>

                <h4>Address</h4>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="nav-icon fa fa-chart-line"></i></span>
                    </div>
                    <input type="text" name="address" class="form-control" value="{{ $project->address }}">
                    <div class="text-danger">
                        @error('address')
                        {{ $message }}
                        @enderror
                    </div>
                </div>

                <h4>Status</h4>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="nav-icon fa fa-chart-line"></i></span>
                    </div>
                    <input type="text" name="status" class="form-control" value="{{ $project->status }}">
                    <div class="text-danger">
                        @error('status')
                        {{ $message }}
                        @enderror
                    </div>
                </div>

                <h4>Date</h4>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="nav-icon fa fa-calendar-alt"></i></span>
                    </div>
                    <input type="date" name="date" class="form-control" value="{{ $project->date }}">
                    <div class="text-danger">
                        @error('date')
                        {{ $message }}
                        @enderror
                    </div>
                </div>

                <h4>Description</h4>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="nav-icon fa fa-calendar-alt"></i></span>
                    </div>
                    <input type="text" name="description" class="form-control" value="{{ $project->description }}">
                    <div class="text-danger">
                        @error('description')
                        {{ $message }}
                        @enderror
                    </div>
                </div>


                <div class="col-sm-12">
                    <div class="col-sm-4">
                        <img src="{{ asset('storage/image_admin/project/'.$project->image_thumbnail) }}" width="100px">
                    </div>
                    <div class="form-group">
                        <h4>Image Thumbnail</h4>
                        <input id="input-fa" type="file" name="image_thumbnail" class="form-control file"
                            value="{{ old('image_thumbnail') }}" data-browse-on-zone-click="true">
                        <div class="text-danger">
                            @error('image_thumbnail')
                            {{ $message }}
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="col-sm-12">
                    <div class="col-sm">
                        @foreach ($detail_project as $item)
                        <img src="{{ asset('storage/image_admin/project_detail/'.$item->image_detail) }}" width="100px">
                        @endforeach
                    </div>
                    <div class="form-group">
                        <h4>Image Detail</h4>
                        <input id="input-fa" type="file" name="detailImage[]" class="form-control file"
                            value="{{ old('detailImage') }}" data-browse-on-zone-click="true" multiple>
                        <div class="text-danger">
                            @error('detailImage')
                            {{ $message }}
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <a href="/admin/project" class="btn btn-danger btn-sm">Kembali</a>
                    <button type="submit" class="btn btn-primary btn-sm"> Simpan</button>
                </div>
            </div>
        </form>

    </div><!-- /.container-fluid -->
</section>
@endsection
