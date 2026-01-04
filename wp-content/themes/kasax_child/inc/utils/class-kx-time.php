<?php
namespace Kx\Utils;

/**
 * 時間管理クラス
 */
class Time {

    /**
     * 時間の取得と整形（力技＋正規指定のハイブリッド版）
     * * @param string $type   'tokyo' (固定+9h), または 'Asia/Tokyo', 'UTC' 等の正式名称
     * @param string|null $format フォーマット。NULL指定ならタイムスタンプ(数値)を返す。
     * @return string|int
     */
    public static function format($type = 'tokyo', $format = "Y/m/d H:i:s") {

        $type = $type ?: 'tokyo';

        // 1. 「tokyo」の場合は、これまでの力技（絶対計算）を適用
        if ($type === 'tokyo') {
            $timestamp = time() + (9 * 60 * 60);
        }
        // 2. それ以外（Asia/TokyoやUTC等）は、正式なタイムゾーンとして処理を試みる
        else {
            try {
                // 有効なタイムゾーン名であれば、その地点の時間を取得
                $tz = new \DateTimeZone($type);
                $dt = new \DateTime('now', $tz);
                $timestamp = $dt->getTimestamp();
            } catch (\Exception $e) {
                // 不正な文字列が渡された場合は、安全策としてサーバー標準時(UTC)を返す
                $timestamp = time();
            }
        }

        // 3. 出力判定：フォーマットが指定されていれば文字列、NULLなら数値を返す
        return $format ? date($format, $timestamp) : $timestamp;
    }
}