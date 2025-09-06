<?php

namespace App\Libraries;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Relations\Relation;

class Utility {
    /**
     * Ambil nilai dari array atau model dengan memperhatikan
     * serializedDate di model.
     *
     * @param  array|Model  $target
     * @param  string|int  $key
     * @param  mixed  $default
     * @return mixed
     */
    static function arrGet($target, $key, $default = null)
    {
        if ($key === null || $key === '') {
            return $default;
        }

        // Jika target adalah Model atau Eloquent Collection
        if ($target instanceof Model || $target instanceof EloquentCollection) {
            // Tentukan jalur relasi dari key (mis. "transaction.customer" dari "transaction.customer.name")
            $relationPath = self::_arrGet_extractRelationPath($target, $key);

            if ($relationPath) {
                // loadMissing mendukung nested relations, aman untuk Model & Eloquent Collection
                $target->loadMissing($relationPath);
            }

            // Serialize ke array lalu ambil nilainya
            return data_get($target->toArray(), $key, $default);
        }

        // Non-model: langsung pakai data_get
        return data_get($target, $key, $default);
    }

    /**
     * Dari key dot-notation, ambil bagian yang merupakan jalur relasi bertingkat.
     * Contoh: "transaction.customer.name" -> "transaction.customer"
     */
    static function _arrGet_extractRelationPath($target, string $key): ?string
    {
        // Ambil satu contoh model untuk probing jika $target adalah koleksi
        $probe = $target instanceof EloquentCollection ? ($target->first() ?: null) : $target;
        if (! $probe instanceof Model) {
            return null;
        }

        $segments = explode('.', $key);
        $path = [];
        $current = $probe;

        foreach ($segments as $seg) {
            // Hentikan kalau segmen indeks numerik/wildcard atau bukan Model lagi
            if (! $current instanceof Model || $seg === '*' || ctype_digit($seg)) {
                break;
            }

            // Jika ada method dengan nama segmen dan itu adalah relasi Eloquent
            if (method_exists($current, $seg)) {
                $rel = $current->{$seg}(); // ini hanya membangun Relation, belum query DB
                if ($rel instanceof Relation) {
                    $path[] = $seg;
                    // Bergerak ke model terkait untuk cek segmen berikutnya
                    // Catatan: untuk MorphTo kita berhenti di sini karena tipe relasinya dinamis
                    if (method_exists($rel, 'getRelated')) {
                        $current = $rel->getRelated();
                        continue;
                    }
                }
            }

            // Begitu ketemu segmen yang bukan relasi, stop
            break;
        }

        return $path ? implode('.', $path) : null;
    }
}