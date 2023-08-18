<?php

namespace App\Http\Controllers;
use App\Models\JenisUmkm;
use App\Models\JenisUsaha;
use App\Models\Province;
use App\Models\City;
use App\Models\M_Wilayah_Binaan;
use App\Models\M_Fasilitator;
use App\Models\M_user_old;
use App\Models\NewQuestionerUpload;
use App\Models\newAnswerPostest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;


class OldPortalController extends Controller
{
    public function showUmkm(Request $request)
    {

        if ($request->ajax()) {
            $data = M_user_old::with(['province', 'jenis_usaha', 'jenis_umkm', 'resultQuestion'])
                ->where('status_hapus', 0)->orderBy('created_at', 'DESC');
            // $data = m_User::query();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('jenis_usaha', function ($data) {
                    return $data->produk;
                })
                ->addColumn('jenis_umkm', function ($data) {
                    return $data->jenis_umkm != null ? $data->jenis_umkm->nama_jenis_umkm : '';
                })
                ->addColumn('provinsi', function ($data) {
                    return $data->province
                        ? $data->province->NAMA_PROP
                        : '';
                })
                ->editColumn('kontak', function ($data) {
                    return $data->kontak
                        ? $data->kontak
                        : '-';
                })
                ->editColumn('nik', function ($data) {
                    return $data->nik
                        ? $data->nik
                        : '-';
                })

                ->make(true);
        }
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = M_user_old::query()
                ->leftJoin('m_provinsi_old', 'm_provinsi_old.kode', '=', 'm_users.kode_prop')
                ->leftJoin('m_jenis_usaha', 'm_jenis_usaha.id', '=', 'm_users.m_jenis_usaha_id')
                ->leftJoin('m_jenis_umkm', 'm_jenis_umkm.id', '=', 'm_users.m_jenis_umkm_id')
                ->with(['province', 'jenis_usaha', 'jenis_umkm', 'resultQuestion',  'wilayah_bina', 'fasilitator'])
                ->where('m_users.status_hapus', 0)
                ->select(
                    'm_users.id',
                    'm_users.is_accept',
                    'm_users.email',
                    'm_users.nama_pelapak',
                    'm_users.nama_toko',
                    'm_users.kontak',
                    'm_users.nik',
                    'm_users.nama_fasil',
                    'm_users.wilayah_binaan',
                    'm_provinsi_old.NAMA_PROP',
                    'm_jenis_usaha.nama_jenis_usaha',
                    'm_jenis_umkm.nama_jenis_umkm',
                    // 'resultquestioners.level_umkm',
                );

            $level = $request->get('level');

            $levelPostest = $request->get('level_postest');

            $resultPostest = $request->get('result_postest');

            if ($request->has('level') && $level !== null && $level !== "") {
                $data->whereHas('resultQuestion', function ($query2) use ($level) {
                    $query2->where('level_umkm', $level);
                });
            }

            if ($request->has('level_postest') && $levelPostest !== null && $levelPostest !== "") {
                $data->whereHas('resultQuestion', function ($query2) use ($levelPostest) {
                    $query2->where('level_umkm_postest', $levelPostest);
                });
            }
            if ($request->has('result_postest') && $resultPostest !== null && $resultPostest !== "") {
                $data->whereHas('resultQuestion', function ($query2) use ($resultPostest) {
                    $query2->where('result_postest', $resultPostest);
                });
            }

            $wilayahBinaan = $request->get('wilayah_binaan');
            if ($request->has('wilayah_binaan') && $wilayahBinaan !== null && $wilayahBinaan !== "") {
                $data->whereHas('wilayah_bina', function ($query2) use ($wilayahBinaan) {
                    $query2->where('id', $wilayahBinaan);
                });
            }

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('m_jenis_umkm_id', function ($data) {
                    return $data->nama_jenis_umkm != null ? $data->nama_jenis_umkm : '';
                })
                ->editColumn('kontak', function ($data) {
                    return $data->kontak != null ? $data->kontak : '-';
                })
                ->editColumn('nik', function ($data) {
                    return $data->nik != null ? $data->nik : '-';
                })
                ->addColumn('provinsi', function ($data) {
                    return $data->NAMA_PROP
                        ? $data->NAMA_PROP
                        : '';
                })
                ->addColumn('is_accept', function ($data) {
                    return ($data->resultQuestion !== null) ? view('layouts.dtAction-umkm', compact('data'))->render() : '<span class="badge badge-pill badge-warning"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-excel" viewBox="0 0 16 16">
        <path d="M5.884 6.68a.5.5 0 1 0-.768.64L7.349 10l-2.233 2.68a.5.5 0 0 0 .768.64L8 10.781l2.116 2.54a.5.5 0 0 0 .768-.641L8.651 10l2.233-2.68a.5.5 0 0 0-.768-.64L8 9.219l-2.116-2.54z"/>
        <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5v2z"/>
        </svg> belum lengkap</span>';
                })
                // note: Dont do this when u need to use global search
                // ->filter(function ($query) use ($request) {
                //     $level = $request->get('level');
                //     if ($request->has('level') && $level !== null && $level !== "") {
                //         $query->whereHas('resultQuestion', function ($query2) use ($level) {
                //             $query2->where('level_umkm', $level);
                //         });
                //     }

                //     $wilayahBinaan = $request->get('wilayah_binaan');
                //     if ($request->has('wilayah_binaan') && $wilayahBinaan !== null && $wilayahBinaan !== "") {
                //         $query->whereHas('wilayah_bina', function ($query2) use ($wilayahBinaan) {
                //             $query2->where('id', $wilayahBinaan);
                //         });
                //     }
                // })
                ->addColumn('action', 'layouts.dt-action-manage-umkm')
                ->rawColumns(['action', 'is_accept'])
                ->make(true);
        }

        // $dataku = m_User::with(['province', 'jenis_usaha', 'jenis_umkm', 'resultQuestion'])->get();
        $jenis_umkm = JenisUmkm::latest()->get();
        $jenis_usaha = JenisUsaha::latest()->get();
        $wilayah_binaan = m_Wilayah_Binaan::where('status_aktif', 1)->orderBy('wilayah_binaan', 'ASC')->get();
        $provinces = Province::all();
        $cities = City::all();
        // return $wilayah_binaan;
        // return $dataku;

        return view('old-portal-list', compact(
            'jenis_umkm',
            'jenis_usaha',
            'provinces',
            'cities',
            'wilayah_binaan'
        ));
    }
}
