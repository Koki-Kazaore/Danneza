<?php

namespace App\Repositories\GoogleUser;

use App\Models\GoogleUser;
use App\Models\User;

interface GoogleUserRepositoryInterface
{
    /**
     * google_usersテーブルにユーザー情報を保存または更新します。
     *
     * @param User $user ローカルデータベースのユーザーモデル
     * @param \Laravel\Socialite\Contracts\User $googleUser Socialiteを通じて取得したGoogleユーザー情報
     * @return GoogleUser 作成または更新されたGoogleユーザー情報
     */
    public function updateOrCreateGoogleUser($user, $googleUser);
}