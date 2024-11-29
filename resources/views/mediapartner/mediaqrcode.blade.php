@extends('layouts.admin.tabler')

@section('content')
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <div class="page-pretitle">

                    </div>
                    <h2 class="page-title">

                    </h2>
                </div>

            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h2>QR Code Media</h2>
                        </div>
                        <div class="card-body text-center">
                            <h3>QR Code <br> {{ $getmedia->name }}</h3>
                            @php
                                $to_qrcode = $getmedia->kode_media."-".$getmedia->name
                            @endphp
                            <div>
                                {{ \SimpleSoftwareIO\QrCode\Facades\QrCode::size(250)->color(46,11,11)->generate($to_qrcode) }}
                            </div>



                        </div>
                        <div>
                            <center>
                                <a href="{{ route('datamedia') }}" class="btn btn-warning" style="color: white">Kembali</a>
                            </center>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script type="text/javascript">

    </script>
@endsection

@push('myscript')
    <script>
        $(function () {
            $("#dari, #sampai").datepicker({
                autoclose: true,
                todayHighlight: true,
                format: 'yyyy-mm-dd',
            });

            $(".tampilkanlaporan_whatssap_message_today_kanwil").click(function () {
                //alert("testing");
                var kode_satker_value = $(this).attr('kode_satker_value');
                //alert(kode_satker_value);
                $.ajax({
                    type: 'POST',
                    url: '{{ route('pilihkonfigurasi_kanwil') }}',
                    cache: false,
                    data: {
                        _token: "{{ csrf_token() }}",
                        kode_satker_value: kode_satker_value,
                    },
                    success: function (respond) {
                        console.log(respond);
                        $('#pilih_konfigurasi_body').html(respond);
                    },
                });
                $('#pilih_konfigurasi_modal').modal('show');

            });

            function checkSelectedFile(id) {


                fileName = document.querySelector('#' + id).value;
                extension = fileName.split('.').pop();


                if (document.getElementById(id).files.length == 0) {
                    console.log("no files selected");
                    $('#' + id).prop('required', true);
                    // $('.text-field').prop('required',true);
                } else {
                    console.log("there are files selected");
                    // $('#'+id).prop('required',false);

                    if (extension != 'pdf' && extension != 'doc' && extension != 'docx') {
                        alert("ekstensi file harus PDF, DOC, atau DOCX");

                        document.querySelector('#' + id).value = '';
                        $('#' + id).prop('required', true);
                    } else {
                        const oFile = document.getElementById(id).files[0];
                        console.log(id);
                        console.log(oFile);
                        $('#' + id).prop('required', false);

                        if (oFile.size > (5 * (1024 * 1024))) // 500Kb for bytes.
                        {
                            alert("size file terlalu besar");
                            document.querySelector('#' + id).value = '';
                            $('#' + id).prop('required', true);
                        }
                    }


                }

            }

            var max_fields = 100; //maximum input boxes allowed
            var max_fields_nasional = 100; //maximum input boxes allowed

            var wrapper = $(".input_fields_wrap"); //Fields wrapper
            var wrapper_nasional = $(".input_fields_wrap_nasional"); //Fields wrapper

            var add_button = $(".add_field_button"); //Add button ID
            var add_button_nasional = $(".add_field_button_nasional"); //Add button ID

            var x = 1; //initlal text box count
            var x_nasional = 1; //initlal text box count


            $(add_button).click(function (e) { //on add input button click
                e.preventDefault();
                if (x < max_fields) { //max input box allowed
                    x++; //text box increment

                    {{--$(wrapper).append('<div>' +--}}
                        {{--'<table class="m-l-15 col-lg-12" style="">' +--}}
                        {{--'<tr style="margin-top: 10px">' +--}}
                        {{--'<td>' +--}}


                        {{--'</td>' +--}}
                        {{--'<td style=""><div class="row"><div class=col-4><select required name="kode_media[]" id="kode_media[]" class="form-select"><option value="">-Nama Media-</option><option value="no media">-No Media-</option>' +--}}
                        {{--'@foreach($getmedia as $id=>$med)<option value="{{ $med->kode_media }}">{{ $med->name }}</option>@endforeach</select></div><div class="col-8"><input type="text" name="jumlah[]" id="jumlah[]" class="jumlah_medlok form-control" placeholder="Judul Berita|||Link Media Lokal"> </div></div>' +--}}
                        {{--'</td>' +--}}
                        {{--'</tr>' +--}}
                        {{--'</table>' +--}}
                        {{--'<a href="#" style="margin-left: 10px;" class="remove_field">Remove</a></div>');--}}
                    $('.myselect').select2();
                }
            });

            $(wrapper).on("click", ".remove_field", function (e) { //user click on remove text
                e.preventDefault();
                $(this).parent('div').remove();
                x--;
            });

            $(add_button_nasional).click(function (e) { //on add input button click
                e.preventDefault();
                if (x < max_fields_nasional) { //max input box allowed
                    x++; //text box increment

                    {{--$(wrapper_nasional).append('<div>' +--}}
                        {{--'<table class="m-l-15 col-lg-12" style="">' +--}}
                        {{--'<tr style="margin-top: 10px">' +--}}
                        {{--'<td>' +--}}


                        {{--'</td>' +--}}
                        {{--'<td style=""><div class="row"><div class="col-4"><select required name="kode_media_nasional[]" id="kode_media_nasional[]" class="form-select">' +--}}
                        {{--'<option value="">-Nama Media-</option><option value="no media">-No Media-</option>@foreach($getmedia as $idk=>$mednas)<option value="{{ $mednas->kode_media }}">{{ $mednas->name }}</option>@endforeach</select></div><div class="col-8"><input type="text" name="jumlah_nasional[]" id="jumlah_nasional[]" class="jumlah_mednas form-control" placeholder="Judul Berita|||Link Media Nasional" required ></div></div> ' +--}}

                        {{--'</td>' +--}}
                        {{--'</tr>' +--}}
                        {{--'</table>' +--}}
                        {{--'<a href="#" style="margin-left: 10px;" class="remove_field_nasional">Remove</a></div>');--}}
                    $('.myselect').select2();
                }
            });

            $(wrapper_nasional).on("click", ".remove_field_nasional", function (e) { //user click on remove text
                e.preventDefault();
                $(this).parent('div').remove();
                x--;
            });


            var counter = 0;

            $("#add-more").click(function (e) {
                var html3 = '<div class="form-group input-dinamis " style="margin-bottom: 10px; margin-top: 10px;"><div class="row">' +
                    '<div class="col-input-dinamis col-lg-10">' +
                    '<input type="text" name="url_files[]" class="form-control border-grey" ' +
                    'id="peserta' + counter + '" onchange="checkSelectedFile(id)" ' +
                    'placeholder="Link Media Lokal" required>' +
                    '</div>' +
                    '<div class="col-input-dinamis col-lg-2">' +
                    '<button class="btn btn-danger remove" type="button"><svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-backspace-filled" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M20 5a2 2 0 0 1 1.995 1.85l.005 .15v10a2 2 0 0 1 -1.85 1.995l-.15 .005h-11a1 1 0 0 1 -.608 -.206l-.1 -.087l-5.037 -5.04c-.809 -.904 -.847 -2.25 -.083 -3.23l.12 -.144l5 -5a1 1 0 0 1 .577 -.284l.131 -.009h11zm-7.489 4.14a1 1 0 0 0 -1.301 1.473l.083 .094l1.292 1.293l-1.292 1.293l-.083 .094a1 1 0 0 0 1.403 1.403l.094 -.083l1.293 -1.292l1.293 1.292l.094 .083a1 1 0 0 0 1.403 -1.403l-.083 -.094l-1.292 -1.293l1.292 -1.293l.083 -.094a1 1 0 0 0 -1.403 -1.403l-.094 .083l-1.293 1.292l-1.293 -1.292l-.094 -.083l-.102 -.07z" stroke-width="0" fill="currentColor" />' +
                    '</svg><' +
                    '/button>' +
                    '</div>' +
                    '</div>' +
                    '</div>';


                $('#auth-rows').append(html3);
                counter++;
            });

            $('#auth-rows').on('click', '.remove', function (e) {
                e.preventDefault();
                $(this).parents('.input-dinamis').remove();
            });

            var counter_nasional = 0;

            $("#add-more-nasional").click(function (e) {
                var html3 = '<div class="form-group input-dinamis-nasional " style="margin-bottom: 10px; margin-top: 10px;"><div class="row">' +
                    '<div class="col-input-dinamis-nasional col-lg-10">' +
                    '<input type="text" name="url_files_nasional[]" class="form-control border-grey" ' +
                    'id="peserta' + counter_nasional + '" onchange="checkSelectedFile(id)" ' +
                    'placeholder="Link Media Nasional" required>' +
                    '</div>' +
                    '<div class="col-input-dinamis-nasional col-lg-2">' +
                    '<button class="btn btn-danger remove-nasional" type="button"><svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-backspace-filled" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M20 5a2 2 0 0 1 1.995 1.85l.005 .15v10a2 2 0 0 1 -1.85 1.995l-.15 .005h-11a1 1 0 0 1 -.608 -.206l-.1 -.087l-5.037 -5.04c-.809 -.904 -.847 -2.25 -.083 -3.23l.12 -.144l5 -5a1 1 0 0 1 .577 -.284l.131 -.009h11zm-7.489 4.14a1 1 0 0 0 -1.301 1.473l.083 .094l1.292 1.293l-1.292 1.293l-.083 .094a1 1 0 0 0 1.403 1.403l.094 -.083l1.293 -1.292l1.293 1.292l.094 .083a1 1 0 0 0 1.403 -1.403l-.083 -.094l-1.292 -1.293l1.292 -1.293l.083 -.094a1 1 0 0 0 -1.403 -1.403l-.094 .083l-1.293 1.292l-1.293 -1.292l-.094 -.083l-.102 -.07z" stroke-width="0" fill="currentColor" />' +
                    '</svg><' +
                    '/button>' +
                    '</div>' +
                    '</div>' +
                    '</div>';


                $('#auth-rows-nasional').append(html3);
                counter_nasional++;
            });

            $('#auth-rows-nasional').on('click', '.remove-nasional', function (e) {
                e.preventDefault();
                $(this).parents('.input-dinamis-nasional').remove();
            });


            $('#btnTambahBeritaSatker').click(function () {
                $('#modal-inputberitasatker').modal('show');
            });

            $('.pilih_konfigurasi_berita').click(function () {
                var id_berita = $(this).attr('id_berita');
                var kode_satker = $(this).attr('kode_satker');
                // console.log(kode_satker);
                //alert(id_berita);
                //return false;

                $.ajax({
                    type: 'POST',
                    url: '{{ route('pilih_konfigurasi_berita') }}',
                    cache: false,
                    data: {
                        _token: "{{ csrf_token() }}",
                        id_berita: id_berita,
                        kode_satker: kode_satker,
                    },
                    success: function (respond) {
                        console.log(respond);
                        $('#loadedittampilkandetail_whatssap').html(respond);
                    }
                });
                $('#modal-tampilkandetail_whatssap').modal('show');
            });

            $('.tampilkandetail').click(function () {
                var id_berita = $(this).attr('id_berita');
                //alert(id_berita);
                //return false;
                $.ajax({
                    type: 'POST',
                    url: '{{ route('tampilkandetailberita') }}',
                    cache: false,
                    data: {
                        _token: "{{ csrf_token() }}",
                        id_berita: id_berita,
                    },
                    success: function (respond) {
                        $('#loadedittampilkandetail').html(respond);
                    }
                });
                $('#modal-tampilkandetail').modal('show');
            });

            $('.editberita').click(function () {
                var id_berita = $(this).attr('id_berita');
                //alert(id_berita);
                //return false;
                $.ajax({
                    type: 'POST',
                    url: '{{ route('editberita') }}',
                    cache: false,
                    data: {
                        _token: "{{ csrf_token() }}",
                        id_berita: id_berita,
                    },
                    success: function (respond) {
                        $('#loadeditform_berita').html(respond);
                    }
                });
                $('#modal-editsatkerberita').modal('show');
            });
            $('.edit').click(function () {
                var id_satker = $(this).attr('id_satker');
                //alert(id_satker);
                $.ajax({
                    type: 'POST',
                    url: '{{ route('satkeredit') }}',
                    cache: false,
                    data: {
                        _token: "{{ csrf_token() }}",
                        id_satker: id_satker,

                    },
                    success: function (respond) {
                        $('#loadeditform').html(respond);
                    }
                });
                $('#modal-editsatker').modal('show');
            });

            $('.delete-confirm-berita').click(function (e) {
                var form = $(this).closest('form');
                e.preventDefault();
                Swal.fire({
                    title: "Apakah Anda Yakin Data Ini Mau Di Hapus?",
                    text: "Jika Ya Maka Data Akan Terhapus Permanent",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Ya, Hapus Saja!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                        Swal.fire({
                            title: "Deleted!",
                            text: "Data Berhasil Dihapus",
                            icon: "success"
                        });
                    }
                });
            });


            $('#frmBeritaSatker').submit(function () {

                var kode_satker = $('#frmBeritaSatker').find('#kode_satker').val();
                var judul_berita_satker = $('#frmBeritaSatker').find('#judul_berita_satker').val();
                var facebook = $('#frmBeritaSatker').find('#facebook').val();
                var website = $('#frmBeritaSatker').find('#website').val();
                var instagram = $('#frmBeritaSatker').find('#instagram').val();
                var twitter = $('#frmBeritaSatker').find('#twitter').val();
                var tiktok = $('#frmBeritaSatker').find('#tiktok').val();
                var sippn = $('#frmBeritaSatker').find('#sippn').val();
                var youtube = $('#frmBeritaSatker').find('#youtube').val();

                if (kode_satker == "") {
                    //alert("NIK Harus Diisi");
                    Swal.fire({
                        title: 'Warning!',
                        text: 'Kode Satker Harus Diisi',
                        icon: 'warning',
                        confirmButtonText: 'Ok'
                    }).then((result) => {
                        $('#kode_satker').focus();
                    });
                    return false;
                } else if (judul_berita_satker == "") {
                    //alert("NIK Harus Diisi");
                    Swal.fire({
                        title: 'Warning!',
                        text: 'Judul Berita Harus Diisi',
                        icon: 'warning',
                        confirmButtonText: 'Ok'
                    }).then((result) => {
                        $('#judul_berita_satker').focus();
                    });
                    return false;
                } else if (facebook == "") {
                    //alert("NIK Harus Diisi");
                    Swal.fire({
                        title: 'Warning!',
                        text: 'Link Facebook Harus Diisi',
                        icon: 'warning',
                        confirmButtonText: 'Ok'
                    }).then((result) => {
                        $('#facebook').focus();
                    });
                    return false;
                } else if (website == "") {
                    //alert("NIK Harus Diisi");
                    Swal.fire({
                        title: 'Warning!',
                        text: 'Link Website Harus Diisi',
                        icon: 'warning',
                        confirmButtonText: 'Ok'
                    }).then((result) => {
                        $('#website').focus();
                    });
                    return false;
                } else if (instagram == "") {
                    //alert("NIK Harus Diisi");
                    Swal.fire({
                        title: 'Warning!',
                        text: 'Link Instagram Harus Diisi',
                        icon: 'warning',
                        confirmButtonText: 'Ok'
                    }).then((result) => {
                        $('#instagram').focus();
                    });
                    return false;
                } else if (twitter == "") {
                    //alert("NIK Harus Diisi");
                    Swal.fire({
                        title: 'Warning!',
                        text: 'Link Twitter Harus Diisi',
                        icon: 'warning',
                        confirmButtonText: 'Ok'
                    }).then((result) => {
                        $('#twitter').focus();
                    });
                    return false;
                } else if (tiktok == "") {
                    //alert("NIK Harus Diisi");
                    Swal.fire({
                        title: 'Warning!',
                        text: 'Link Tiktok Harus Diisi',
                        icon: 'warning',
                        confirmButtonText: 'Ok'
                    }).then((result) => {
                        $('#tiktok').focus();
                    });
                    return false;
                } else if (sippn == "") {
                    //alert("NIK Harus Diisi");
                    Swal.fire({
                        title: 'Warning!',
                        text: 'Link SIPPN Harus Diisi',
                        icon: 'warning',
                        confirmButtonText: 'Ok'
                    }).then((result) => {
                        $('#sippn').focus();
                    });
                    return false;
                } else if (youtube == "") {
                    //alert("NIK Harus Diisi");
                    Swal.fire({
                        title: 'Warning!',
                        text: 'Link Youtube Harus Diisi',
                        icon: 'warning',
                        confirmButtonText: 'Ok'
                    }).then((result) => {
                        $('#youtube').focus();
                    });
                    return false;
                }

                /*validasi link media lokal*/

                //return false;
                var jumlah_medlok = document.getElementsByClassName('jumlah_medlok');
                for (var i = 0; i <= jumlah_medlok.length; i++) {
                    //alert(jumlah_medlok[i].value);
                    if (jumlah_medlok[i].value == "") {
                        Swal.fire({
                            title: 'Warning!',
                            text: 'Link Media Lokal Belum Terisi Semua',
                            icon: 'warning',
                            confirmButtonText: 'Ok'
                        }).then((result) => {
                            $('#jumlah[' + i + ']').focus();
                        });
                        return false;
                    }
                }
                /*batas validasi link media lokal*/


            });

            {{--function loadberita(){--}}
            {{--var tanggal_awal = $('#tanggal_awal').val();--}}
            {{--var kode_satker = $('#kode_satker').val();--}}
            {{--//alert(kode_satker);--}}

            {{--$.ajax({--}}
            {{--type: 'POST',--}}
            // url: '/datasatker/'+ kode_satker +'/getberitabytanggal',
            {{--data: {--}}
            {{--_token: "{{ csrf_token() }}",--}}
            {{--tanggal_awal: tanggal_awal,--}}
            {{--},--}}
            {{--cache: false,--}}
            {{--success: function(respond){--}}
            {{--console.log(respond);--}}
            {{--}--}}
            {{--});--}}
            {{--}--}}
            {{--$('#tanggal_awal').change(function(e){--}}
            {{--loadberita();--}}
            {{--});--}}
            {{--loadberita();--}}
        });
    </script>
@endpush

