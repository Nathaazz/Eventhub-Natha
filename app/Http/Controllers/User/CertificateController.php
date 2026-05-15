<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CertificateController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | CERTIFICATE LIST
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $certificates = Certificate::with([

                'event'

            ])

            ->where(

                'user_id',

                Auth::id()

            )

            ->when(

                $request->search,

                function ($query) use ($request) {

                    $query->whereHas(

                        'event',

                        function ($event) use ($request) {

                            $event->where(

                                'title',

                                'like',

                                '%' .
                                $request->search .
                                '%'

                            );

                        }

                    );

                }

            )

            ->latest()

            ->paginate(10);

        return view(

            'user.certificate.index',

            compact('certificates')

        );
    }

    /*
    |--------------------------------------------------------------------------
    | DOWNLOAD CERTIFICATE
    |--------------------------------------------------------------------------
    */

    public function download($certificateNumber)
    {

        /*
        |--------------------------------------------------------------------------
        | FIND CERTIFICATE
        |--------------------------------------------------------------------------
        */

        $certificate = Certificate::where(

                'certificate_number',

                $certificateNumber

            )

            ->where(

                'user_id',

                Auth::id()

            )

            ->firstOrFail();

        /*
        |--------------------------------------------------------------------------
        | AUTO FIX FILE PATH
        |--------------------------------------------------------------------------
        */

        if (!$certificate->file_path) {

            $certificate->file_path =

                'certificates/' .

                $certificate->certificate_number .

                '.pdf';

            $certificate->save();

            $certificate->refresh();
        }

        /*
        |--------------------------------------------------------------------------
        | REAL FILE PATH
        |--------------------------------------------------------------------------
        */

        $path = storage_path(

            'app/public/' .

            ltrim(

                $certificate->file_path,

                '/'

            )

        );

        /*
        |--------------------------------------------------------------------------
        | FILE NOT FOUND
        |--------------------------------------------------------------------------
        */

        if (!file_exists($path)) {

            return back()->with(

                'error',

                'File sertifikat tidak ditemukan'

            );
        }

        /*
        |--------------------------------------------------------------------------
        | DOWNLOAD FILE
        |--------------------------------------------------------------------------
        */

        return response()->download(

            $path,

            basename($path)

        );
    }
}