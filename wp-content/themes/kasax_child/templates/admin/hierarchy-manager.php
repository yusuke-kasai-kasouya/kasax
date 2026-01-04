<?php
/**
 * 管理画面表示用テンプレート
 * @var array $stats コントローラーから渡された統計データ
 */
?>
<div class="wrap kx-admin-wrap">
    <h1>物語制作支援システム『kasax_child』管理パネル</h1>
    <hr>

    <div class="welcome-panel">
        <div class="welcome-panel-content">
            <h2>システム整合性ステータス</h2>
            <p class="about-description">階層構造と独自データベースの稼働状況です。</p>

            <div style="display: flex; gap: 20px; margin-top: 20px;">
                <div style="background: #fff; padding: 20px; border-radius: 8px; flex: 1; border-left: 4px solid #2271b1;">
                    <strong>総ノード数（wp_kx_hierarchy）</strong>
                    <p style="font-size: 2em; margin: 10px 0;"><?php echo number_format($stats['total_nodes']); ?> <span style="font-size: 0.5em;">items</span></p>
                </div>
                <div style="background: #fff; padding: 20px; border-radius: 8px; flex: 1; border-left: 4px solid #d63638;">
                    <strong>仮想ノード（実体なし）</strong>
                    <p style="font-size: 2em; margin: 10px 0;"><?php echo number_format($stats['virtual_nodes']); ?> <span style="font-size: 0.5em;">items</span></p>
                </div>
                <div style="background: #fff; padding: 20px; border-radius: 8px; flex: 1; border-left: 4px solid #646970;">
                    <strong>最終同期日時</strong>
                    <p style="font-size: 1.2em; margin: 10px 0;"><?php echo esc_html($stats['last_sync']); ?></p>
                </div>
            </div>
        </div>
    </div>

    <div class="postbox" style="margin-top: 20px;">
        <div class="postbox-header"><h2 class="hndle">クイックメンテナンス</h2></div>
        <div class="inside">
            <p>階層構造の再スキャンや、仮想ノードの一括クリーンアップを実行します。</p>
            <button class="button button-primary button-large" disabled>全階層の完全同期実行（準備中）</button>
            <button class="button button-secondary button-large" disabled>JSONマスタ整合性チェック（準備中）</button>
        </div>
    </div>
</div>

<style>
    .kx-admin-wrap h1 { font-family: 'serif'; font-weight: bold; }
    /* assets/css/modules/admin-dashboard.css へ移行予定 */
</style>