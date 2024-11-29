<form action="#" id="frmDetailMedia" name="frmDetailMedia" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-12">
            <div>Kode Media</div>
            <div class="input-icon mb-3">
                <div class="form-group col-lg-12"
                     style="justify-items: end;  ">
                    <div class="row m-l-1" style=" overflow: auto;  ">
                        <a class="col-12" style="text-decoration: none"
                           href="{{ $datamedia->kode_media }}"
                           target="">

                            {{ $datamedia->kode_media }}
                        </a>
                    </div>

                </div>


            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div>Nama Media</div>
            <div class="input-icon mb-3">
                <div class="form-group col-lg-12"
                     style="justify-items: end;  ">
                    <div class="row m-l-1" style=" overflow: auto;  ">
                        <a class="col-12" style="text-decoration: none"
                           href="{{ $datamedia->name }}"
                           target="">

                            {{ $datamedia->name }}
                        </a>
                    </div>

                </div>


            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div>Nama Media</div>
            <div class="input-icon mb-3">
                <div class="form-group col-lg-12"
                     style="justify-items: end;  ">
                    <div class="row m-l-1" style=" overflow: auto;  ">
                        <a class="col-12" style="text-decoration: none"
                           href="{{ $datamedia->username }}"
                           target="">

                            {{ $datamedia->username }}
                        </a>
                    </div>

                </div>


            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div>Email</div>
            <div class="input-icon mb-3">
                <div class="form-group col-lg-12"
                     style="justify-items: end;  ">
                    <div class="row m-l-1" style=" overflow: auto;  ">
                        <a class="col-12" style="text-decoration: none"
                           href="{{ $datamedia->email }}"
                           target="">

                            {{ $datamedia->email }}
                        </a>
                    </div>

                </div>


            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div>Nomor Handphone</div>
            <div class="input-icon mb-3">
                <div class="form-group col-lg-12"
                     style="justify-items: end;  ">
                    <div class="row m-l-1" style=" overflow: auto;  ">
                        <a class="col-12" style="text-decoration: none"
                           href="{{ $datamedia->no_hp }}"
                           target="">

                            {{ $datamedia->no_hp }}
                        </a>
                    </div>

                </div>


            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div>Jenis Media</div>
            <div class="input-icon mb-3">
                <div class="form-group col-lg-12"
                     style="justify-items: end;  ">
                    <div class="row m-l-1" style=" overflow: auto;  ">
                        <a class="col-12" style="text-decoration: none"
                           href="{{ $datamedia->jenis_media }}"
                           target="">

                            {{ ucfirst(explode("_",$datamedia->jenis_media)[0])." ".ucfirst(explode("_",$datamedia->jenis_media)[1]) }}
                        </a>
                    </div>

                </div>


            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div>Satker Penjalin</div>
            <div class="input-icon mb-3">
                <div class="form-group col-lg-12"
                     style="justify-items: end;  ">
                    <div class="row m-l-1" style=" overflow: auto;  ">
                        <a class="col-12" style="text-decoration: none"
                           href="{{ $data_satker_penjalin->kode_satker }}"
                           target="">

                            {{ $data_satker_penjalin->name }}
                        </a>
                    </div>

                </div>


            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div>Foto Media</div>
            <div class="input-icon mb-3">
                <div class="form-group col-lg-12"
                     style="justify-items: end;  ">
                    <div class="row m-l-1" style=" overflow: auto;  ">
                        <center>
                            @php
                                $path = Storage::url('uploads/mediapartner/'.$datamedia->foto);
                            @endphp
                            @if(empty($datamedia->foto))
                                <img style="width: 300px; height: 300px" src="{{ url('assets/img/no-photo.png') }}" class="avatar"
                                     alt="">
                            @else
                                <img style="width: 300px; height: 300px" src="{{ url($path) }}" class="avatar" alt="">
                            @endif

                        </center>
                    </div>

                </div>


            </div>
        </div>
    </div>




</form>