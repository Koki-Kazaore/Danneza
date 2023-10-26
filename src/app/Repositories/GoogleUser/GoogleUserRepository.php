<?php

namespace App\Repositories\GoogleUser;

use App\Models\GoogleUser;
use App\Models\User;
use Carbon\Carbon;

class GoogleUserRepository implements GoogleUserRepositoryInterface
{
    /**
     * google_usersテーブルにユーザー情報を保存または更新します。
     *
     * @param User $user ローカルデータベースのユーザーモデル
     * @param \Laravel\Socialite\Contracts\User $googleUser Socialiteを通じて取得したGoogleユーザー情報
     * @return GoogleUser 作成または更新されたGoogleユーザー情報
     */
    public function updateOrCreateGoogleUser($user, $googleUser)
    {
        $googleUserData = [
            'user_id' => $user->id,
            'google_id' => $googleUser->getId(),
            'avatar' => $googleUser->getAvatar(),
            'token' => $googleUser->token,
            'refresh_token' => $googleUser->refreshToken,
            'expires_at' => Carbon::now()->addSeconds($googleUser->expiresIn)
        ];

        return GoogleUser::updateOrCreate(
            ['user_id' => $user->id],
            $googleUserData
        );
    }
}