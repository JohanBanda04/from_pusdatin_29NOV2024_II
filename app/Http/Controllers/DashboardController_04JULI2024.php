<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $hariini = date('Y-m-d');
        $bulanini = date('m') * 1;
        $tahunini = date('Y');
        $nik = Auth::guard('karyawan')->user()->nik;
        $presensihariini = DB::table('presensi')->where('nik', $nik)->where('tgl_presensi', $hariini)->first();
        $historibulanini = DB::table('presensi')
            ->where('nik', $nik)
            ->whereRaw('MONTH(tgl_presensi)="' . $bulanini . '"')
            ->whereRaw('YEAR(tgl_presensi)="' . $tahunini . '"')
            ->orderBy('tgl_presensi')
            ->get();

        $rekappresensi = DB::table('presensi')
            ->selectRaw('COUNT(nik) as jmlhadir, SUM(IF(jam_in > "07:00:00",1,0)) as jmlterlambat')
            ->where('nik', $nik)
            ->whereRaw('MONTH(tgl_presensi)="' . $bulanini . '"')
            ->whereRaw('YEAR(tgl_presensi)="' . $tahunini . '"')
            ->first();

        $leaderboard = DB::table('presensi')
            ->join('karyawan', 'presensi.nik', '=', 'karyawan.nik')
            ->where('tgl_presensi', $hariini)
            ->orderBy('jam_in')
            ->get();

        //dd($rekappresensi);
        $namabulan = [
            "",
            "Januari",
            "Februari",
            "Maret",
            "April",
            "Mei",
            "Juni",
            "Juli",
            "Agustus",
            "September",
            "Oktober",
            "November",
            "Desember",
        ];

        $rekapizin = DB::table('pengajuan_izin')
            ->selectRaw('SUM(IF(status="i",1,0)) as jmlizin,SUM(IF(status="s",1,0)) as jmlsakit')
            ->where('nik', $nik)
            ->whereRaw('MONTH(tgl_izin)="' . $bulanini . '"')
            ->whereRaw('YEAR(tgl_izin)="' . $tahunini . '"')
            ->where('status_approved', 1)
            ->first();
        //dd($namabulan[$bulanini]);

        //dd($historibulanini);
        return view('dashboard.dashboard', compact('presensihariini',
            'historibulanini', 'namabulan',
            'bulanini', 'tahunini', 'rekappresensi',
            'leaderboard', 'rekapizin'));
    }

    public function dashboardadmin()
    {
        $hariini = date('Y-m-d');
        $rekappresensi = DB::table('presensi')
            ->selectRaw('COUNT(nik) as jmlhadir, SUM(IF(jam_in > "07:00:00",1,0)) as jmlterlambat')
            ->where('tgl_presensi', $hariini)
            ->first();

        $rekapizin = DB::table('pengajuan_izin')
            ->selectRaw('SUM(IF(status="i",1,0)) as jmlizin,SUM(IF(status="s",1,0)) as jmlsakit')
            ->where('tgl_izin', $hariini)
            ->where('status_approved', 1)
            ->first();
        return view('dashboard.dashboardadmin', compact('rekappresensi', 'rekapizin'));
    }

    public function dashboardsatker(Request $request)
    {

        //echo "ini dashboard broyy"; die;
        //return $request->dari;
        $queryBerita = DB::table('berita');
        $queryKonfig = DB::table('konfigurasi_berita');
        //return $queryGetSatkerAll[0]->name;

        if (auth()->user()->roles != 'superadmin') {
            $queryBerita->where('kode_satker', auth()->user()->kode_satker);
            $queryKonfig->where('kode_satker', auth()->user()->kode_satker);
        }

        /*default sebelum dilakukan filter tanggal untuk admin dari sini*/
        $tgl_dari_default = date('Y-m-d', strtotime('-1 week'));
        $tgl_sampai_default = date('Y-m-d');

        /*langsung intervensi di sini saja untuk tanggal nya bro jo*/
        if (!empty($request->dari) && !empty($request->sampai)) {
            //return $request;
            $tgl_dari_default = $request->dari;
            $tgl_sampai_default = $request->sampai;
        }


        //echo $tgl_dari_default; die;

        /*24-04-2024 data untuk dashboard humas satker*/
        /*=================*/
        /*23-04-2024 data untuk dashboard humas kanwil*/
        if (auth()->user()->roles == 'humas_kanwil' || auth()->user()->roles == 'humas_satker') {
            //echo "dashboard humas kanwil broy"; die;
            $data_zonaAll_Kanwil = ['Website', 'Sosial Media', 'Media Lokal', 'Media Nasional'];
            $data_zonaAll_Media = DB::table('mediapartner')->get();
            $counter_media = 0;
            foreach ($data_zonaAll_Media as $indmed => $valmed) {
                $get_nama_humas = DB::table('satker')->where('kode_satker', $valmed->kode_satker_penjalin)->first();
                //echo "<pre>"; print_r($valmed)."<br>";
                //echo $get_nama_humas->name."<br>";
                //$kode_media_with_penjalin =
                $zona_media_list_ii[$counter_media] = $valmed->name." (".$get_nama_humas->name.")";
                $zona_kodemedia_list_ii[$counter_media] = $valmed->kode_media;

                $counter_media++;
            }
            //die;

            $counter_jenis_publikasi = 0;
            $counter_kanwil = 0;
            $kode_satker_humas_kanwil = auth()->user()->kode_satker;
            $getSatkerByKode = DB::table('satker')->where('kode_satker', $kode_satker_humas_kanwil)->first();
            $explode_role = explode('_', $getSatkerByKode->roles);
            $complete_humas_role = ucfirst($explode_role[0]) . " " . ucfirst($explode_role[1]);
            $completeNameRole = "(" . $getSatkerByKode->name . "-" . $complete_humas_role . ")";

            /*untuk mendapatkan xAxis pada Dashboard Humas Kanwil*/
            foreach ($data_zonaAll_Kanwil as $idx => $val) {
                $nama_zona_publikasi[$counter_jenis_publikasi] = $val;
                $nama_zona_publikasi_angka[$counter_jenis_publikasi] = $val;
                $counter_jenis_publikasi++;
            }
            /*prityy*/
            //echo "<pre>"; print_r($nama_zona_publikasi); die;

            /*untuk mendapatkan total berita pada website humas kanwil*/
            foreach ($data_zonaAll_Kanwil as $idx => $val) {
                if ($val == 'Website') {
                    $tbl_berita_by_publikasi = DB::select(DB::raw("select count(website) as jml_berita from berita
where kode_satker='$kode_satker_humas_kanwil' and website!='' AND tgl_input between '$tgl_dari_default' and '$tgl_sampai_default'"));
                    $publikasi_id[$counter_kanwil] = $tbl_berita_by_publikasi[0]->jml_berita;
                    $publikasi_id_angka[$counter_kanwil] = $tbl_berita_by_publikasi[0]->jml_berita;

                    //echo "<pre>"; print_r($tbl_berita_by_publikasi); die;
                }
            }

            //echo $counter_kanwil; die;
            //celah nambah indeks brojo dan seterusnya kebawah
            $counter_kanwil += 1;
            $publikasi_id[$counter_kanwil] = 0;
            $publikasi_id_angka[$counter_kanwil] = 0;
            /*untuk mendapatkan total berita pada sosmed humas kanwil*/
            foreach ($data_zonaAll_Kanwil as $idx => $val) {
                if ($val == 'Sosial Media') {
                    $tbl_berita_by_publikasi_facebook = DB::select(DB::raw("select count(facebook) as jml_berita_facebook from berita
where kode_satker='$kode_satker_humas_kanwil' and facebook!='' AND tgl_input between '$tgl_dari_default' and '$tgl_sampai_default'"));

                    //echo $tgl_dari_default."<br>";
                    //echo $tgl_sampai_default."<br>";
                    //echo "<pre>"; print_r($tbl_berita_by_publikasi_facebook);die;
                    $tbl_berita_by_publikasi_instagram = DB::select(DB::raw("select count(instagram) as jml_berita_instagram from berita
where kode_satker='$kode_satker_humas_kanwil' and instagram!='' AND tgl_input between '$tgl_dari_default' and '$tgl_sampai_default'"));

                    $tbl_berita_by_publikasi_twitter = DB::select(DB::raw("select count(twitter) as jml_berita_twitter from berita
where kode_satker='$kode_satker_humas_kanwil' and twitter!='' AND tgl_input between '$tgl_dari_default' and '$tgl_sampai_default'"));

                    $tbl_berita_by_publikasi_tiktok = DB::select(DB::raw("select count(tiktok) as jml_berita_tiktok from berita
where kode_satker='$kode_satker_humas_kanwil' and tiktok!='' AND tgl_input between '$tgl_dari_default' and '$tgl_sampai_default'"));

                    $tbl_berita_by_publikasi_youtube = DB::select(DB::raw("select count(youtube) as jml_berita_youtube from berita
where kode_satker='$kode_satker_humas_kanwil' and youtube!='' AND tgl_input between '$tgl_dari_default' and '$tgl_sampai_default'"));

                    $total_link_sosmed = ($tbl_berita_by_publikasi_facebook[0]->jml_berita_facebook)
                        + ($tbl_berita_by_publikasi_instagram[0]->jml_berita_instagram) +
                        ($tbl_berita_by_publikasi_twitter[0]->jml_berita_twitter) +
                        ($tbl_berita_by_publikasi_tiktok[0]->jml_berita_tiktok) +
                        ($tbl_berita_by_publikasi_youtube[0]->jml_berita_youtube);
                    /*total utk link sippn belum dimasukin ke dalam total link sosmed*/

                    $publikasi_id[$counter_kanwil] = $total_link_sosmed;
                    $publikasi_id_angka[$counter_kanwil] = $total_link_sosmed;
                }
            }

            //echo $total_link_sosmed; die;

            $counter_kanwil += 1;
            $publikasi_id[$counter_kanwil] = 0;
            $publikasi_id_angka[$counter_kanwil] = 0;
            /*untuk mendapatkan total berita pada media lokal humas kanwil*/
            foreach ($data_zonaAll_Kanwil as $idx => $val) {
                if ($val == 'Media Lokal') {
                    $getberita = DB::table('berita')
                        ->where('kode_satker', $kode_satker_humas_kanwil)
                        ->whereBetween('tgl_input', [$tgl_dari_default, $tgl_sampai_default])
                        ->get();
                    $total_medlok = 0;

                    //echo "<pre>"; print_r($getberita); die;
                    foreach ($getberita as $id => $dtberita) {
                        if ($dtberita->media_lokal != "") {
                            //echo print_r(json_decode($dtberita->media_lokal));
                            //echo count(json_decode($dtberita->media_lokal))."<br>";
                            $links_media_lokal = json_decode($dtberita->media_lokal);
                            $sum_medlok = count($links_media_lokal);
                            $total_medlok += $sum_medlok;
                        } else if ($dtberita->media_lokal == "") {
                            //$links_media_lokal = json_decode($dtberita->media_lokal);
                            $sum_medlok = 0;
                            $total_medlok += $sum_medlok;
                        }
                        //$total_medlok += $sum_medlok;

                    }
                    //echo "jml total medlok :".$total_medlok;

                    //die;
                    $publikasi_id[$counter_kanwil] = $total_medlok;
                    $publikasi_id_angka[$counter_kanwil] = $total_medlok;
                    //echo $total_medlok;
                    //die;
                }
            }

            $counter_kanwil += 1;
            $publikasi_id[$counter_kanwil] = 0;
            $publikasi_id_angka[$counter_kanwil] = 0;
            /*untuk mendapatkan total berita pada media nasional humas kanwil*/
            foreach ($data_zonaAll_Kanwil as $idx => $val) {
                if ($val == 'Media Nasional') {
                    $getberita = DB::table('berita')
                        ->where('kode_satker', $kode_satker_humas_kanwil)
                        ->whereBetween('tgl_input', [$tgl_dari_default, $tgl_sampai_default])
                        ->get();
                    $total_mednas = 0;
                    foreach ($getberita as $id => $dtberita) {
                        if ($dtberita->media_nasional != "") {
                            $links_media_nasional = json_decode($dtberita->media_nasional);
                            $sum_mednas = count($links_media_nasional);
                            $total_mednas += $sum_mednas;
                        } else if ($dtberita->media_nasional == "") {
                            //$links_media_nasional = json_decode($dtberita->media_nasional);
                            $sum_mednas = 0;
                            $total_mednas += $sum_mednas;
                        }
                        //$total_mednas += $sum_mednas;

                    }
                    $publikasi_id[$counter_kanwil] = $total_mednas;
                    $publikasi_id_angka[$counter_kanwil] = $total_mednas;
                    //echo $total_mednas;
                    //die;

                }
            }

            /*UNTUK NGETES VALUE SETELAH DITAMPUNG KE ARRAY $publikasi_id*/
//            foreach ($publikasi_id as $indx=>$nilai){
//                echo $nilai."<br>";
//            }
//            die;

            /*UNTUK NGETES VALUE ORIGINAL*/
//            echo "total website : ".$tbl_berita_by_publikasi[0]->jml_berita."<br>";
//
//            echo "total link sosmed : ".$total_link_sosmed."<br>";
//
//            echo "total link medlok : ".$total_medlok."<br>";
//
//            echo "total mednas : ".$total_mednas;
//
//            die;

            $tot_kanwil = 0;
            $tot_kanwil_angka = 0;
            foreach ($publikasi_id as $pid) {
                $tot_kanwil += $pid;
            }

            foreach ($publikasi_id_angka as $pid_angka) {
                $tot_kanwil_angka += $pid_angka;
            }
            //echo "total berita website, sosmed, medlok, mednas : ".$tot_kanwil;die;
            $zona_publikasi_list_ii_kanwil = $nama_zona_publikasi;
            $zona_publikasi_list_ii_kanwil_angka = $nama_zona_publikasi_angka;
            $realisasi_publikasi_kanwil_total = $publikasi_id;
            $realisasi_publikasi_kanwil_total_angka = $publikasi_id_angka;
            $total_kanwil = $tot_kanwil;
            $total_kanwil_angka = $tot_kanwil_angka;
        }
        /*==================*/
        //echo "<pre>"; print_r($zona_publikasi_list_ii_kanwil); die;
        //echo "<pre>"; print_r($zona_publikasi_list_ii_kanwil_angka); die;

        /*analisa lanjutkan disini brojo*/
        /*default data*/
        $queryBeritaGrafikJumlah = DB::select(DB::raw("select count(*) as jml_berita from berita
where tgl_input BETWEEN '$tgl_dari_default' and '$tgl_sampai_default' group by kode_satker"));
        $queryBeritaGrafikKode = DB::select(DB::raw("select kode_satker from berita
where tgl_input BETWEEN '$tgl_dari_default' and '$tgl_sampai_default' group by kode_satker"));

        $counter = 0;
        $total = 0;
        $queryGetSatkerAll = DB::table('satker')->orderBy('kode_satker')->get();

        foreach ($queryGetSatkerAll as $key => $satker) {
            if ($satker->roles != "superadmin") {
                //echo "default dashboard tanpa isian filter tgl broy"; die;
                $tbl_berita_by_satker = DB::table('berita')->where('kode_satker', $satker->kode_satker);
                $satker_id[$counter] = $tbl_berita_by_satker->count();

                $explode_humas_role = explode('_', $satker->roles);
                if (isset($explode_humas_role[1])) {
                    //echo "non superadmin";
                    $complete_role = ucfirst($explode_humas_role[0]) . " " . ucfirst($explode_humas_role[1]);
                } else if (!isset($explode_humas_role[1])) {
                    //echo "superadmin";
                    $complete_role = ucfirst($explode_humas_role[0]);
                }
                $nama_satker[$counter] = $satker->name . " (" . $complete_role . ")";
                $nama_satker_angka[$counter] = $satker->name . " (" . $complete_role . ") ";
                $total += $tbl_berita_by_satker->count();
                $counter++;
            }
        }


        /*jika superadmin yagesya :*/
        if (!empty($request->dari) && !empty($request->sampai)) {
            //echo "jika tgl tidak ada kosong broy"; die;
            //return $request;
            $tgl_dari_default = $request->dari;
            $tgl_sampai_default = $request->sampai;

            //echo $tgl_dari_default."|||".$tgl_sampai_default;

            $queryBeritaGrafikJumlah = DB::select(DB::raw("select count(*) as jml_berita from berita
where tgl_input BETWEEN '$tgl_dari_default' and '$tgl_sampai_default' group by kode_satker"));
            $queryBeritaGrafikKode = DB::select(DB::raw("select kode_satker from berita
where tgl_input BETWEEN '$tgl_dari_default' and '$tgl_sampai_default' group by kode_satker"));


            $counter = 0;
            $total = 0;
            $queryGetSatkerAll = DB::table('satker')->orderBy('kode_satker')->get();

            foreach ($queryGetSatkerAll as $key => $satker) {
                if ($satker->roles != "superadmin") {

                    $tbl_berita_by_satker = DB::table('berita')
                        ->where('kode_satker', $satker->kode_satker)
                        ->whereBetween('tgl_input', [$tgl_dari_default, $tgl_sampai_default]);
                    $satker_id[$counter] = $tbl_berita_by_satker->count();

                    $explode_humas_role = explode('_', $satker->roles);
                    if (isset($explode_humas_role[1])) {
                        //echo "non superadmin";
                        $complete_role = ucfirst($explode_humas_role[0]) . " " . ucfirst($explode_humas_role[1]);
                    } else if (!isset($explode_humas_role[1])) {
                        //echo "superadmin";
                        $complete_role = ucfirst($explode_humas_role[0]);
                    }
                    $nama_satker[$counter] = $satker->name . " (" . $complete_role . ")";
                    $total += $tbl_berita_by_satker->count();
                    $counter++;
                }
            }

        }
        //die;
        $realisasi_publikasi_total = $satker_id;
        $realisasi_publikasi_total_angka = $satker_id;
        $total = $total;
        $zona_satker_list_ii = $nama_satker;

        $zona_satker_list_ii_angka = $nama_satker_angka;

        $dtBerita = $queryBerita->get();
        $dtKonfig = $queryKonfig->get();
        $satker = DB::table('satker')->get();

        $total_medlok_humaskanwil = 0;
        $total_mednas_humaskanwil = 0;
        $array_sum_medlok = [];
        if (auth()->user()->roles == "humas_kanwil") {
            //echo "ini humas kanwil";
            $getBeritaLinkMedia = DB::table('berita')
                ->whereBetween('tgl_input', [$tgl_dari_default, $tgl_sampai_default])
                ->get();

            $counter_statushumas = 0;
            $berita_humas = [];
            foreach ($getBeritaLinkMedia as $index_linkmedia => $value_linkmedia) {
                $get_status_humas = DB::table('satker')->where('kode_satker', $value_linkmedia->kode_satker)->get();
                foreach ($get_status_humas as $index_statushumas => $value_statushumas) {
                    if ($value_statushumas->roles == "humas_kanwil") {
                        $berita_humas[$counter_statushumas] = $value_linkmedia;
                    }
                    $counter_statushumas++;
                }
            }
            $array_filterberita = [];

            foreach ($berita_humas as $ind_beritahumas => $val_beritahumas) {
                $medlok_humaskanwil = count(json_decode($val_beritahumas->media_lokal));
                $data_medlok_humaskanwil = json_decode($val_beritahumas->media_lokal);

                $mednas_humaskanwil = count(json_decode($val_beritahumas->media_nasional));
                $data_mednas_humaskanwil = json_decode($val_beritahumas->media_nasional);


                foreach ($data_medlok_humaskanwil as $in_medlokhumaskanwil => $val_medlokhumaskanwil) {
                    array_push($array_filterberita,(object)[
                        'kode_media'=>explode("|||",$val_medlokhumaskanwil)[0]
                    ]);

                }

                $total_medlok_humaskanwil += $medlok_humaskanwil;
                $total_mednas_humaskanwil += $mednas_humaskanwil;

            }


            $get_media = DB::table("mediapartner")->get();
            foreach ($get_media as $in_getmedia => $val_getmedia) {
                $counting_medlok = 0;
                $default_counter = 0;
                foreach ($array_filterberita as $index_filberita=>$val_filberita){
                    //echo $val_filberita->kode_media."<br>";


                    if($val_getmedia->kode_media == $val_filberita->kode_media){
                        $counting_medlok += 1;
                        $array_sum_medlok[$in_getmedia] = $counting_medlok;

                    }
                    if($val_getmedia->kode_media != $val_filberita->kode_media){
                        $counting_medlok += 0;
                        $array_sum_medlok[$in_getmedia] = $counting_medlok;
                    }
                }

            }


        }
        $realisasi_publikasi_total_linkmedia = $array_sum_medlok;
        //echo "<pre>"; print_r($realisasi_publikasi_total_linkmedia); die;
        if (auth()->user()->roles == 'superadmin') {
            //echo "ini dashboard superadmin broyjo"; die;
            return view('dashboard_satker.dashboardsatker', compact('realisasi_publikasi_total_angka', 'zona_satker_list_ii_angka', 'satker'
                , 'dtBerita', 'dtKonfig', 'queryBeritaGrafikJumlah', 'queryBeritaGrafikKode', 'zona_satker_list_ii',
                'realisasi_publikasi_total', 'total', 'tgl_dari_default', 'tgl_sampai_default'));
        } else if (auth()->user()->roles == 'humas_kanwil') {
            //echo "laman dashboard kanwil broyyy"; die;
            //echo "<pre>"; print_r($nama_zona_publikasi); die;
            //echo "return view dashboard humas kanwil broy"; die;
            return view('dashboard_satker.dashboardsatker_kanwil_nonadmin', compact('realisasi_publikasi_total_angka',
                'zona_satker_list_ii_angka', 'satker', 'dtBerita', 'dtKonfig', 'queryBeritaGrafikJumlah', 'queryBeritaGrafikKode', 'zona_satker_list_ii',
                'realisasi_publikasi_total', 'total', 'tgl_dari_default', 'tgl_sampai_default',
                'zona_publikasi_list_ii_kanwil', 'realisasi_publikasi_kanwil_total', 'total_kanwil'
                , 'completeNameRole', 'zona_publikasi_list_ii_kanwil_angka', 'realisasi_publikasi_kanwil_total_angka'
                , 'total_kanwil_angka', 'zona_media_list_ii','realisasi_publikasi_total_linkmedia'));
        } else if (auth()->user()->roles == 'humas_satker') {
            return view('dashboard_satker.dashboardsatker_nonadmin', compact('satker'
                , 'dtBerita', 'dtKonfig', 'tgl_dari_default', 'tgl_sampai_default', 'realisasi_publikasi_total',
                'total', 'zona_satker_list_ii', 'realisasi_publikasi_kanwil_total', 'total_kanwil',
                'zona_publikasi_list_ii_kanwil', 'completeNameRole'));
        }
    }
}
