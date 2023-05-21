@extends('admin.article.layout')

@section('content')
    <h2>Form Tambah Data Berita</h2>
    <div class="container" style="padding: 24px; background-color:white">
        <form method="post" action="{{ url('artikel') }}" enctype="multipart/form-data">
            @csrf
            <div class="body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class="font-weight-bold">Judul Berita</label>
                            <input type="text" name="judul" class="form-control" placeholder="Inputkan Judul Berita" />
                        </div>
                    </div>
                    <div class="row g-2" style="margin-bottom: 16px">
                        <div class="col-lg-6">
                            <label for="image" class="form-label"
                                style="margin-left: 16px; margin-bottom: 16px">Image</label>
                            <input type='file' name="image" id="imgInp" class="form-control" />
                        </div>
                        <div class="col-lg-12">
                            <label class="font-weight-bold">Deskripsi Berita</label>
                            <textarea id="konten" name="deskripsi" rows="4" class="form-control" cols="50"></textarea>
                        </div>
                        <div class="col-lg-6">
                            <label for="status" class="form-label">Status</label>
                            <div class="form-check mt-3">
                                <input type="hidden" name="status" value="0">
                                <input type="checkbox" value="1" class="form-check-input" id="scales"
                                    name="status">
                                <label class="form-check-label" for="defaultCheck1"> Status </label>
                            </div>
                        </div>
                    </div>
                    <div class="row g-2" style="margin-top: 16px">
                        <div class="col mb-0">
                            <img width="200px" id="blah" src="http://placehold.it/180" alt="your image" />
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="/artikel" class="btn btn-outline-secondary">Close</a>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
        </form>
    </div>

    <script>
        imgInp.onchange = evt => {
            const [file] = imgInp.files
            if (file) {
                blah.src = URL.createObjectURL(file)
            }
        }
    </script>
@endsection
