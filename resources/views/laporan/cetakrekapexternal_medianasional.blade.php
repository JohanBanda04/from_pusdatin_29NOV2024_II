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
            <td style="width: 30px">
                {{--<img src="{{ asset('assets/img/logopresensi.png') }}" width="70" height="70" alt="">--}}
            </td>
            <td>
                <center>
                    <span id="title">
                   REKAP BERITA MEDIA EXTERNAL (NASIONAL)<br>
                        PERIODE {{ $tgl_dari }} {{ strtoupper($namabulan[$bulan_dari]) }} {{ $tahun_dari }}
                        s.d. {{ $tgl_sampai }} {{ strtoupper($namabulan[$bulan_sampai]) }} {{ $tahun_sampai }}

                        <br>
                </span>
                </center>

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
                            <th style="width: auto" rowspan="1" colspan="1">Media Nasional</th>
                            <th style="width: auto" rowspan="1" colspan="1">Link Berita</th>
                            <th style="width: auto" rowspan="1" colspan="1">Narasumber</th>
                            <th style="width: auto" rowspan="1" colspan="1">Sentimen Thd Isu</th>
                        </tr>
                        @php
                            $total_linknasional = 0;
                            $array_push_mednas= array();
                            $array_push_media_name_nasional = array();
                            $nama_media_nasional = array();
                            $push_named_nasional = array();
                            $get_datamedia_nasional = array();
                            $hitung_link_external = array();
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
                            $links_media_nasional = json_decode($dtberita->media_nasional);

                            foreach ($links_media_nasional as $idx_mednas=>$dta_mednas){
                                //$link_mednas = explode("|||",$dta_mednas)[2];
                                if(!empty(explode("|||",$dta_mednas)[2])){
                                    $link_mednas = explode("|||",$dta_mednas)[2];
                                    if($link_mednas !="" && $link_mednas!="-"){
                                        $total_linknasional +=1;
                                    } else if($link_mednas =="" && $link_mednas=="-"){
                                        $total_linknasional +=0;
                                    }
                                } else if(empty(explode("|||",$dta_mednas)[2])){
                                    $total_linknasional +=0;
                                }

                            }

                            foreach ($links_media_nasional as $id=>$link_media_nasional){
                                 $kode_media_nasional = explode("|||",$link_media_nasional)[0];
                                 $nama_media = DB::table('mediapartner')->where('kode_media',$kode_media_nasional)->get();
                            }

                            @endphp
                            @php
                                $dt_named_nasional = array();
                                $dt_linkberita_nasional = array();
                            @endphp
                            <tr class="overflowtes">
                                <td style="width: auto; text-align: center" rowspan=""
                                    colspan="1">{{ $index+1 }}</td>
                                <td style="width: auto; text-align: center" rowspan=""
                                    colspan="1">{{ $tgl }} {{ $namabulan[$bln] }} {{ $thn }}</td>
                                <td style="width: auto; text-align: center" rowspan=""
                                    colspan="1">{{ $dtberita->nama_berita }}</td>
                                {{--<td style="width: auto; text-align: center" rowspan=""--}}
                                {{--colspan="1">{{ count($links_media_lokal) }}</td>--}}
                                <td style="width: auto; text-align: left" rowspan=""
                                    colspan="1">
                                    @php

                                        /*1 $links_media_nasional = 1 $dtberita*/
                                        foreach ($links_media_nasional as $id=>$link_media_nasional){
                                            $kode_media_nasional = explode("|||",$link_media_nasional)[0];
                                            if(!empty(explode("|||",$link_media_nasional)[2])){
                                                $link_berita_nasional = explode("|||",$link_media_nasional)[2];
                                                array_push($dt_linkberita_nasional,(object)[
                                                    "newslink"=>$link_berita_nasional,
                                                ]);
                                            } /*else if(empty(explode("|||",$link_media_nasional)[2])){
                                                array_push($dt_linkberita_nasional,(object)[
                                                    "newslink"=>"no link nasional",
                                                ]);
                                            }*/

                                            $nama_media_nasional = DB::table('mediapartner')->where('kode_media',$kode_media_nasional)->get();
                                            //echo "link : ".$link_berita."<br>";

                                            foreach ($nama_media_nasional as $no_index=>$dtmedia_nasional){
                                                array_push($dt_named_nasional,(object)[
                                                    "kode_media"=>$dtmedia_nasional->kode_media,
                                                    "media_name"=>$dtmedia_nasional->name,
                                                ]);
                                            }

                                        }
                                    @endphp

                                    @if(count($dt_named_nasional) <= 0)
                                        <span>No Media Exists</span>
                                    @elseif(count($dt_named_nasional) > 0 )
                                        @foreach($dt_named_nasional as $it=>$item_nasional)
                                            {!! $loop->iteration.".".$item_nasional->media_name."<br>" !!} <br>
                                        @endforeach
                                    @endif

                                </td>
                                <td>
                                    @if(count($dt_linkberita_nasional) <= 0)
                                        <span>No Link Exists</span>
                                    @elseif(count($dt_linkberita_nasional) > 0 )
                                        @foreach($dt_linkberita_nasional as $itnews=>$itemnews_nasional)
                                            {!! $loop->iteration.".".$itemnews_nasional->newslink."<br>" !!} <br>
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
                <div class="col-4 "
                     style="display: inline-block; position: absolute; top: 0px; left: -10px; right: 900px">
                    <table class="tabelpresensi_summary" style="position: absolute; left: 900px; top: 85px; border-spacing: 0px;
            table-layout: fixed;
            margin-left: 30px;
            margin-right: auto;">

                        <tr class="" style="">
                            {{--ASLIII--}}
                        @php
                            $total_counting3_all = 0;
                        @endphp
                        @if(count($mediapartner)>0)
                            @foreach($mediapartner as $it=>$dy)
                                @if($dy->jenis_media=="media_nasional")





                                            @php
                                                $counting3_all=0;
                                            @endphp
                                            @foreach($getberita as $ig=>$dg)
                                                @php
                                                    $newslink_nasional= json_decode($dg->media_nasional);
                                                    $counting2_all = 0;
                                                @endphp
                                                @php
                                                    foreach ($newslink_nasional as $ix=>$dx){
                                                        if($dy->kode_media == explode("|||",$dx)[0]){
                                                            $counting2_all += 1;
                                                        }
                                                    }
                                                @endphp
                                                @php
                                                    $counting3_all += $counting2_all;
                                                @endphp
                                            @endforeach

                                            @php
                                                $total_counting3_all += $counting3_all;
                                            @endphp


                                @endif

                            @endforeach
                        @elseif(count($mediapartner)<=0)

                        @endif
                            <th style="width: auto" rowspan="1" colspan="1">Jml Total Berita Dimuat</th>
                            <th style="width: auto" rowspan="1" colspan="1">{{ $total_linknasional }}</th>

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
                <div class="col-4 "
                     style="display: inline-block; position: absolute; top: 120px; left: -10px; right: 900px">
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
                                @if($dy->jenis_media=="media_nasional")
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
                                                    $newslink_nasional= json_decode($dg->media_nasional);
                                                    $counting2 = 0;
                                                @endphp
                                                @php
                                                    foreach ($newslink_nasional as $ix=>$dx){
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