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

        .sheet {
            overflow: visible;
            height: auto !important;
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
            width: 75%;
            margin-top: 20px;
            border-collapse: collapse;

        }

        .tabelpresensi_summary {
            width: 70%;
            margin-top: 20px;
            border-collapse: collapse;
            font-size: 10px;

        }

        .tabelpresensi tr th {
            border: 1px solid #000000;
            padding: 3px;
            background: #f6ee1a;
        }

        .tabelpresensi_summary tr th {
            border: 1px solid #000000;
            padding: 3px;
            background: white;
        }

        .tabelpresensi tr td {
            border: 1px solid #000000;
            padding: 5px;
            font-size: 12px;
        }

        .tabelpresensi_summary tr td {
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
            <td colspan="7">
                <span id="title">
                     <center>REKAP BERITA MEDIA EXTERNAL (LOKAL) {{ strtoupper($satker_name) }}</center>
                    <br>
                    <center>PERIODE {{ $tgl_dari }} {{ strtoupper($namabulan[$bulan_dari]) }} {{ $tahun_dari }}
                        s.d. {{ $tgl_sampai }} {{ strtoupper($namabulan[$bulan_sampai]) }} {{ $tahun_sampai }}</center>
                </span>
            </td>
        </tr>
    </table>


    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-8 " style="display: inline-block;">
                    <table class="tabelpresensi" style="border-spacing: 0px;
            table-layout: fixed;
            margin-left: 30px;
            margin-right: auto;">


                        <tr style="">
                            <th style="width: 20px" rowspan="1" colspan="1">No</th>
                            <th style="width: auto" rowspan="1" colspan="1">Tgl Berita</th>
                            <th style="width: auto" rowspan="1" colspan="1">Judul / Isu Berita</th>
                            <th style="width: auto" rowspan="1" colspan="1">Media Lokal</th>
                            <th style="width: auto" rowspan="1" colspan="1">Link Berita</th>
                            <th style="width: auto" rowspan="1" colspan="1">Narasumber</th>
                            <th style="width: auto" rowspan="1" colspan="1">Sentimen Thd Isu</th>
                        </tr>
                        @php
                            $total_linklokal = 0;
                            $array_push_medlok = array();
                            $array_push_media_name = array();
                            $nama_media = array();
                            $push_named_lokal = array();
                            $get_datamedia = array();
                        @endphp
                        @foreach($getberita as $index=>$dtberita)
                            @php
                                /*untuk konversi tanggal ke tanggal indonesia*/
                                $namabulan = ["","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];
                                $tgl_input = $dtberita->tgl_input;
                                $exp_tglinput = explode('-',$tgl_input);
                                $tgl = $exp_tglinput[2];
                                $bln = $exp_tglinput[1];

                            if(substr($bln,0,1)==0){
                                $bln = substr($bln, 1,1);
                            }else if(substr($bln, 0,1)==1){
                                $bln = substr($bln, 0,2);
                            }

                            $thn = $exp_tglinput[0];
                            $links_media_lokal = json_decode($dtberita->media_lokal);

                            foreach ($links_media_lokal as $idx_medlok=>$dta_medlok){
                            if(!empty(explode("|||",$dta_medlok)[2])){
                                $link_medlok = explode("|||",$dta_medlok)[2];
                                if($link_medlok!="" && $link_medlok!="-"){
                                    $total_linklokal +=1;
                                } else if($link_medlok=="" && $link_medlok=="-"){
                                    $total_linklokal +=0;
                                }
                            } else if(empty(explode("|||",$dta_medlok)[2])){
                                $total_linklokal += 0;
                            }

                            }

                            //$total_linklokal += count($links_media_lokal);
                            foreach ($links_media_lokal as $id=>$link_media_lokal){
                                 $kode_media = explode("|||",$link_media_lokal)[0];
                                 $nama_media = DB::table('mediapartner')->where('kode_media',$kode_media)->get();
                            }

                            @endphp
                            @php
                                $dt_named = array();
                                $dt_linkberita = array();
                            @endphp
                            <tr class="overflowtes">
                                <td style="width: 20px;  text-align: center" rowspan="1"
                                    colspan="1">{{ $index+1 }}</td>
                                <td style="display: flex;width: auto; text-align: center; justify-content: center;align-items: center"
                                    rowspan=""
                                    colspan="1">{{ $tgl }} {{ $namabulan[$bln] }} {{ $thn }}</td>
                                <td style="width: auto; text-align: center" rowspan=""
                                    colspan="1">{{ $dtberita->nama_berita }}</td>
                                <td style="width: auto; text-align: left" rowspan=""
                                    colspan="1">
                                    @php

                                        /*1 $links_media_lokal = 1 $dtberita*/
                                        foreach ($links_media_lokal as $id=>$link_media_lokal){
                                            $kode_media = explode("|||",$link_media_lokal)[0];
                                            $link_berita = explode("|||",$link_media_lokal)[2];

                                            $nama_media = DB::table('mediapartner')->where('kode_media',$kode_media)->get();
                                            //echo "link : ".$link_berita."<br>";
                                            array_push($dt_linkberita,(object)[
                                                "newslink"=>$link_berita,
                                            ]);
                                            foreach ($nama_media as $no_index=>$dtmedia){
                                                array_push($dt_named,(object)[
                                                    "kode_media"=>$dtmedia->kode_media,
                                                    "media_name"=>$dtmedia->name,
                                                ]);
                                            }

                                        }
                                    @endphp

                                    @if(count($dt_named) <= 0)
                                        <span>No Media Exists</span>
                                    @elseif(count($dt_named) > 0 )
                                        @foreach($dt_named as $it=>$item)
                                            {!! $loop->iteration.".".$item->media_name."<br>" !!} <br>
                                        @endforeach
                                    @endif

                                </td>
                                <td>
                                    @if(count($dt_linkberita) <= 0)
                                        <span>No Link Exists</span>
                                    @elseif(count($dt_linkberita) > 0 )
                                        @foreach($dt_linkberita as $itnews=>$itemnews)
                                            {!! $loop->iteration.".".$itemnews->newslink."<br>" !!} <br>
                                        @endforeach
                                    @endif
                                </td>
                                <td style="text-align: center">
                                    -
                                </td>
                                <td style="text-align: center">
                                    -
                                </td>

                            </tr>

                        @endforeach


                    </table>
                </div>

                {{--untuk summary tabel sebelah kanan--}}
                <br>
                <div class="col-4 "
                     style="display: inline-block; position: absolute; top: 0px; left: -10px; right: 900px">
                    <table class="tabelpresensi_summary" style="position: absolute; left: 900px; top: 85px; border-spacing: 0px;
            table-layout: fixed;
            margin-left: 30px;
            margin-right: auto;">

                        <tr class="" style="">
                            <th style="width: auto" rowspan="1" colspan="1">Jml Total Berita Dimuat</th>
                            <th style="width: auto" rowspan="1" colspan="1">{{ $total_linklokal }}</th>

                        </tr>

                        <tr class="" style="">
                            <th style="width: auto" rowspan="1" colspan="1">Jml Berita Sentimen Positif</th>
                            <th style="width: auto" rowspan="1" colspan="1">-</th>

                        </tr>

                        <tr class="" style="">
                            <th style="width: auto" rowspan="1" colspan="1">Jml Berita Sentimen Negatif</th>
                            <th style="width: auto" rowspan="1" colspan="1">-</th>

                        </tr>


                    </table>
                </div>

                {{--untuk summary tabel sebelah kanan2--}}
                <br>
                <div class="col-4 "
                     style="display: inline-block; position: absolute; top: 150px; left: -10px; right: 900px">
                    <table class="tabelpresensi_summary" style="position: absolute; left: 900px; top: 85px; border-spacing: 0px;
            table-layout: fixed;
            margin-left: 30px;
            margin-right: auto;">

                        <tr class="" style="">
                            <th style="width: auto" rowspan="1" colspan="2">Jml Berita Per Media</th>

                        </tr>
                        @php
                            $total_counting3 = 0;
                        @endphp
                        @if(count($mediapartner)>0)
                            @foreach($mediapartner as $it=>$dy)
                                @if($dy->jenis_media=="media_lokal")
                                    <tr>
                                        <td>{{ $dy->name }}</td>
                                        <td align="center" valign="center"
                                            style="font-weight: bold; font-size: 10px; background: white"
                                            colspan="1">
                                            @php
                                                $counting3=0;
                                            @endphp
                                            @foreach($getberita as $ig=>$dg)
                                                @php
                                                    $newslink_lokal= json_decode($dg->media_lokal);
                                                    $counting2 = 0;
                                                @endphp
                                                @php
                                                    foreach ($newslink_lokal as $ix=>$dx){
                                                        if($dy->kode_media == explode("|||",$dx)[0]){
                                                            $counting2 += 1;
                                                        }
                                                    }
                                                @endphp
                                                @php
                                                    $counting3 += $counting2;
                                                @endphp
                                            @endforeach
                                            {{ $counting3 }}
                                            @php
                                                $total_counting3 += $counting3;
                                            @endphp
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        @elseif(count($mediapartner)<=0)
                            <tr>
                                <td>No Data</td>
                                <td>No Data</td>
                            </tr>
                        @endif



                        {{--<tr class="" style="">--}}
                        {{----}}
                        {{--<th style="width: auto" rowspan="1" colspan="1">Jml Berita Sentimen Positif</th>--}}
                        {{--<th style="width: auto" rowspan="1" colspan="1">0</th>--}}

                        {{--</tr>--}}

                        <tr class="" style="">
                            <th style="width: auto" rowspan="1" colspan="1">Total</th>
                            <th style="width: auto" rowspan="1" colspan="1">{{ $total_counting3 }}</th>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

</section>

</body>

</html>