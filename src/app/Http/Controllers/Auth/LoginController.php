<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\GoogleUser\GoogleUserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    /** @var GoogleUserRepositoryInterface */
    private $googleUserRepo;

    public function __construct(GoogleUserRepositoryInterface $googleUserRepository)
    {
        $this->googleUserRepo = $googleUserRepository;
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')
        ->scopes(['https://www.googleapis.com/auth/fitness.activity.read'])
        ->redirect();
    }

    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

        // すでに登録されているか確認
        $user = User::whereEmail($googleUser->getEmail())->first();
        if (!$user) {
            $user = $this->createUserByGoogle($googleUser);
        }

        // google_usersテーブルに情報を保存
        $googleAccount = $this->googleUserRepo->updateOrCreateGoogleUser($user, $googleUser);

        // ログイン処理
        Auth::login($user, $remember = true);
        return redirect('/steps');
    }

    public function createUserByGoogle($googleUser)
    {
        $user = User::create([
            'name'     => $googleUser->name,
            'email'    => $googleUser->email,
        ]);
        return $user;
    }

    public function logout(Request $request)
    {
        // ユーザーをログアウトさせる
        Auth::logout();

        // セッションを再生成する
        $request->session()->regenerate();

        // トップページにリダイレクト
        return redirect('/');
    }
}