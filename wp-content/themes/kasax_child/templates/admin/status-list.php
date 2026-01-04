<?php
/**
 * ステータス一覧 テンプレート
 */
if (!defined('ABSPATH')) exit;
?>

<div class="wrap">
    <h1 class="wp-heading-inline">ステータス一覧</h1>
    <hr class="wp-header-end">

    <div class="card" style="max-width: 100%; margin-top: 20px;">
        <h2>現在のシステムステータス</h2>
        <p>ここでは物語制作支援システムの各ノードの進捗や状態を一覧で確認できます。</p>

        <table class="wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">階層名</th>
                    <th scope="col">ステータス</th>
                    <th scope="col">最終更新</th>
                    <th scope="col">操作</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td><strong>プロット第1章</strong></td>
                    <td><span class="badge" style="background:#dff0d8; padding:3px 8px; border-radius:3px;">完了</span></td>
                    <td>2024-05-20</td>
                    <td><a href="#" class="button button-small">詳細</a></td>
                </tr>
                <tr>
                    <td>2</td>
                    <td><strong>キャラクター設定</strong></td>
                    <td><span class="badge" style="background:#fcf8e3; padding:3px 8px; border-radius:3px;">執筆中</span></td>
                    <td>2024-05-24</td>
                    <td><a href="#" class="button button-small">詳細</a></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<style>
    .wrap .card {
        padding: 15px;
        background: #fff;
        border: 1px solid #ccd0d4;
        box-shadow: 0 1px 1px rgba(0,0,0,.04);
    }
</style>