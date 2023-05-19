@extends('layouts.app')

@section('title', 'Edit Product '.$product[0]->nama)

@push('style')

@endpush

@section('main')<div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Edit Product {{$product[0]->nama}}</h1>
                <div class="section-header-breadcrumb">
                    <a href="{{route('manajemen-product')}}" class="btn btn-sm btn-warning">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-md-12">
                        <form id="setting-form" action="{{url("process-update-product")}}/{{$product[0]->id}}" method="POST" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="card" id="settings-card">
                              <div class="card-header">
                                <h4>Tambah Product</h4>
                              </div>
                              <div class="card-body">
                                {{-- <p class="text-muted">General settings such as, site title, site description, address and so on.</p> --}}
                                <div class="row">
                                  <div class="col-md-6">
                                    <div class="row">
                                      <div class="form-group col-md-12">
                                        <label for="nama" class="form-control-label">Nama <span class="text-danger h6"><b>*</b></span></label>
                                        <div class="">
                                          <input type="text" name="nama" class="form-control" id="nama" value="{{$product[0]->nama}}" required>
                                        </div>
                                      </div>
                                      {{-- <div class="form-group col-md-6">
                                          <label for="stock" class="form-control-label">Stock <span class="text-danger h6"><b>*</b></span></label>
                                          <div class="">
                                            <input type="number" name="stock" class="form-control" id="stock" placeholder="100" required>
                                          </div>
                                      </div> --}}
                                    </div>
                                    <div class="row">
                                      <div class="form-group col-md-6">
                                          <label for="harga" class="form-control-label">Harga <span class="text-danger h6"><b>*</b></span></label>
                                          <div class="">
                                            <input type="number" name="harga" class="form-control" required id="harga" value="{{$product[0]->price}}" placeholder="1000">
                                          </div>
                                      </div>
                                      <div class="form-group col-md-6">
                                          <label for="jenis" class="form-control-label">Jenis <span class="text-danger h6"><b>*</b></span></label>
                                          <div class="">
                                            <select class="form-control select2-tags" name="jenis" required>
                                              {{-- <option value="">Pilih atau Ketik (jenis Baru)</option> --}}
                                              @forelse ($jenis as $item)
                                                  <option value="{{$item->id}}" {{$product[0]->jenis == $item->id ? "selected" : ""}}>{{$item->name}}</option>
                                              @empty
                                                  
                                              @endforelse
                                            </select>
                                          </div>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    @if (auth()->user()->id_role == 2 or auth()->user()->id_role == 1 )
                                      <div class="form-group">
                                          <label for="tenant" class="form-control-label">Tenant <span class="text-danger h6"><b>*</b></span></label>
                                          <select class="form-control select2" name="tenant" required>
                                            <option value="">Pilih Tenant</option>
                                            @forelse ($userTenant as $item)
                                                <option value="{{$item->id}}" {{$product[0]->id_user == $item->id ? "selected" : ""}}>{{$item->name}}</option>
                                            @empty
                                                
                                            @endforelse
                                          </select>
                                      </div>
                                    @endif
                                    <div class="form-group">
                                      <label for="site-description" class="form-control-label">Deskripsi</label>
                                      <div class="">
                                        <textarea class="form-control" name="desc" style="height:45px" id="site-description">{{$product[0]->desc}}</textarea>
                                      </div>
                                    </div>
                                    <div class="form-group">
                                      <label class="">Keterangan : </label>
                                      <br>
                                      <span class="text-danger h5"><b>*</b></span> Wajib Isi
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="card-footer bg-whitesmoke text-center">
                                <button type="submit" class="btn btn-lg btn-primary" id="save-btn"><i class="fa fa-save"></i> Update</button>
                                <button class="btn btn-warning btn-lg" type="reset" ><i class="fa fa-refresh"></i> Reset</button>
                              </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')

    <script>
      var uploadField = document.getElementById("file-input");

        uploadField.onchange = function() {
            if(this.files[0].size > 2097152){
              alert("File is too big!");
              this.value = "";
              document.getElementById("label-file").innerHTML= "Choose File"
            }else{
              document.getElementById("label-file").innerHTML= this.files[0].name
            }
        };

    </script>
    <!-- Page Specific JS File -->
@endpush
