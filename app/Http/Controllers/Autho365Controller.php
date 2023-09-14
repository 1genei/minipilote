<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class Autho365Controller extends Controller
{

    /**
     * Redirige sur la page d'authentification
     */
    public function login()
    {

        // https://portal.azure.com

        $authUrl = 'https://login.microsoftonline.com/common/oauth2/v2.0/authorize';

        $query = http_build_query([
            'client_id' => config('services.o365.client_id'),
            'response_type' => 'code',
            'redirect_uri' => config('services.o365.redirect'),
            'scope' => 'User.Read',
            // 'scope' => 'User.Read Team.ReadBasic.All Channel.ReadBasic.All offline_access'

        ]);

        return Redirect::away($authUrl . '?' . $query);
    }

    /**
     * Redirection après l'authentifaction, afin de logger l'utilisateur
     */
    public function redirect()
    {

        try {
            $tokenUrl = 'https://login.microsoftonline.com/common/oauth2/v2.0/token';

            $params = [
                'grant_type' => 'authorization_code',
                'client_id' => config('services.o365.client_id'),
                'client_secret' => config('services.o365.client_secret'),
                'redirect_uri' => config('services.o365.redirect'),
                'code' => request()->code,
            ];

            $response = \Http::asForm()->post($tokenUrl, $params);

            $accessToken = $response->json()['access_token'];

            // Appel à l'API Microsoft Graph pour récupérer les informations de l'utilisateur
            $graphApiUrl = 'https://graph.microsoft.com/v1.0/me';
            $response = \Http::withToken($accessToken)->get($graphApiUrl);
            $userData = $response->json();
 

            // Récupération des informations spécifiques de l'utilisateur
            // $displayName = $userData['displayName'];
            $email = $userData['mail'];

            // dd($userData);
            $user = User::where('email', $email)->first();

            if (Auth::loginUsingId($user->id)) {
                return redirect('/dashboard');
            }
            return redirect('login')->with('error', 'Vous n\'êtes pas autorisé à vous connecter. Veuillez contacter l\'administrateur ! #err001');

        } catch (\Throwable $th) {

            return redirect('login')->with('error', 'Vous n\'êtes pas autorisé à vous connecter. Veuillez contacter l\'administrateur ! #err002');
        }

    }
}
