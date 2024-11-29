<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>A4</title>

    <!-- Normalize or reset CSS with your favorite library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">

    <!-- Load paper.css for happy printing -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.4.1/paper.css">

    <!-- Set page size here: A5, A4 or A3 -->
    <!-- Set also "landscape" if you need -->
    <style>
        .overflowtes td {
            border: 1px solid black;
            word-wrap: break-word;
        }

        .tdcolor {
            background: #cccaca;
            font-weight: bold;
            font-size: 20px;
        }
    </style>
    <style>@page {
            size: A4 landscape;
        }

        #title {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 18px;
            font-weight: bold;
        }

        .tabeldatakaryawan {
            margin-top: 40px;
        }

        .tabeldatakaryawan tr td {
            padding: 5px;
        }

        .tabelpresensi {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        .tabelpresensi tr th {
            border: 1px solid #000000;
            padding: 8px;
            background: #cccaca;
        }

        .tabelpresensi tr td {
            border: 1px solid #000000;
            padding: 5px;
            font-size: 12px;
        }

        .foto {
            width: 40px;
            height: 30px;
        }
    </style>
</head>

<!-- Set "A5", "A4" or "A3" for class name -->
<!-- Set also "landscape" if you need -->
<body class="A4 landscape">


<!-- Each sheet element should have the class "sheet" -->
<!-- "padding-**mm" is optional: you can set 10, 15, 20 or 25 -->
<section class="sheet padding-10mm">

    <!-- Write HTML just like a web page -->
    <table style="width: 100%">
        <tr>
            <td colspan="11">
                <span id="title">
                    <center>REKAPITULASI PUBLIKASI MEDIA LOKAL {{ strtoupper($satker_name) }}</center>
                    <br>
                    <center>PERIODE {{ $tgl_dari }} {{ strtoupper($namabulan[$bulan_dari]) }} {{ $tahun_dari }}
                        s.d. {{ $tgl_sampai }} {{ strtoupper($namabulan[$bulan_sampai]) }} {{ $tahun_sampai }}</center>
                </span>
            </td>
        </tr>
    </table>
    <table class="tabeldatakaryawan">
        <tr>
            <td rowspan="">

            </td>
        </tr>


    </table>
    <table class="tabelpresensi">
        <tr>
            <th style="width: 2%" rowspan="2" colspan="1">No</th>
            <th style="width: 9%" rowspan="2" colspan="1">Tgl</th>
            <th rowspan="1" colspan="{{ $size_mediapartner }}">Nama Media Lokal</th>
        </tr>
        <tr>
            @if($mediapartner->count()>0)
                @foreach($mediapartner as $idx=>$media)
                    <th>{{ $media->name }}</th>
                @endforeach
            @elseif($mediapartner->count()<=0)
                <th>Belum Ada Media</th>
            @endif

        </tr>
        @php
            $total_per_media = [];
            $total_counting = [];
        @endphp
        @foreach($getberita as $index=>$berita)
            @php
                $links_media_lokal = json_decode($berita->media_lokal);
                $counter = 0;
                $total_all_media_last=0;
                $total_all_media=0;
                $totalnya=0;
            @endphp
            <tr class="overflowtes">
                @php
                    $namabulan = ["","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];
                    $tgl_input = $berita->tgl_input;
                    $exp_tgl_input = explode('-',$tgl_input);
                    $tgl = $exp_tgl_input[2];
                    $bulan = $exp_tgl_input[1];

                    /*supaya jika muncul index bulan 01,02,03 dst berubah jadi 1,2,3 dst*/
                    if(substr($bulan,0,1)==0){
                        $bulan = substr($bulan,1,1);
                    } else if(substr($bulan,0,1)==1){
                        $bulan = substr($bulan,0,2);
                    }

                    $tahun = $exp_tgl_input[0];
                @endphp
                <td style="text-align: center">{{ $loop->iteration }}</td>
                <td style="text-align: center">{{ $tgl }} {{ $namabulan[$bulan] }} {{ $tahun }}</td>
                @php
                    $total=0;
                @endphp
                @if($mediapartner->count()>0)
                    @foreach($mediapartner as $idx=>$media)
                        <td>
                            @php
                                $total_per_media[$idx] = $idx;
                                $counting = 0;
                                $cont = [];
                            @endphp
                            @foreach($links_media_lokal as $il=>$dl)
                                @if($media->kode_media==explode("|||",$dl)[0])
                                    @php
                                        $counting +=1;
                                        $total_counting[$il] = $counting+1;
                                        $total += $counting;

                                    @endphp
                                    {{--untuk tampilan text link:--}}
                                    @php
                                        $dt_linkberita = explode("|||",$dl);
                                        if(!empty($dt_linkberita[2])){
                                            echo $counting.".".$dt_linkberita[2]."<br>";
                                        }
                                        if(empty($dt_linkberita[2])){
                                            echo $counting."."."tittle or link doesnt exist yet"."<br>";
                                        }
                                    @endphp
                                    @php $total_per_media[$idx]+= $counting; @endphp
                                @elseif($media->kode_media!=explode("|||",$dl)[0])
                                    @php
                                        $total = 0;
                                    @endphp
                                @endif
                                @php

                                        @endphp
                            @endforeach

                            @php

                                //echo "jumlahnya : ".$counting."<br>";
                                    $total_all_media += $counting;
                            @endphp
                            @php
                                $total_per_media[$idx] = $counting;
                            @endphp
                        </td>
                    @endforeach
                @elseif($mediapartner->count()<=0)
                    <td align="center" valign="center" style="font-size: 15px; ">
                        No Data
                    </td>
                @endif

            </tr>
        @endforeach
        <tr>
            <td align="center" valign="center" style="font-weight: bold; font-size: 15px; background: #eceaea"
                colspan="2">Jumlah
            </td>
            @if($mediapartner->count()>0)
                @foreach($mediapartner as $it=>$dy)
                    <td align="center" valign="center" style="font-weight: bold; font-size: 15px; background: #eceaea"
                        colspan="1">
                        {{--{{ $dy->kode_media }}--}}
                        @php
                            $counting3=0;
                        @endphp
                        @foreach($getberita as $ig=>$dg)
                            @php
                                $dt_json_medlok = json_decode($dg->media_lokal);
                              //print_r($dt_json_medlok);
                             $counting2 = 0;
                            @endphp
                            <?php
                            foreach ($dt_json_medlok as $ix => $dx) {
                                //echo explode("|||", $dx)[0] . "<br>";
                                if ($dy->kode_media == explode("|||", $dx)[0]) {
                                    $counting2 += 1;
                                }
                            }
                            ?>
                            @php $counting3 += $counting2 @endphp

                        @endforeach
                        {{ $counting3 }}
                    </td>
                @endforeach
            @elseif($mediapartner->count()<=0)
                <td align="center" valign="center" style="font-weight: bold; font-size: 15px; background: #eceaea">
                    No Count
                </td>
            @endif


        </tr>

    </table>
    <table width="100%" style="margin-top: 100px">
        <tr style="color: white;">
            <td colspan="2" style="text-align: right;">Mataram, {{ date('d-m-Y') }}</td>
        </tr>
        <tr>
            <td style="color: white;text-align: center; vertical-align: bottom" height="100px">
                <u>Qiana Kalila</u><br>
                <i><b>HRD Manager</b></i>
            </td>
            <td style="color: white;text-align: center; vertical-align: bottom">
                <u>Dafa</u><br>
                <i><b>Direktur</b></i>
            </td>
        </tr>
    </table>
</section>

</body>

</html>